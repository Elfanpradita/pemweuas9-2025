<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Keranjang;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $obats = Obat::all();
        $cartCount = Auth::check() ? Keranjang::where('user_id', Auth::id())->sum('qty') : 0;
        $items = Auth::check() ? Keranjang::with('obat')->where('user_id', Auth::id())->get() : [];

        return view('welcome', compact('obats', 'cartCount', 'items'));
    }
}
