<?php

namespace App\Filament\Resources\Users;

use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Pages\EditUser;
use App\Filament\Resources\Users\Pages\ListUsers;
use App\Filament\Resources\Users\Schemas\UserForm;
use App\Filament\Resources\Users\Tables\UsersTable;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Hash;
use Filament\Tables\Columns\TextColumn;


class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::User;
    protected static ?string $recordTitleAttribute = 'User';

    public static function form(Schema $form): Schema
    {
       return $form
            ->schema([
                // 1. Data Profil Dasar
                TextInput::make('name')
                    ->label('Nama Lengkap Pegawai')
                    ->required()
                    ->maxLength(255),

                TextInput::make('email')
                    ->label('Email Dinas / NIP')
                    ->required()
                    ->maxLength(255),

                // 2. Kolom Password (Otomatis di-hash saat simpan)
                TextInput::make('password')
                    ->password()
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $context): bool => $context === 'create')
                    ->maxLength(255),

                // 3. RELASI KE JABATAN (Menghubungkan Struktur Organisasi)
                Select::make('jabatan_id')
                    ->label('Jabatan / Posisi')
                    ->relationship('jabatan', 'nama_jabatan')
                    ->searchable()
                    ->preload()
                    ->placeholder('Pilih Jabatan Pegawai'),

                // 4. RELASI KE ROLE SPATIE (Disediakan Otomatis oleh Spatie + Shield)
                Select::make('roles')
                    ->label('Hak Akses (Role)')
                    ->relationship('roles', 'name') // Mengambil data dari tabel roles Spatie
                    ->multiple() // Pegawai bisa punya lebih dari 1 role jika dibutuhkan
                    ->preload()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return UsersTable::configure($table);
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
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }
}
