<?php

namespace App\Filament\Resources\Applications\Tables;

use App\Enums\ApprovalStatus;
use App\Enums\PriorityType;
use App\Enums\StatusType;
use App\Filament\Resources\Applications\ApplicationResource;
use CodeWithKyrian\FilamentDateRange\Tables\Filters\DateRangeFilter;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Pages\Page;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class ApplicationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('applicant_name')
                    ->label(__('application.field.applicant.name'))
                    ->sortable()
                    ->searchable(isIndividual: true),
                TextColumn::make('priority')
                    ->label(__('application.field.priority.label'))
                    ->badge()
                    ->toggleable()
                    ->visible(fn (Page $livewire) => $livewire->activeTab == StatusType::PROSPECT),
                TextColumn::make('approval_status')
                    ->label(__('application.field.approval'))
                    ->toggleable()
                    ->visible(fn (Page $livewire) => $livewire->activeTab == StatusType::USER),
                TextColumn::make('credit_approval')
                    ->label(__('application.field.credit_approval'))
                    ->toggleable()
                    ->visible(fn (Page $livewire) => $livewire->activeTab == 'akad'),
                TextColumn::make('notes')
                    ->label(__('application.field.notes'))
                    ->html()
                    ->toggleable(),
                TextColumn::make('applicant_phone')
                    ->label(__('application.field.applicant.phone'))
                    ->formatStateUsing(fn ($state) => '+62'.$state)
                    ->url(fn ($state) => 'https://wa.me/+62'.$state)
                    ->openUrlInNewTab()
                    ->toggleable()
                    ->searchable(isIndividual: true),
                TextColumn::make('developer')
                    ->label(__('application.field.developer'))
                    ->toggleable()
                    ->sortable()
                    ->searchable(isIndividual: true),
                TextColumn::make('property_name')
                    ->label(__('application.field.property.name'))
                    ->toggleable()
                    ->sortable()
                    ->searchable(isIndividual: true),
                TextColumn::make('marketing_agent')
                    ->label(__('application.field.marketing_agent'))
                    ->sortable()
                    ->toggleable()
                    ->searchable(isIndividual: true),
                TextColumn::make('created_at')
                    ->label(__('application.field.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label(__('application.field.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->groups(fn (ListRecords $livewire): array => match ($livewire->activeTab) {
                'prospect' => [
                    Group::make('priority')
                        ->label('Priority')
                        ->orderQueryUsing(fn ($query, string $direction) => $query->orderByRaw("FIELD(priority, 'high', 'middle', 'low') {$direction}")
                        ),
                ],
                'user' => [
                    Group::make('approval_status')
                        ->label('Approval'),
                ],
                default => [],
            })
            ->defaultGroup(fn (ListRecords $livewire): ?string => match ($livewire->activeTab) {
                'prospect' => 'priority',
                'user' => 'approval_status',
                default => null,
            })
            ->groupingDirectionSettingHidden()
            ->filters([
                SelectFilter::make('priority')
                    ->options(PriorityType::class)
                    ->visible(fn (Page $livewire) => $livewire->activeTab == StatusType::PROSPECT),
                SelectFilter::make('approval')
                    ->options(ApprovalStatus::class)
                    ->visible(fn (Page $livewire) => $livewire->activeTab == StatusType::USER),
                DateRangeFilter::make('created_at')
                    ->label(__('application.field.created_at')),
                DateRangeFilter::make('created_at')
                    ->label(__('application.field.updated_at')),
                TrashedFilter::make(),
            ])
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                ]),
            ])
            ->recordUrl(
                fn (Model $record): string => ApplicationResource::getUrl('view', ['record' => $record])
            )
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
