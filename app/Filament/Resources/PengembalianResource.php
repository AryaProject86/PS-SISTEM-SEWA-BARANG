<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PengembalianResource\Pages;
use App\Models\Pengembalian;
use App\Models\Peminjaman;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class PengembalianResource extends Resource
{
    protected static ?string $model = Pengembalian::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-up-circle';
    protected static ?string $navigationLabel = 'Pengembalian';
    protected static ?string $navigationGroup = 'Transaksi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('peminjaman_id')
                    ->label('Transaksi Sewa')
                    ->options(function () {
                return \App\Models\Peminjaman::where('status', 'disewa')
                    ->with('pelanggan')
                    ->get()
                    ->mapWithKeys(function ($item) {
                return [
                    $item->id => 'disewa' . $item->id . ' - ' . ($item->pelanggan->nama ?? 'Tanpa Nama'),
                ];
            });
    })
                    ->required(),

                Forms\Components\DatePicker::make('tanggal_pengembalian')
                    ->label('Tanggal Pengembalian')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('no')
                    ->label('No')
                     ->rowIndex()
                    ->sortable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('peminjaman.id')->label('Kode Sewa'),
                Tables\Columns\TextColumn::make('tanggal_pengembalian')->date(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPengembalians::route('/'),
            'create' => Pages\CreatePengembalian::route('/create'),
            'edit' => Pages\EditPengembalian::route('/{record}/edit'),
        ];
    }

    // Optional: Cegah duplikat pengembalian
    public static function canCreate(): bool
    {
        return true;
    }

   public static function afterCreate(Model $record): void
{
    $peminjaman = $record->peminjaman;

    $tanggal_kembali = \Carbon\Carbon::parse($peminjaman->tanggal_kembali);
    $tanggal_pengembalian = \Carbon\Carbon::parse($record->tanggal_pengembalian);

    $hari_telat = $tanggal_pengembalian->diffInDays($tanggal_kembali, false);
    $denda_per_hari = 10000;

    $denda = 0;
    if ($tanggal_pengembalian->gt($tanggal_kembali)) {
        $denda = $hari_telat * $denda_per_hari;
    }

    $peminjaman->update([
        'status' => 'dikembalikan',
        'denda' => $denda,
    ]);
}
}