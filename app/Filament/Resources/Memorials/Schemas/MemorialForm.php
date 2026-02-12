<?php

namespace App\Filament\Resources\Memorials\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class MemorialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                TextInput::make('first_name')
                    ->required(),
                TextInput::make('last_name')
                    ->required(),
                TextInput::make('maiden_name'),
                DatePicker::make('date_of_birth'),
                DatePicker::make('date_of_death'),
                TextInput::make('place_of_birth'),
                TextInput::make('place_of_death'),
                Textarea::make('obituary')
                    ->columnSpanFull(),
                TextInput::make('cover_photo'),
                TextInput::make('profile_photo'),
                TextInput::make('privacy')
                    ->required()
                    ->default('public'),
                TextInput::make('password_hash')
                    ->password(),
                TextInput::make('latitude')
                    ->numeric(),
                TextInput::make('longitude')
                    ->numeric(),
                TextInput::make('cemetery_name'),
                TextInput::make('cemetery_address'),
                Toggle::make('is_published')
                    ->required(),
            ]);
    }
}
