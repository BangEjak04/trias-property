<?php

namespace App\Filament\Resources\ProductKnowledge\Schemas;

use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProductKnowledgeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('product_knowledge.section.information.label'))
                    ->description(__('product_knowledge.section.information.description'))
                    ->aside()
                    ->components([
                        TextInput::make('name')
                            ->label(__('product_knowledge.field.name'))
                            ->required()
                            ->maxLength(255),
                        TextInput::make('url')
                            ->label(__('product_knowledge.field.url'))
                            ->required()
                            ->url()
                            ->prefixIcon(LucideIcon::Link)
                            ->maxLength(2048),
                    ]),
                Section::make(__('product_knowledge.section.visibility.label'))
                    ->description(__('product_knowledge.section.visibility.description'))
                    ->aside()
                    ->components([
                        TextInput::make('order')
                            ->label(__('product_knowledge.field.order'))
                            ->numeric()
                            ->default(0),
                        Toggle::make('is_active')
                            ->label(__('product_knowledge.field.is_active'))
                            ->default(true),
                    ]),
            ])
            ->columns(1);
    }
}
