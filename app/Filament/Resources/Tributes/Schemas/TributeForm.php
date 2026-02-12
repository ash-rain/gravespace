<?php

namespace App\Filament\Resources\Tributes\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class TributeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('memorial_id')
                    ->relationship('memorial', 'id')
                    ->required(),
                TextInput::make('author_name'),
                TextInput::make('author_email')
                    ->email(),
                Select::make('user_id')
                    ->relationship('user', 'name'),
                Textarea::make('body')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('photo_path'),
                Toggle::make('is_approved')
                    ->required(),
            ]);
    }
}
