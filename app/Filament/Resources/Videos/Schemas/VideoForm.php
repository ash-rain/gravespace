<?php

namespace App\Filament\Resources\Videos\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class VideoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('memorial_id')
                    ->relationship('memorial', 'id')
                    ->required(),
                TextInput::make('uploaded_by')
                    ->numeric(),
                TextInput::make('file_path')
                    ->required(),
                TextInput::make('thumbnail_path'),
                TextInput::make('caption'),
                TextInput::make('duration')
                    ->numeric(),
                TextInput::make('sort_order')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
