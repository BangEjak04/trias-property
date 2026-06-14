<?php

namespace App\Filament\Resources\ProductKnowledge\Tables;

use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ProductKnowledgeTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order')
                    ->label('#')
                    ->sortable()
                    ->width(50),
                TextColumn::make('name')
                    ->label(__('product_knowledge.field.name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('url')
                    ->label(__('product_knowledge.field.url'))
                    ->limit(50)
                    ->url(fn ($record) => $record->url)
                    ->openUrlInNewTab(),
                ToggleColumn::make('is_active')
                    ->label(__('product_knowledge.field.is_active')),
                TextColumn::make('created_at')
                    ->label(__('product_knowledge.field.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label(__('product_knowledge.field.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('order', 'asc')
            ->reorderable('order')
            ->filters([
                TernaryFilter::make('is_active')
                    ->label(__('product_knowledge.filter.is_active'))
                    ->trueLabel(__('product_knowledge.filter.active'))
                    ->falseLabel(__('product_knowledge.filter.inactive'))
                    ->native(false),
            ])
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
