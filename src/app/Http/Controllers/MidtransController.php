<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Mail\TransaksiBerhasilMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MidtransController extends Controller
{
    public function webhook(Request $request)
    {
        try {
            \Midtrans\Config::$serverKey = config('midtrans.server_key');
            \Midtrans\Config::$isProduction = config('midtrans.is_production');

            $notif = new \Midtrans\Notification();

            // Ambil order_id asli (sebelum ada time)
            $orderId = explode('-', $notif->order_id)[0];

            $transaksi = Transaksi::find($orderId);

            if (!$transaksi) {
                return response()->json(['message' => 'Transaksi tidak ditemukan'], 404);
            }

            $transaksi->update(['status' => $notif->transaction_status]);

            // Kirim email hanya jika settlement
            if ($notif->transaction_status == 'settlement') {
                Mail::to($transaksi->user->email)
                    ->send(new TransaksiBerhasilMail($transaksi));
            }

            return response()->json(['message' => 'Status diperbarui'], 200);
        } catch (\Exception $e) {
            Log::error('Midtrans Webhook Error: ' . $e->getMessage());
            return response()->json(['message' => 'Error'], 500);
        }
    }
}
