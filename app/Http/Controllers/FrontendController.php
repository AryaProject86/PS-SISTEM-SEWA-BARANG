<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\peminjaman;

class FrontendController extends Controller
{
    public function dashboard()
    {
        $sedang = peminjaman::where('id', auth()->id())
                        ->where('status','disewa')
                        ->count();

        $riwayat = peminjaman::where('id', auth()->id())->count();

        return view('pelanggan.dashboard', compact('sedang','riwayat'));
    }

    public function barang()
    {
        $barang = Barang::all();
        return view('pelanggan.barang', compact('barang'));
    }

    public function riwayat()
    {
        $riwayat = Sewa::where('user_id', auth()->id())->get();
        return view('pelanggan.riwayat', compact('riwayat'));
    }
}