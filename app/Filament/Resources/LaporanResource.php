<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LaporanResource\Pages;
use App\Models\Peminjaman;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;

class LaporanResource extends Resource
{
    protected static ?string $model = Peminjaman::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $navigationLabel = 'Laporan Penyewaan';
    protected static ?string $navigationGroup = 'Laporan';
    protected static ?int $navigationSort = 3;
    protected static ?string $modelLabel = 'Penyewaan';
    protected static ?string $pluralModelLabel = 'Penyewaan';

    public static function form(Form $form): Form
    {
        return $form; // Tidak digunakan
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('Kode')->sortable(),
                TextColumn::make('pelanggan.nama')->label('Pelanggan')->searchable(),
                TextColumn::make('barang.nama_barang')->label('Barang')->searchable(),
                TextColumn::make('tanggal_sewa')->label('Tanggal Sewa')->date(),
                TextColumn::make('tanggal_kembali')->label('Tanggal Kembali')->date(),
                TextColumn::make('total_biaya')->label('Total')->money('IDR', true),
                BadgeColumn::make('status')->label('Status')->colors([
                    'warning' => 'disewa',
                    'success' => 'dikembalikan',
                ]),
            ])
            ->filters([]) // Tambahkan jika butuh filter
            ->headerActions([]) // Hilangkan tombol tambah
            ->actions([]) // Hilangkan edit/delete
            ->bulkActions([]); // Hilangkan bulk
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLaporans::route('/'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }
}
