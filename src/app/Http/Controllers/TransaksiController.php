<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::where('user_id', Auth::id())->latest()->get();
        $cartCount = Keranjang::where('user_id', Auth::id())->sum('qty');

        return view('transaksi.index', compact('transaksis', 'cartCount'));
    }

    public function show($id)
    {
        $transaksi = Transaksi::where('user_id', Auth::id())->findOrFail($id);
        $cartCount = Keranjang::where('user_id', Auth::id())->sum('qty');

        return view('transaksi.show', compact('transaksi', 'cartCount'));
    }

    public function cekStatus($id)
    {
        $transaksi = Transaksi::where('user_id', Auth::id())->findOrFail($id);

        // Midtrans Config
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');

        $status = \Midtrans\Transaction::status($transaksi->id . '-' . $transaksi->created_at->timestamp);

        $transaksi->update(['status' => $status->transaction_status]);

        return redirect()->route('transaksi.show', $transaksi->id)
            ->with('success', 'Status diperbarui: ' . ucfirst($status->transaction_status));
    }
}
