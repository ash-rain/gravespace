<?php

namespace App\Filament\Resources\Tributes\Pages;

use App\Filament\Resources\Tributes\TributeResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditTribute extends EditRecord
{
    protected static string $resource = TributeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
