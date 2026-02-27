<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PeminjamanResource\Pages;
use App\Filament\Resources\PeminjamanResource\RelationManagers;
use App\Models\Peminjaman;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Carbon\Carbon;
use Filament\Tables\Actions\Action;



class PeminjamanResource extends Resource
{
    protected static ?string $model = Peminjaman::class;
    protected static ?string $slug = 'peminjaman';
    
    protected static ?string $navigationLabel = 'Transaksi Sewa';
    protected static ?string $navigationGroup = 'Transaksi';
    protected static ?string $modelLabel = 'Penyewaan';
    protected static ?string $pluralModelLabel = 'Penyewaan';
    protected static ?string $navigationIcon ='heroicon-o-clipboard-document-check'; 
 

    public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\Select::make('pelanggan_id')
                ->label('Pelanggan')
                ->relationship('pelanggan', 'nama')
                ->required(),

            Forms\Components\Select::make('barang_id')
                ->label('Barang')
                ->relationship('barang', 'nama_barang')
                ->reactive()
                ->required()
                ->afterStateUpdated(fn ($state, callable $set) => 
                    $set('harga_sewa', \App\Models\Barang::find($state)?->harga_sewa_per_hari)
                ),

            Forms\Components\TextInput::make('harga_sewa')
                ->label('Harga Sewa per Hari')
                ->numeric()
                ->disabled()
                ->dehydrated(),

            Forms\Components\DatePicker::make('tanggal_sewa')
                ->label('Tanggal Sewa')
                ->required()
                ->reactive(),

            Forms\Components\DatePicker::make('tanggal_pengembalian')
                ->label('Tanggal Pengembalian')
                ->required()
                ->reactive()
                ->afterStateUpdated(function ($state, callable $set, callable $get) {
                    $tanggalSewa = $get('tanggal_sewa');
                    if (!$tanggalSewa || !$state) {
                        $set('total_biaya', 0);
                        $set('denda', 0);
                        return;
                    }

                    $hargaSewa = (int) $get('harga_sewa');
                    $start = \Carbon\Carbon::parse($tanggalSewa);
                    $end = \Carbon\Carbon::parse($state);

                    $durasi = max(1, $start->diffInDays($end));
                    $total = $hargaSewa * $durasi;

                    // Hitung denda jika pengembalian lebih dari hari ini (terlambat)
                    $denda = 0;
                    if (now()->lt($start)) {
                        $denda = 0;
                    } elseif ($end->lt(now())) {
                        $terlambat = now()->diffInDays($end);
                        $denda = $terlambat * 10000;
                    }

                    $set('total_biaya', $total);
                    $set('denda', $denda);
                }),

            Forms\Components\TextInput::make('total_biaya')
                ->label('Total Biaya')
                ->numeric()
                ->disabled()
                ->dehydrated(),

            Forms\Components\TextInput::make('denda')
                ->label('Denda (jika terlambat)')
                ->numeric()
                ->disabled()
                ->dehydrated()
                ->default(0),

            Forms\Components\Select::make('status')
                ->label('Status')
                ->options([
                    'disewa' => 'Disewa',
                    'dikembalikan' => 'Dikembalikan',
                ])
                ->required(),

            Forms\Components\TextInput::make('jaminan')
                ->label('Jaminan')
                ->placeholder('Contoh: KTP, SIM, Uang, dll')
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
            ->sortable(),
        Tables\Columns\TextColumn::make('pelanggan.nama')
            ->label('Pelanggan'),
        Tables\Columns\TextColumn::make('barang.nama_barang')
            ->label('Nama Barang'),

        Tables\Columns\TextColumn::make('tanggal_sewa')
            ->date()
            ->label('Tanggal Sewa'),

        Tables\Columns\TextColumn::make('tanggal_kembali')
            ->date()
            ->label('Tanggal Kembali'),
         Tables\Columns\TextColumn::make('harga_sewa')
            ->label('Harga Sewa')
            ->money('IDR', true), 
        Tables\Columns\TextColumn::make('total_biaya')
            ->label('Total Biaya')
            ->money('IDR', true),
        Tables\Columns\BadgeColumn::make('status')
            ->label('Status Sewa')
            ->colors([
        'warning' => fn ($record) => $record->status === 'disewa' && \Carbon\Carbon::now()->lte($record->tanggal_kembali),
        'danger' => fn ($record) => $record->status === 'disewa' && \Carbon\Carbon::now()->gt($record->tanggal_kembali),
        'success' => fn ($record) => $record->status === 'dikembalikan',

    ])
    ->formatStateUsing(function ($state, $record) {
        if ($record->status === 'disewa') {
            if (\Carbon\Carbon::now()->gt($record->tanggal_kembali)) {
                return '❗Terlambat';
            }
            return 'Disewa';
        }
        return 'Dikembalikan';
    }),
    Tables\Columns\TextColumn::make('denda')
        ->label('Denda')
        ->money('IDR', true),

    Tables\Columns\TextColumn::make('jaminan')
        ->label('Jaminan'),

       
    ])
    
    ->filters([
                //
            ])
            ->actions([
                Action::make('cetak_kuitansi')
                ->label('Cetak Kuitansi')
                ->icon('heroicon-o-printer')
                ->color('primary')
                ->action(function ($record) {
                    // Generate HTML langsung dari sini
                    $totalHari = \Carbon\Carbon::parse($record->tanggal_sewa)
                        ->diffInDays($record->tanggal_kembali);
                    $totalBayar = $record->barang->harga_sewa_per_hari * $totalHari;

                    $html = view('filament.components.kuitansi', [
                        'record' => $record,
                        'totalHari' => $totalHari,
                        'totalBayar' => $totalBayar,
                    ])->render();
                    $filename = 'kuitansi_'.$record->id.'.html';
                    file_put_contents(public_path($filename), $html);
                    return redirect("/$filename");
                })
                ->openUrlInNewTab(false),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
{
    return [
        'index' => Pages\ListPeminjaman::route('/'),
        'create' => Pages\CreatePeminjaman::route('/create'),
        'edit' => Pages\EditPeminjaman::route('/{record}/edit'),
    ];
}
}

