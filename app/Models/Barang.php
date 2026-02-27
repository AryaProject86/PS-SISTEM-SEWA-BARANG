<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = [
        'kategori_barang_id',
        'nama_barang',
        'gambar',
        'stok',
        'harga_sewa_per_hari',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriBarang::class, 'kategori_barang_id');
    }

    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class);
    }
}
