<?php

namespace App\Filament\Resources\PeminjamanResource\Pages;

use App\Filament\Resources\PeminjamanResource;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Barang;

class CreatePeminjaman extends CreateRecord
{
    protected static string $resource = PeminjamanResource::class;

    protected function afterCreate(): void
    {
        // Ambil data barang dari peminjaman yang baru dibuat
        $barang = $this->record->barang;

        // Kurangi stok barang sebanyak 1
        $barang->decrement('stok');
    }
}
