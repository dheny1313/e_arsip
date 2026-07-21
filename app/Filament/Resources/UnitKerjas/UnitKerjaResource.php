<?php

namespace App\Filament\Resources\UnitKerjas;

use App\Filament\Resources\UnitKerjas\Pages\CreateUnitKerja;
use App\Filament\Resources\UnitKerjas\Pages\EditUnitKerja;
use App\Filament\Resources\UnitKerjas\Pages\ListUnitKerjas;
use App\Filament\Resources\UnitKerjas\Schemas\UnitKerjaForm;
use App\Filament\Resources\UnitKerjas\Tables\UnitKerjasTable;
use App\Models\UnitKerja;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;

class UnitKerjaResource extends Resource
{
    protected static ?string $model = UnitKerja::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::BuildingOffice2;

    protected static ?string $recordTitleAttribute = 'UnitKerja';

    public static function form(Schema $form): Schema
    {
        return $form
            ->schema([
                // 1. TAMBAHKAN INPUT UNTUK NAMA UNIT
                TextInput::make('nama_unit')
                    ->label('Nama Unit Kerja')
                    ->required()
                    ->maxLength(255),

                // 2. TAMBAHKAN INPUT UNTUK KODE UNIT
                TextInput::make('kode_unit')
                    ->label('Kode Unit Kerja')
                    ->required()
                    ->maxLength(50),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('nama_unit')->searchable(),
                \Filament\Tables\Columns\TextColumn::make('kode_unit')->searchable(),
            ]);
        return UnitKerjasTable::configure($table);
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
            'index' => ListUnitKerjas::route('/'),
            'create' => CreateUnitKerja::route('/create'),
            'edit' => EditUnitKerja::route('/{record}/edit'),
        ];
    }
}
