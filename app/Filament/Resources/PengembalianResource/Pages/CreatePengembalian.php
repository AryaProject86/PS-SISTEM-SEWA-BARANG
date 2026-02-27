<?php

namespace App\Filament\Resources\PengembalianResource\Pages;

use App\Filament\Resources\PengembalianResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePengembalian extends CreateRecord
{
    protected static string $resource = PengembalianResource::class;

    protected function afterCreate(): void
    {
        // Update status peminjaman
        $this->record->peminjaman->update([
            'status' => 'dikembalikan',
        ]);

        // Kembalikan stok barang
        $barang = $this->record->peminjaman->barang;
        $barang->increment('stok'); // Tambah stok sebanyak 1
    }
}
