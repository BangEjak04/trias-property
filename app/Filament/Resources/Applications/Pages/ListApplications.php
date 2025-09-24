<?php

namespace App\Filament\Resources\Applications\Pages;

use App\Filament\Resources\Applications\ApplicationResource;
use App\Models\Application;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListApplications extends ListRecords
{
    protected static string $resource = ApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make(),
            'prospect' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'prospect'))
                ->badge(Application::query()->where('status', 'prospect')->count())
                ->badgeColor('success'),
            'hot_prospect' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'hot_prospect'))
                ->badge(Application::query()->where('status', 'hot_prospect')->count())
                ->badgeColor('warning'),
            'user' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'user'))
                ->badge(Application::query()->where('status', 'user')->count())
                ->badgeColor('primary'),
        ];
    }
}
