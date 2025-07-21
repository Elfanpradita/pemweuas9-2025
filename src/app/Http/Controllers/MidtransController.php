<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MidtransController extends Controller
{
    public function webhook(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $signatureKey = hash('sha512',
            $request->order_id .
            $request->status_code .
            $request->gross_amount .
            $serverKey
        );

        // Validasi signature biar aman
        if ($signatureKey !== $request->signature_key) {
            Log::warning('Midtrans Webhook: Signature tidak valid', $request->all());
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        // Ambil ID transaksi kita (sebelum tanda '-')
        $transaksiId = explode('-', $request->order_id)[0];

        $transaksi = Transaksi::find($transaksiId);
        if (!$transaksi) {
            Log::warning('Midtrans Webhook: Transaksi tidak ditemukan', $request->all());
            return response()->json(['message' => 'Transaksi not found'], 404);
        }

        // Update status sesuai Midtrans
        $transaksi->update(['status' => $request->transaction_status]);

        Log::info('Midtrans Webhook: Status transaksi diperbarui', $request->all());

        return response()->json(['message' => 'OK']);
    }
}
