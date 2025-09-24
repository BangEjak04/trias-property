<?php

namespace App\Filament\Resources\Applications\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ApplicationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('priority')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'high' => 'danger',
                        'mid' => 'warning',
                        'low' => 'success',
                    })
                    ->visible(fn (Page $livewire) => $livewire->activeTab == 'prospect'),
                TextColumn::make('approval')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'accepted' => 'info',
                        'rejected' => 'danger',
                        default => 'gray'
                    })
                    ->visible(fn (Page $livewire) => $livewire->activeTab == 'user'),
                TextColumn::make('notes')
                    ->html()
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->toggleable()
                    ->sortable(),
            ])
            ->defaultGroup(fn (Page $livewire) => match ($livewire->activeTab) {
                'prospect' => 'priority',
                'user' => 'approval',
                default => null
            })
            ->filters([
                //
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
