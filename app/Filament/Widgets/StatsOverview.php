<?php

namespace App\Filament\Widgets;

use App\Enums\AkadStatus;
use App\Enums\ApprovalStatus;
use App\Enums\StatusType;
use App\Models\Application;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $stats = Application::query()
            ->selectRaw('
                COUNT(*) as total,
                SUM(status = ?) as prospect,
                SUM(status = ?) as hot_prospect,
                SUM(
                    status = ?
                    AND (approval_status IS NULL OR approval_status != ?)
                    AND (akad_status IS NULL OR akad_status NOT IN (?, ?))
                ) as user_proses,
                SUM(
                    status = ? AND (
                        approval_status = ?
                        OR akad_status = ?
                    )
                ) as reject,
                SUM(status = ? AND akad_status = ?) as akad
            ', [
                StatusType::PROSPECT->value,
                StatusType::HOT_PROSPECT->value,
                StatusType::USER->value,
                ApprovalStatus::REJECTED->value,
                AkadStatus::CANCELLED->value,
                AkadStatus::DONE->value,
                StatusType::USER->value,
                ApprovalStatus::REJECTED->value,
                AkadStatus::CANCELLED->value,
                StatusType::USER->value, AkadStatus::DONE->value,
            ])
            ->first();

        return [
            Stat::make(
                label: __('stats.prospect'),
                value: $stats->prospect ?? 0,
            )
                ->description(__('stats.prospect_desc'))
                ->descriptionIcon('heroicon-m-user-plus')
                ->color('success'),

            Stat::make(
                label: __('stats.hot_prospect'),
                value: $stats->hot_prospect ?? 0,
            )
                ->description(__('stats.hot_prospect_desc'))
                ->descriptionIcon('heroicon-m-fire')
                ->color('warning'),

            Stat::make(
                label: __('stats.user_proses'),
                value: $stats->user_proses ?? 0,
            )
                ->description(__('stats.user_proses_desc'))
                ->descriptionIcon('heroicon-m-arrow-path')
                ->color('primary'),

            Stat::make(
                label: __('stats.akad'),
                value: $stats->akad ?? 0,
            )
                ->description(__('stats.akad_desc'))
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('info'),

            Stat::make(
                label: __('stats.reject'),
                value: $stats->reject ?? 0,
            )
                ->description(__('stats.reject_desc'))
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger'),

            Stat::make(
                label: __('stats.total'),
                value: $stats->total ?? 0,
            )
                ->description(__('stats.total_desc'))
                ->descriptionIcon('heroicon-m-folder-open')
                ->color('gray'),
        ];
    }
}
