<?php

namespace App\Filament\Resources\Applications\Schemas\Infolists;

use App\Enums\StatusType;
use App\Filament\Infolists\Components\FilePreview;
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
                                ->weight(FontWeight::SemiBold)
                                ->placeholder('-'),
                            TextEntry::make('notes')
                                ->label(__('application.field.notes'))
                                ->weight(FontWeight::SemiBold)
                                ->html()
                                ->placeholder('-'),
                        ]),
                    Section::make()
                        ->label(__('application.section.property.heading'))
                        ->description(__('application.section.property.description'))
                        ->aside()
                        ->components([
                            TextEntry::make('developer')
                                ->label(__('application.field.developer'))
                                ->weight(FontWeight::SemiBold)
                                ->placeholder('-'),
                            TextEntry::make('property_name')
                                ->label(__('application.field.property_name'))
                                ->weight(FontWeight::SemiBold)
                                ->placeholder('-'),
                            TextEntry::make('property_type')
                                ->label(__('application.field.property_type'))
                                ->weight(FontWeight::SemiBold)
                                ->placeholder('-'),
                            TextEntry::make('property_block')
                                ->label(__('application.field.property_block'))
                                ->weight(FontWeight::SemiBold)
                                ->placeholder('-'),
                            TextEntry::make('property_number')
                                ->label(__('application.field.property_number'))
                                ->weight(FontWeight::SemiBold)
                                ->placeholder('-'),
                            TextEntry::make('land_area')
                                ->label(__('application.field.land_area'))
                                ->weight(FontWeight::SemiBold)
                                ->numeric()
                                ->formatStateUsing(fn ($state): string => $state ? $state.' m²' : '-')
                                ->placeholder('-'),
                            TextEntry::make('building_area')
                                ->label(__('application.field.building_area'))
                                ->weight(FontWeight::SemiBold)
                                ->numeric()
                                ->formatStateUsing(fn ($state): string => $state ? $state.' m²' : '-')
                                ->placeholder('-'),
                            Fieldset::make()
                                ->label(__('application.field.price_range_label'))
                                ->components([
                                    TextEntry::make('price_range_from')
                                        ->label(__('application.field.price_range_from'))
                                        ->weight(FontWeight::SemiBold)
                                        ->numeric()
                                        ->beforeContent('Rp ')
                                        ->placeholder('-'),
                                    TextEntry::make('price_range_to')
                                        ->label(__('application.field.price_range_to'))
                                        ->weight(FontWeight::SemiBold)
                                        ->numeric()
                                        ->beforeContent('Rp ')
                                        ->placeholder('-'),
                                ]),
                            TextEntry::make('price')
                                ->label(__('application.field.price'))
                                ->weight(FontWeight::SemiBold)
                                ->numeric()
                                ->beforeContent('Rp ')
                                ->placeholder('-'),
                            TextEntry::make('down_payment_amount')
                                ->label(__('application.field.down_payment_amount'))
                                ->weight(FontWeight::SemiBold)
                                ->numeric()
                                ->beforeContent('Rp ')
                                ->placeholder('-'),
                            TextEntry::make('loan_amount')
                                ->label(__('application.field.loan_amount'))
                                ->weight(FontWeight::SemiBold)
                                ->numeric()
                                ->beforeContent('Rp ')
                                ->placeholder('-'),
                        ]),
                    Section::make()
                        ->label(__('application.section.credit.heading'))
                        ->description(__('application.section.credit.description'))
                        ->aside()
                        ->components([
                            TextEntry::make('payment_method')
                                ->label(__('application.field.payment_method'))
                                ->weight(FontWeight::SemiBold)
                                ->placeholder('-'),
                            TextEntry::make('down_payment_date')
                                ->label(__('application.field.down_payment_date'))
                                ->date('j-M-Y')
                                ->weight(FontWeight::SemiBold)
                                ->placeholder('-'),
                            FilePreview::make('down_payment_proof')
                                ->label(__('application.field.down_payment_proof')),
                            FilePreview::make('id_card')
                                ->label(__('application.field.id_card')),
                        ]),
                    Section::make()
                        ->label(__('application.section.approval.heading'))
                        ->description(__('application.section.approval.description'))
                        ->aside()
                        ->components([
                            TextEntry::make('bank_name')
                                ->label(__('application.field.bank_name'))
                                ->weight(FontWeight::SemiBold)
                                ->placeholder('-'),
                            TextEntry::make('document_progress')
                                ->label(__('application.field.document_progress'))
                                ->weight(FontWeight::SemiBold)
                                ->placeholder('-'),
                            TextEntry::make('approval_status')
                                ->label(__('application.field.approval'))
                                ->weight(FontWeight::SemiBold)
                                ->badge()
                                ->placeholder('-'),
                            TextEntry::make('credit_approval')
                                ->label(__('application.field.credit_approval'))
                                ->weight(FontWeight::SemiBold)
                                ->numeric()
                                ->beforeContent('Rp ')
                                ->placeholder('-'),
                            TextEntry::make('approval_date')
                                ->label(__('application.field.approval_date'))
                                ->weight(FontWeight::SemiBold)
                                ->date('j-M-Y')
                                ->placeholder('-'),
                        ]),
                    Section::make()
                        ->label(__('application.section.akad.heading'))
                        ->description(__('application.section.akad.description'))
                        ->aside()
                        ->components([
                            TextEntry::make('akad_scheduled_at')
                                ->label(__('application.field.akad_scheduled_at'))
                                ->dateTime()
                                ->placeholder('-'),
                            TextEntry::make('akad_location')
                                ->label(__('application.field.akad_location'))
                                ->placeholder('-'),
                            TextEntry::make('akad_status')
                                ->label(__('application.field.akad_status'))
                                ->badge()
                                ->placeholder('-'),
                        ]),
                ])
                ->visible(fn (Get $get): bool => $get('status') == StatusType::USER),
        ];
    }
}
