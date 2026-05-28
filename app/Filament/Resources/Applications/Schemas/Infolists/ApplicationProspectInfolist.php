<?php

namespace App\Filament\Resources\Applications\Schemas\Infolists;

use App\Enums\StatusType;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Support\Enums\FontWeight;

class ApplicationProspectInfolist
{
    public static function get(): array
    {
        return [
            Grid::make(1)
                ->components([
                    Section::make()
                        ->label(__('application.section.property.heading'))
                        ->description(__('application.section.property.description'))
                        ->aside()
                        ->components([
                            TextEntry::make('developer')
                                ->label(__('application.field.developer'))
                                ->weight(FontWeight::SemiBold),
                            TextEntry::make('property_name')
                                ->label(__('application.field.property.name'))
                                ->weight(FontWeight::SemiBold),
                            TextEntry::make('property_type')
                                ->label(__('application.field.property.type'))
                                ->weight(FontWeight::SemiBold),
                            Fieldset::make()
                                ->label(__('application.field.property.price_range.label'))
                                ->components([
                                    TextEntry::make('price_range_from')
                                        ->label(__('application.field.property.price_range.minimum'))
                                        ->weight(FontWeight::SemiBold)
                                        ->numeric()
                                        ->beforeContent('Rp'),
                                    TextEntry::make('price_range_to')
                                        ->label(__('application.field.property.price_range.maximum'))
                                        ->weight(FontWeight::SemiBold)
                                        ->numeric()
                                        ->beforeContent('Rp'),
                                ]),
                        ]),
                    Section::make(__('application.section.internal.heading'))
                        ->description(__('application.section.internal.description'))
                        ->aside()
                        ->components([
                            TextEntry::make('notes')
                                ->label(__('application.field.notes'))
                                ->weight(FontWeight::SemiBold)
                                ->html(),
                        ]),
                ])
                ->visible(fn (Get $get): bool => $get('status') == StatusType::PROSPECT),
        ];
    }
}
