<?php

namespace App\Filament\Resources\Tributes\Pages;

use App\Filament\Resources\Tributes\TributeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTributes extends ListRecords
{
    protected static string $resource = TributeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
