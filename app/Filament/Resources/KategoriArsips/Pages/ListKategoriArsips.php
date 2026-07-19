<?php

namespace App\Filament\Resources\KategoriArsips\Pages;

use App\Filament\Resources\KategoriArsips\KategoriArsipResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListKategoriArsips extends ListRecords
{
    protected static string $resource = KategoriArsipResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
