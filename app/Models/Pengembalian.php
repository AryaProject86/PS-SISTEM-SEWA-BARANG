<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    protected $fillable = ['peminjaman_id', 'tanggal_pengembalian'];

    public function peminjaman()
    {
        return $this->belongsTo(\App\Models\Peminjaman::class);
    }
}
