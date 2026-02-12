<?php

namespace App\Filament\Resources\Memorials\Pages;

use App\Filament\Resources\Memorials\MemorialResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditMemorial extends EditRecord
{
    protected static string $resource = MemorialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
