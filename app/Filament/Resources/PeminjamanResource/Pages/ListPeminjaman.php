<?php

namespace App\Filament\Resources\PeminjamanResource\Pages;

use App\Filament\Resources\PeminjamanResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions;
use Barryvdh\DomPDF\Facade\Pdf;

class ListPeminjaman extends ListRecords
{
    protected static string $resource = PeminjamanResource::class;

}