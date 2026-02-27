<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BarangResource\Pages;
use App\Models\Barang;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\ImageColumn;

class BarangResource extends Resource
{
    protected static ?string $model = Barang::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';
    protected static ?string $navigationLabel = 'Barang';
    protected static ?string $navigationGroup = 'Inventaris';

    public static function form(Form $form): Form
{
    return $form->schema([
        Forms\Components\Select::make('kategori_barang_id')
            ->label('Kategori')
            ->relationship('kategori', 'nama_kategori')
            ->searchable()
            ->required(),

        Forms\Components\TextInput::make('nama_barang')
            ->required()
            ->maxLength(100),

        Forms\Components\TextInput::make('harga_sewa_per_hari')
            ->label('Harga Sewa / Hari')
            ->numeric()
            ->required(),

        Forms\Components\TextInput::make('stok')
            ->numeric()
            ->minValue(0)
            ->required(),

        Forms\Components\FileUpload::make('gambar')
            ->label('Gambar Barang')
            ->image()
            ->disk('public')
            ->directory('barang')
            ->imagePreviewHeight('150')
            ->loadingIndicatorPosition('left')
            ->removeUploadedFileButtonPosition('right')
            ->uploadProgressIndicatorPosition('left'),
    ]);
}

    public static function table(Table $table): Table
{
    return $table->columns([
        Tables\Columns\TextColumn::make('no')
            ->label('No')
            ->rowIndex()
            ->sortable(),

        Tables\Columns\TextColumn::make('nama_barang')
            ->label('Nama Barang')
            ->sortable()
            ->searchable()
            ->wrap(),

        Tables\Columns\TextColumn::make('kategori.nama_kategori')
            ->label('Kategori')
            ->wrap(),

        Tables\Columns\TextColumn::make('harga_sewa_per_hari')
            ->label('Harga / Hari')
            ->money('IDR', true),

        Tables\Columns\TextColumn::make('stok')
            ->label('Stok')
            ->sortable(),

        Tables\Columns\ImageColumn::make('gambar')
            ->label('Gambar')
            ->disk('public')
            ->height(80)
            ->width(80)
            ->getStateUsing(fn ($record) => $record->gambar),
    ]);
}


    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBarangs::route('/'),
            'create' => Pages\CreateBarang::route('/create'),
            'edit' => Pages\EditBarang::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool { return true; }
    public static function canEdit(Model $record): bool { return true; }
    public static function canDelete(Model $record): bool { return true; }

    public static function shouldRegisterNavigation(): bool { return true; }
}