<?php

namespace App\Filament\Resources\Applications\Pages;

use App\Enums\AkadStatus;
use App\Enums\ApprovalStatus;
use App\Enums\StatusType;
use App\Filament\Resources\Applications\ApplicationResource;
use App\Models\Application;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;
use Override;

class ListApplications extends ListRecords
{
    protected static string $resource = ApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    #[Override]
    public function getTabs(): array
    {
        return [
            'all' => Tab::make()
                ->label(__('stats.total')),

            'prospect' => Tab::make()
                ->label(__('stats.prospect'))
                ->modifyQueryUsing(fn (Builder $query) => $query
                    ->where('status', StatusType::PROSPECT))
                ->badge(Application::query()
                    ->where('status', StatusType::PROSPECT)
                    ->count())
                ->badgeColor('success'),

            'hot_prospect' => Tab::make()
                ->label(__('stats.hot_prospect'))
                ->modifyQueryUsing(fn (Builder $query) => $query
                    ->where('status', StatusType::HOT_PROSPECT))
                ->badge(Application::query()
                    ->where('status', StatusType::HOT_PROSPECT)
                    ->count())
                ->badgeColor('warning'),

            'user' => Tab::make()
                ->label(__('stats.user_proses'))
                ->modifyQueryUsing(fn (Builder $query) => $query
                    ->where('status', StatusType::USER)
                    ->where(fn (Builder $q) => $q
                        ->whereNull('approval_status')
                        ->orWhere('approval_status', '!=', ApprovalStatus::REJECTED))
                    ->where(fn (Builder $q) => $q
                        ->whereNull('akad_status')
                        ->orWhereNotIn('akad_status', [
                            AkadStatus::CANCELED->value,
                            AkadStatus::DONE->value,
                        ])))
                ->badge(Application::query()
                    ->where('status', StatusType::USER)
                    ->where(fn (Builder $q) => $q
                        ->whereNull('approval_status')
                        ->orWhere('approval_status', '!=', ApprovalStatus::REJECTED))
                    ->where(fn (Builder $q) => $q
                        ->whereNull('akad_status')
                        ->orWhereNotIn('akad_status', [
                            AkadStatus::CANCELED->value,
                            AkadStatus::DONE->value,
                        ]))
                    ->count())
                ->badgeColor('primary'),

            'akad' => Tab::make()
                ->label(__('stats.akad'))
                ->modifyQueryUsing(fn (Builder $query) => $query
                    ->where('status', StatusType::USER)
                    ->where('akad_status', AkadStatus::DONE))
                ->badge(Application::query()
                    ->where('status', StatusType::USER)
                    ->where('akad_status', AkadStatus::DONE)
                    ->count())
                ->badgeColor('info'),

            'reject' => Tab::make()
                ->label(__('stats.reject'))
                ->modifyQueryUsing(fn (Builder $query) => $query
                    ->where('status', StatusType::USER)
                    ->where(fn (Builder $q) => $q
                        ->where('approval_status', ApprovalStatus::REJECTED)
                        ->orWhere('akad_status', AkadStatus::CANCELED)))
                ->badge(Application::query()
                    ->where('status', StatusType::USER)
                    ->where(fn (Builder $q) => $q
                        ->where('approval_status', ApprovalStatus::REJECTED)
                        ->orWhere('akad_status', AkadStatus::CANCELED))
                    ->count())
                ->badgeColor('danger'),
        ];
    }
}
