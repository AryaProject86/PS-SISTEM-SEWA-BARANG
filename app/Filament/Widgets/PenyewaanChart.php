<?php

namespace App\Filament\Widgets;

use App\Models\Peminjaman;
use App\Models\Pengembalians;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class PenyewaanChart extends ChartWidget
{
    protected static ?string $heading = 'Aktivitas Transaksi Sewa Barang';
    protected static ?int $sort = 2;

    public function getData(): array
{
    // Ambil data penyewaan per bulan
    $penyewaan = DB::table('peminjaman')
        ->selectRaw('MONTH(tanggal_sewa) as bulan, COUNT(*) as total')
        ->groupBy('bulan')
        ->orderBy('bulan')
        ->get();

    // Ambil data pengembalian per bulan (dari tanggal_kembali)
    $pengembalian = DB::table('peminjaman')
        ->where('status', 'dikembalikan')
        ->selectRaw('MONTH(tanggal_kembali) as bulan, COUNT(*) as total')
        ->groupBy('bulan')
        ->orderBy('bulan')
        ->get();

    $labels = collect(range(1, 12))->map(fn ($bulan) => date('F', mktime(0, 0, 0, $bulan, 1)));

    $penyewaanData = $labels->map(function ($label, $index) use ($penyewaan) {
        $bulan = $index + 1;
        return $penyewaan->firstWhere('bulan', $bulan)->total ?? 0;
    });

    $pengembalianData = $labels->map(function ($label, $index) use ($pengembalian) {
        $bulan = $index + 1;
        return $pengembalian->firstWhere('bulan', $bulan)->total ?? 0;
    });

    return [
        'datasets' => [
            [
                'label' => 'Jumlah Sewa',
                'data' => $penyewaanData,
                'backgroundColor' => '#3B82F6',
            ],
            [
                'label' => 'Jumlah Pengembalian',
                'data' => $pengembalianData,
                'backgroundColor' => '#10B981',
            ],
        ],
        'labels' => $labels,
    ];
}

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getHeight(): string|int|null
    {
        return 300;
    }
}
