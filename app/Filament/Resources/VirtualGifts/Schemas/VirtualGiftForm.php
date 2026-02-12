<?php

namespace App\Filament\Resources\VirtualGifts\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class VirtualGiftForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('memorial_id')
                    ->relationship('memorial', 'id')
                    ->required(),
                Select::make('user_id')
                    ->relationship('user', 'name'),
                TextInput::make('type')
                    ->required(),
                TextInput::make('message'),
            ]);
    }
}
