<?php

namespace App\Filament\Resources\Applications\RelationManagers;

use App\Enums\StatusType;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class StatusLogsRelationManager extends RelationManager
{
    protected static string $relationship = 'statusLogs';

    protected static ?string $title = 'Riwayat Status';

    public function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('to_status')
            ->columns([
                TextColumn::make('from_status')
                    ->label('Dari Status')
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state ? (StatusType::tryFrom($state)?->getLabel() ?? $state) : 'Mulai')
                    ->color(fn ($state) => $state ? 'gray' : 'success'),
                TextColumn::make('to_status')
                    ->label('Ke Status')
                    ->badge()
                    ->formatStateUsing(fn ($state) => StatusType::tryFrom($state)?->getLabel() ?? $state)
                    ->color(fn ($state) => match($state) {
                        'prospect' => 'success',
                        'hot_prospect' => 'warning',
                        'user' => 'primary',
                        default => 'gray'
                    }),
                TextColumn::make('reason')
                    ->label('Alasan Perubahan')
                    ->placeholder('-')
                    ->searchable(),
                TextColumn::make('changedBy.name')
                    ->label('Diubah Oleh')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Waktu Perubahan')
                    ->dateTime('d-M-Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->headerActions([])
            ->recordActions([])
            ->toolbarActions([]);
    }
}
