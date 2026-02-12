<?php

namespace App\Filament\Resources\Photos\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PhotoForm
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
                DatePicker::make('date_taken'),
                TextInput::make('sort_order')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
