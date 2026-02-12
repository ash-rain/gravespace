<?php

namespace App\Filament\Resources\VirtualGifts;

use App\Filament\Resources\VirtualGifts\Pages\CreateVirtualGift;
use App\Filament\Resources\VirtualGifts\Pages\EditVirtualGift;
use App\Filament\Resources\VirtualGifts\Pages\ListVirtualGifts;
use App\Filament\Resources\VirtualGifts\Schemas\VirtualGiftForm;
use App\Filament\Resources\VirtualGifts\Tables\VirtualGiftsTable;
use App\Models\VirtualGift;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class VirtualGiftResource extends Resource
{
    protected static ?string $model = VirtualGift::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedGift;

    protected static string|\UnitEnum|null $navigationGroup = 'Content';

    public static function form(Schema $schema): Schema
    {
        return VirtualGiftForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VirtualGiftsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListVirtualGifts::route('/'),
            'create' => CreateVirtualGift::route('/create'),
            'edit' => EditVirtualGift::route('/{record}/edit'),
        ];
    }
}
