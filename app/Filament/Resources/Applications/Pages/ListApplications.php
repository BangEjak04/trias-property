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

    private static ?object $tabCounts = null;

    protected static function getTabCounts(): object
    {
        if (self::$tabCounts === null) {
            self::$tabCounts = Application::query()
                ->selectRaw('
                    COUNT(*) as total,
                    SUM(status = ?) as prospect,
                    SUM(status = ?) as hot_prospect,
                    SUM(
                        status = ?
                        AND (approval_status IS NULL OR approval_status != ?)
                        AND (akad_status IS NULL OR akad_status NOT IN (?, ?))
                    ) as user_proses,
                    SUM(status = ? AND akad_status = ?) as akad,
                    SUM(
                        status = ? AND (
                            approval_status = ?
                            OR akad_status = ?
                        )
                    ) as reject
                ', [
                    StatusType::PROSPECT->value,
                    StatusType::HOT_PROSPECT->value,
                    StatusType::USER->value,
                    ApprovalStatus::REJECTED->value,
                    AkadStatus::CANCELLED->value,
                    AkadStatus::DONE->value,
                    StatusType::USER->value, AkadStatus::DONE->value,
                    StatusType::USER->value,
                    ApprovalStatus::REJECTED->value,
                    AkadStatus::CANCELLED->value,
                ])
                ->first() ?? (object) [
                    'total' => 0,
                    'prospect' => 0,
                    'hot_prospect' => 0,
                    'user_proses' => 0,
                    'akad' => 0,
                    'reject' => 0,
                ];
        }

        return self::$tabCounts;
    }

    #[Override]
    public function getTabs(): array
    {
        $counts = static::getTabCounts();

        return [
            'all' => Tab::make()
                ->label(__('stats.total'))
                ->badge((int) ($counts->total ?? 0))
                ->badgeColor('gray'),

            'prospect' => Tab::make()
                ->label(__('stats.prospect'))
                ->modifyQueryUsing(fn (Builder $query) => $query
                    ->where('status', StatusType::PROSPECT))
                ->badge((int) ($counts->prospect ?? 0))
                ->badgeColor('success'),

            'hot_prospect' => Tab::make()
                ->label(__('stats.hot_prospect'))
                ->modifyQueryUsing(fn (Builder $query) => $query
                    ->where('status', StatusType::HOT_PROSPECT))
                ->badge((int) ($counts->hot_prospect ?? 0))
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
                            AkadStatus::CANCELLED->value,
                            AkadStatus::DONE->value,
                        ])))
                ->badge((int) ($counts->user_proses ?? 0))
                ->badgeColor('primary'),

            'akad' => Tab::make()
                ->label(__('stats.akad'))
                ->modifyQueryUsing(fn (Builder $query) => $query
                    ->where('status', StatusType::USER)
                    ->where('akad_status', AkadStatus::DONE))
                ->badge((int) ($counts->akad ?? 0))
                ->badgeColor('info'),

            'reject' => Tab::make()
                ->label(__('stats.reject'))
                ->modifyQueryUsing(fn (Builder $query) => $query
                    ->where('status', StatusType::USER)
                    ->where(fn (Builder $q) => $q
                        ->where('approval_status', ApprovalStatus::REJECTED)
                        ->orWhere('akad_status', AkadStatus::CANCELLED)))
                ->badge((int) ($counts->reject ?? 0))
                ->badgeColor('danger'),
        ];
    }
}
