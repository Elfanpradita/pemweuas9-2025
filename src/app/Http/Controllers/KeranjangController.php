<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Keranjang;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Mail\TransaksiBerhasilMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

/**
 * @OA\Tag(
 *     name="Keranjang",
 *     description="API untuk mengelola keranjang belanja"
 * )
 */
class KeranjangController extends Controller
{
    /**
     * @OA\Get(
     *     path="/keranjang",
     *     tags={"Keranjang"},
     *     summary="Menampilkan keranjang user",
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil daftar keranjang"
     *     ),
     *     security={{"sanctum":{}}}
     * )
     */
    public function index()
    {
        $user = Auth::user();
        $items = Keranjang::with('obat')->where('user_id', $user->id)->get();
        $cartCount = Keranjang::where('user_id', $user->id)->sum('qty');

        return view('keranjang.index', compact('items', 'cartCount'));
    }

    /**
     * @OA\Post(
     *     path="/keranjang/tambah",
     *     tags={"Keranjang"},
     *     summary="Menambahkan obat ke keranjang",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"obat_id","qty"},
     *             @OA\Property(property="obat_id", type="integer", example=1),
     *             @OA\Property(property="qty", type="integer", example=2)
     *         )
     *     ),
     *     @OA\Response(response=200, description="Obat berhasil ditambahkan ke keranjang"),
     *     @OA\Response(response=400, description="Validasi gagal"),
     *     security={{"sanctum":{}}}
     * )
     */
    public function tambah(Request $request)
    {
        $request->validate([
            'obat_id' => 'required|exists:obats,id',
            'qty' => 'required|integer|min:1',
        ]);

        $user = Auth::user();

        Keranjang::updateOrCreate(
            ['user_id' => $user->id, 'obat_id' => $request->obat_id],
            ['qty' => DB::raw("qty + {$request->qty}")]
        );

        return redirect('/')->with('success', 'Obat berhasil ditambahkan ke keranjang!');
    }

    /**
     * @OA\Delete(
     *     path="/keranjang/hapus/{id}",
     *     tags={"Keranjang"},
     *     summary="Menghapus item dari keranjang",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID item keranjang"
     *     ),
     *     @OA\Response(response=200, description="Item dihapus dari keranjang"),
     *     @OA\Response(response=404, description="Item tidak ditemukan"),
     *     security={{"sanctum":{}}}
     * )
     */
    public function hapus($id)
    {
        $user = Auth::user();
        $item = Keranjang::where('id', $id)->where('user_id', $user->id)->first();

        if ($item) {
            $item->delete();
            return back()->with('success', 'Item dihapus dari keranjang');
        }

        return back()->with('error', 'Item tidak ditemukan');
    }

    /**
     * @OA\Post(
     *     path="/keranjang/checkout",
     *     tags={"Keranjang"},
     *     summary="Checkout keranjang dan membuat transaksi",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"metode_pengiriman"},
     *             @OA\Property(property="metode_pengiriman", type="string", enum={"ambil","antar"}, example="antar"),
     *             @OA\Property(property="alamat", type="string", example="Jl. Mawar No. 10")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Berhasil checkout dan mengembalikan Snap Token Midtrans"),
     *     @OA\Response(response=400, description="Validasi gagal"),
     *     security={{"sanctum":{}}}
     * )
     */
    public function checkout(Request $request)
    {
        $request->validate([
            'metode_pengiriman' => 'required|in:ambil,antar',
            'alamat' => 'nullable|required_if:metode_pengiriman,antar',
        ]);

        $user = Auth::user();
        $items = Keranjang::with('obat')->where('user_id', $user->id)->get();

        if ($items->isEmpty()) {
            return back()->with('error', 'Keranjang masih kosong!');
        }

        DB::beginTransaction();
        try {
            // Hitung total & kurangi stok
            $total = 0;
            foreach ($items as $item) {
                $total += $item->qty * $item->obat->harga;
                $item->obat->decrement('stok', $item->qty);
            }

            $transaksi = Transaksi::create([
                'user_id' => $user->id,
                'total' => $total,
                'metode_pengiriman' => $request->metode_pengiriman,
                'alamat' => $request->metode_pengiriman == 'antar' ? $request->alamat : '-',
                'status' => 'pending',
            ]);

            Keranjang::where('user_id', $user->id)->delete();

            \Midtrans\Config::$serverKey = config('midtrans.server_key');
            \Midtrans\Config::$isProduction = config('midtrans.is_production');
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;

            $params = [
                'transaction_details' => [
                    'order_id' => $transaksi->id . '-' . time(),
                    'gross_amount' => $total,
                ],
                'customer_details' => [
                    'first_name' => $user->name,
                    'email' => $user->email,
                ]
            ];

            $snapToken = \Midtrans\Snap::getSnapToken($params);
            $transaksi->update(['snap_token' => $snapToken]);

            DB::commit();

            Mail::to($user->email)->send(new TransaksiBerhasilMail($transaksi));

            try {
                Http::post(env('WHATSAPP_API_URL'), [
                    'number' => env('WHATSAPP_ADMIN'),
                    'message' => "📢 *Transaksi Baru!*\n\n"
                        . "Nama: {$user->name}\n"
                        . "Total: Rp" . number_format($total) . "\n"
                        . "Metode: {$transaksi->metode_pengiriman}\n"
                        . "Alamat: {$transaksi->alamat}\n"
                        . "Status: {$transaksi->status}"
                ]);
            } catch (\Exception $e) {
                \Log::error("Gagal kirim WA: " . $e->getMessage());
            }

            return view('keranjang.bayar', compact('snapToken', 'transaksi'));
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal checkout: ' . $e->getMessage());
        }
    }
}
