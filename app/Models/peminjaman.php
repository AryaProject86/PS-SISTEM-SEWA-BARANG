<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';
    protected $fillable = [
        'pelanggan_id',
        'barang_id',
        'tanggal_sewa',
        'tanggal_kembali',
        'harga_sewa',
        'total_biaya',
        'status',
        'denda',
        'jaminan',
    ];

  public function pelanggan()
{
    return $this->belongsTo(\App\Models\Pelanggan::class, 'pelanggan_id');
}

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function pengembalian()
    {
        return $this->hasOne(Pengembalian::class);
    }
    public function user()
{
    return $this->belongsTo(User::class);
}

}
