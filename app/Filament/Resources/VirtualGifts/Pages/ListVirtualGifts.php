<?php

namespace App\Filament\Resources\VirtualGifts\Pages;

use App\Filament\Resources\VirtualGifts\VirtualGiftResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListVirtualGifts extends ListRecords
{
    protected static string $resource = VirtualGiftResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
