<?php

namespace App\Filament\Resources\KategoriArsips\Pages;

use App\Filament\Resources\KategoriArsips\KategoriArsipResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditKategoriArsip extends EditRecord
{
    protected static string $resource = KategoriArsipResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
