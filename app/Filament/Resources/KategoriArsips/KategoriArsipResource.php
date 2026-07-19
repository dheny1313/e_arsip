<?php

namespace App\Filament\Resources\KategoriArsips;

use App\Filament\Resources\KategoriArsips\Pages\CreateKategoriArsip;
use App\Filament\Resources\KategoriArsips\Pages\EditKategoriArsip;
use App\Filament\Resources\KategoriArsips\Pages\ListKategoriArsips;
use App\Filament\Resources\KategoriArsips\Schemas\KategoriArsipForm;
use App\Filament\Resources\KategoriArsips\Tables\KategoriArsipsTable;
use App\Models\KategoriArsip;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;


class KategoriArsipResource extends Resource
{
    protected static ?string $model = KategoriArsip::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'KategoriArsip';

    public static function form(Schema $form): Schema
    {
        return $form
            ->schema([
                TextInput::make('nama_kategori')
                    ->required()
                    ->maxLength(255),
                Textarea::make('deskripsi')
                    ->maxLength(65535)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
       return $table
            ->columns([
                TextColumn::make('nama_kategori')->searchable(),
                TextColumn::make('deskripsi')->limit(50),
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
            'index' => ListKategoriArsips::route('/'),
            'create' => CreateKategoriArsip::route('/create'),
            'edit' => EditKategoriArsip::route('/{record}/edit'),
        ];
    }
}
