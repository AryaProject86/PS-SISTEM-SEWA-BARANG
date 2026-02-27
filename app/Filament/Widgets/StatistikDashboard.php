<?php

namespace App\Filament\Widgets;

use App\Models\Peminjaman;
use App\Models\Pelanggan;
use App\Models\Barang;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Support\Facades\DB;

class StatistikDashboard extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Total Barang', Barang::count())
                ->description('Barang yang tersedia')
                ->color('info')
                ->icon('heroicon-o-cube')
                ->extraAttributes([
                    'class' => 'bg-blue-400 text-white shadow-lg border-none'
                ]),

            Card::make('Total Pelanggan', Pelanggan::count())
                ->description('Pelanggan yang mensewa')
                ->color('info')
                ->icon('heroicon-o-identification')
                ->extraAttributes(['class' => 'bg-blue-500 text-white shadow-xl']),

            Card::make('Total Penyewaan', Peminjaman::count())
                ->description('Semua data yang disewa')
                ->color('info')
                ->icon('heroicon-o-clipboard-document-check')
                ->extraAttributes(['class' => 'bg-blue-500 text-white shadow-xl']),

            Card::make('Sedang Disewa', Peminjaman::where('status', 'disewa')->count())
                ->description('Belum dikembalikan')
                ->color('info')
                ->icon('heroicon-o-clock')
                ->extraAttributes(['class' => 'bg-blue-500 text-white shadow-xl']),

            Card::make('Sudah Dikembalikan', Peminjaman::where('status', 'dikembalikan')->count())
                ->description('Transaksi selesai')
                ->color('info')
                ->icon('heroicon-o-check-circle')
                ->extraAttributes(['class' => 'bg-blue-500 text-white shadow-xl']),
        ];
    }

    protected function getViewData(): array
    {
        return [
            'chartData' => $this->getChartData(),
        ];
    }

    protected function getChartData(): array
    {
        $data = DB::table('peminjaman')
            ->selectRaw("MONTH(tanggal_sewa) as bulan, COUNT(*) as total")
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        return [
            'labels' => $data->pluck('bulan')->map(fn ($b) => date('F', mktime(0, 0, 0, $b, 1))),
            'values' => $data->pluck('total'),
        ];
    }
}
