<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KategoriBarangResource\Pages;
use App\Filament\Resources\KategoriBarangResource\RelationManagers;
use App\Models\KategoriBarang;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KategoriBarangResource extends Resource
{
    protected static ?string $model = KategoriBarang::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-group';
    protected static ?string $navigationLabel = 'Kategori Barang';
    protected static ?string $navigationGroup = 'Inventaris';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                 Forms\Components\TextInput::make('nama_kategori')
                    ->label('Nama Kategori')
                    ->required()
                    ->maxLength(100),
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
                Tables\Columns\TextColumn::make('nama_kategori')
                    ->label('Nama Kategori')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->label('Tanggal Buat'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListKategoriBarangs::route('/'),
            'create' => Pages\CreateKategoriBarang::route('/create'),
            'edit' => Pages\EditKategoriBarang::route('/{record}/edit'),
        ];
    }
}
