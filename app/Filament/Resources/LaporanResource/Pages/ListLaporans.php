<?php

namespace App\Filament\Resources\LaporanResource\Pages;

use App\Filament\Resources\LaporanResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions;
use Barryvdh\DomPDF\Facade\Pdf;

class ListLaporans extends ListRecords
{
    protected static string $resource = LaporanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('Export PDF')
                ->label('Export PDF')
                ->icon('heroicon-o-document-arrow-down')
                ->color('primary')
                ->action(function () {
                    $data = \App\Models\Peminjaman::with(['pelanggan', 'barang'])->get();
                    $pdf = Pdf::loadView('exports.penyewaan', compact('data'));
                    return response()->streamDownload(
                        fn () => print($pdf->output()),
                        'laporan-penyewaan.pdf'
                    );
                }),
        ];
    }
}
