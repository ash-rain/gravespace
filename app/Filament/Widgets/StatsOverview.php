<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\Memorial;
use App\Models\Tribute;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = -2;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Users', User::query()->count())
                ->description('Registered accounts')
                ->icon('heroicon-o-users'),
            Stat::make('Total Memorials', Memorial::query()->count())
                ->description('All memorials')
                ->icon('heroicon-o-heart'),
            Stat::make('Pending Tributes', Tribute::query()->pending()->count())
                ->description('Awaiting moderation')
                ->icon('heroicon-o-chat-bubble-left-right')
                ->color('warning'),
            Stat::make('Approved Tributes', Tribute::query()->approved()->count())
                ->description('Published tributes')
                ->icon('heroicon-o-check-circle')
                ->color('success'),
        ];
    }
}
