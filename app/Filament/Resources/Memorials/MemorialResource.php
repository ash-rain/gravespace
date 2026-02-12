<?php

namespace App\Filament\Resources\Memorials;

use App\Filament\Resources\Memorials\Pages\CreateMemorial;
use App\Filament\Resources\Memorials\Pages\EditMemorial;
use App\Filament\Resources\Memorials\Pages\ListMemorials;
use App\Filament\Resources\Memorials\Schemas\MemorialForm;
use App\Filament\Resources\Memorials\Tables\MemorialsTable;
use App\Models\Memorial;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MemorialResource extends Resource
{
    protected static ?string $model = Memorial::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHeart;

    protected static string|\UnitEnum|null $navigationGroup = 'Content';

    public static function form(Schema $schema): Schema
    {
        return MemorialForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MemorialsTable::configure($table);
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
            'index' => ListMemorials::route('/'),
            'create' => CreateMemorial::route('/create'),
            'edit' => EditMemorial::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
