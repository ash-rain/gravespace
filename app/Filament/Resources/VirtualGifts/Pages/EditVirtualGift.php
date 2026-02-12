<?php

namespace App\Filament\Resources\VirtualGifts\Pages;

use App\Filament\Resources\VirtualGifts\VirtualGiftResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditVirtualGift extends EditRecord
{
    protected static string $resource = VirtualGiftResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
