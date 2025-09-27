<?php

namespace App\Filament\Widgets;

use App\Models\Application;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Prospect', Application::query()->where('status', 'prospect')->count())
                ->color('success'),
            Stat::make('Hot Prospect', Application::query()->where('status', 'hot_prospect')->count()),
            Stat::make('User', Application::query()->where('status', 'user')->count()),
        ];
    }
}
