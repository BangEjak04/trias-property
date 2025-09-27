<?php

namespace App\Filament\Resources\Applications\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ApplicationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama'),
                TextColumn::make('priority')
                    ->label('Prioritas')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => Str::ucfirst($state))
                    ->color(fn (string $state): string => match ($state) {
                        'high' => 'danger',
                        'mid' => 'warning',
                        'low' => 'success',
                    })
                    ->visible(fn (Page $livewire) => $livewire->activeTab == 'prospect'),
                TextColumn::make('approval')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'accepted' => 'Acc',
                        'rejected' => 'Reject',
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'accepted' => 'info',
                        'rejected' => 'danger',
                        default => 'gray'
                    })
                    ->visible(fn (Page $livewire) => $livewire->activeTab == 'user'),
                TextColumn::make('notes')
                    ->html()
                    ->label('Catatan')
                    ->toggleable(),
                TextColumn::make('phone')
                    ->label('Telepon')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                TextColumn::make('developer')
                    ->label('Developer')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                TextColumn::make('property')
                    ->label('Properti')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->label('Dibuat')
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->label('Diubah')
                    ->toggleable()
                    ->sortable(),
            ])
            ->defaultGroup(fn (Page $livewire) => match ($livewire->activeTab) {
                'prospect' => 'priority',
                'user' => 'approval',
                default => null
            })
            ->filters([
                SelectFilter::make('priority')
                    ->options([
                        'high' => 'High',
                        'mid' => 'Mid',
                        'low' => 'Low',
                    ])
                    ->visible(fn (Page $livewire) => $livewire->activeTab == 'prospect'),
                SelectFilter::make('approval')
                    ->options([
                        'accepted' => 'Acc',
                        'rejected' => 'Reject',
                    ])
                    ->visible(fn (Page $livewire) => $livewire->activeTab == 'user')
            ])
            ->recordActions([
                ViewAction::make(),
                // EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
