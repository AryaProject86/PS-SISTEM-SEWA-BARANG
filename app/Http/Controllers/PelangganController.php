<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Barang;
use App\Models\peminjaman;

class PelangganController extends Controller
{
    public function dashboard()
    {
        $total = peminjaman::where('pelanggan_id', auth()->id())->count();

        $disewa = peminjaman::where('pelanggan_id', auth()->id())
                    ->where('status','disewa')
                    ->count();

        return view('pelanggan.dashboard', compact('total','disewa'));
    }

    public function barang()
    {
        $barang = Barang::all();
        return view('pelanggan.barang', compact('barang'));
    }

    public function peminjamanIndex()
    {
        $data = peminjaman::where('pelanggan_id', auth()->id())->get();
        return view('pelanggan.peminjaman.index', compact('data'));
    }

    public function peminjamanCreate()
    {
        $barang = Barang::all();
        return view('pelanggan.peminjaman.create', compact('barang'));
    }

    public function peminjamanStore(Request $request)
    {
         $barang = \App\Models\Barang::find($request->barang_id);

    $durasi = \Carbon\Carbon::parse($request->tanggal_sewa)
        ->diffInDays(\Carbon\Carbon::parse($request->tanggal_kembali));

    $durasi = max(1, $durasi);

    $total = $barang->harga_sewa_per_hari * $durasi;
     $peminjaman = \App\Models\peminjaman::create([
            'pelanggan_id' => auth()->id(),
            'barang_id' => $request->barang_id,
            'tanggal_sewa' => $request->tanggal_sewa,
            'tanggal_pengembalian' => $request->tanggal_pengembalian,
            'harga_sewa' => $request->harga_sewa,
            'total_biaya' => $request->total_biaya,
            'denda' => 0,
            'status' => 'disewa',
            'jaminan' => $request->jaminan
        ]);

         return redirect('/kuitansi/'.$peminjaman->id);
}
    public function pengembalian()
    {
        $data = peminjaman::where('pelanggan_id', auth()->id())
                    ->where('status','disewa')
                    ->get();

        return view('pelanggan.pengembalian', compact('data'));
    }

    public function prosesPengembalian($id)
    {
        $pinjam = peminjaman::where('id',$id)
                    ->where('pelanggan_id',auth()->id())
                    ->first();

        $pinjam->update([
            'status' => 'dikembalikan'
        ]);

        return redirect('/pengembalian');
    }

   public function kuitansi($id)
{
    $record = \App\Models\Peminjaman::with('barang','pelanggan')
        ->where('id', $id)
        ->where('pelanggan_id', auth()->id())
        ->firstOrFail();

    $totalHari = \Carbon\Carbon::parse($record->tanggal_sewa)
        ->diffInDays($record->tanggal_kembali);

    $totalHari = max(1, $totalHari);

    $totalBayar = $record->harga_sewa * $totalHari;

    return view('filament.components.kuitansi', [
        'record' => $record,
        'totalHari' => $totalHari,
        'totalBayar' => $totalBayar,
    ]);
}
}