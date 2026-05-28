<?php

namespace App\Filament\Resources\Applications\Schemas\Infolists;

use App\Enums\StatusType;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Support\Enums\FontWeight;

class ApplicationUserInfolist
{
    public static function get(): array
    {
        return [
            Grid::make(1)
                ->components([
                    Section::make(__('application.section.internal.heading'))
                        ->description(__('application.section.internal.description'))
                        ->aside()
                        ->components([
                            TextEntry::make('marketing_agent')
                                ->label(__('application.field.marketing_agent'))
                                ->weight(FontWeight::SemiBold),
                            TextEntry::make('notes')
                                ->label(__('application.field.notes'))
                                ->weight(FontWeight::SemiBold)
                                ->html(),
                        ]),
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
                            TextEntry::make('property_block')
                                ->label(__('application.field.property.block'))
                                ->weight(FontWeight::SemiBold),
                            TextEntry::make('property_number')
                                ->label(__('application.field.property.number'))
                                ->weight(FontWeight::SemiBold),
                            TextEntry::make('land_area')
                                ->label(__('application.field.property.land_area'))
                                ->weight(FontWeight::SemiBold)
                                ->numeric()
                                ->formatStateUsing(fn (string $state): string => $state.' m²'),
                            TextEntry::make('building_area')
                                ->label(__('application.field.property.building_area'))
                                ->weight(FontWeight::SemiBold)
                                ->numeric()
                                ->formatStateUsing(fn (string $state): string => $state.' m²'),
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
                            TextEntry::make('price')
                                ->label(__('application.field.property.price'))
                                ->weight(FontWeight::SemiBold)
                                ->numeric()
                                ->beforeContent('Rp'),
                            TextEntry::make('down_payment_amount')
                                ->label(__('application.field.down_payment_amount'))
                                ->weight(FontWeight::SemiBold)
                                ->numeric()
                                ->beforeContent('Rp'),
                            TextEntry::make('loan_amount')
                                ->label(__('application.field.loan_amount'))
                                ->weight(FontWeight::SemiBold)
                                ->numeric()
                                ->beforeContent('Rp'),
                        ]),
                    Section::make()
                        ->label(__('application.section.credit.heading'))
                        ->description(__('application.section.credit.description'))
                        ->aside()
                        ->components([
                            TextEntry::make('payment_method')
                                ->label(__('application.field.payment_method'))
                                ->weight(FontWeight::SemiBold),
                            TextEntry::make('down_payment_date')
                                ->label(__('application.field.down_payment_date'))
                                ->date('j-M-Y')
                                ->weight(FontWeight::SemiBold),
                            TextEntry::make('down_payment_proof')
                                ->label(__('application.field.down_payment_proof'))
                                ->weight(FontWeight::SemiBold),
                            ImageEntry::make('id_card')
                                ->label(__('application.field.id_card')),
                        ]),
                    Section::make()
                        ->label(__('application.section.approval.heading'))
                        ->description(__('application.section.approval.description'))
                        ->aside()
                        ->components([
                            TextEntry::make('bank_name')
                                ->label(__('application.field.bank_name'))
                                ->weight(FontWeight::SemiBold),
                            TextEntry::make('document_progress')
                                ->label(__('application.field.document_progress'))
                                ->weight(FontWeight::SemiBold),
                            TextEntry::make('approval_status')
                                ->label(__('application.field.approval'))
                                ->weight(FontWeight::SemiBold)
                                ->badge(),
                            TextEntry::make('credit_approval')
                                ->label(__('application.field.credit_approval'))
                                ->weight(FontWeight::SemiBold)
                                ->numeric()
                                ->beforeContent('Rp'),
                            TextEntry::make('approval_date')
                                ->label(__('application.field.approval_date'))
                                ->weight(FontWeight::SemiBold)
                                ->date('j-M-Y'),
                        ]),
                    Section::make()
                        ->label(__('application.section.akad.heading'))
                        ->description(__('application.section.akad.description'))
                        ->aside()
                        ->components([
                            TextEntry::make('akad_scheduled_at')
                                ->label(__('application.field.akad_scheduled_at'))
                                ->dateTime(),
                            TextEntry::make('akad_location')
                                ->label(__('application.field.akad_location')),
                            TextEntry::make('akad_status')
                                ->label(__('application.field.akad_status'))
                                ->badge(),
                        ]),
                ])
                ->visible(fn (Get $get): bool => $get('status') == StatusType::USER),
        ];
    }
}
