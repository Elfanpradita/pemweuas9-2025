<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Keranjang;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    public function tambah(Request $request)
    {
        $request->validate([
            'obat_id' => 'required|exists:obats,id',
            'qty' => 'required|integer|min:1',
        ]);

        $user = Auth::user();

        // Tambahkan atau update keranjang
        Keranjang::updateOrCreate(
            ['user_id' => $user->id, 'obat_id' => $request->obat_id],
            ['qty' => DB::raw("qty + {$request->qty}")]
        );

        return redirect('/')->with('success', 'Obat berhasil ditambahkan ke keranjang!');
    }

    public function index()
    {
        $user = Auth::user();
        $items = Keranjang::with('obat')
            ->where('user_id', $user->id)
            ->get();

        $cartCount = Keranjang::where('user_id', $user->id)->sum('qty');

        return view('keranjang.index', compact('items', 'cartCount'));
    }

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

    public function checkout(Request $request)
    {
        $request->validate([
            'metode_pengiriman' => 'required|in:ambil,antar',
            'alamat' => 'nullable|required_if:metode_pengiriman,antar',
        ]);

        $user = Auth::user();
        $items = Keranjang::with('obat')
            ->where('user_id', $user->id)
            ->get();

        if ($items->isEmpty()) {
            return back()->with('error', 'Keranjang masih kosong!');
        }

        DB::beginTransaction();
        try {
            // Hitung total
            $total = 0;
            foreach ($items as $item) {
                $total += $item->qty * $item->obat->harga;

                // Kurangi stok
                $item->obat->decrement('stok', $item->qty);
            }

            // Simpan transaksi
            Transaksi::create([
                'user_id' => $user->id,
                'total' => $total,
                'metode_pengiriman' => $request->metode_pengiriman,
                'alamat' => $request->metode_pengiriman == 'antar' ? $request->alamat : '-',
                'status' => 'pending',
            ]);

            // Hapus keranjang
            Keranjang::where('user_id', $user->id)->delete();

            DB::commit();

            return redirect('/')->with('success', 'Checkout berhasil! Pesanan diproses.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal checkout: ' . $e->getMessage());
        }
    }
}
