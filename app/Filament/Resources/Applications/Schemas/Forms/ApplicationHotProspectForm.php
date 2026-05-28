<?php

namespace App\Filament\Resources\Applications\Schemas\Forms;

use App\Enums\StatusType;
use App\Filament\Forms\Components\MoneyInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;

class ApplicationHotProspectForm
{
    public static function get(): array
    {
        return [
            Grid::make()
                ->components([
                    Section::make(__('application.section.applicant.heading'))
                        ->description(__('application.section.applicant.description'))
                        ->aside()
                        ->components([
                            TextInput::make('applicant_name')
                                ->required()
                                ->maxLength(255)
                                ->label(__('application.field.applicant.name')),
                            TextInput::make('applicant_phone')
                                ->required()
                                ->tel()
                                ->prefix('+62')
                                ->label(__('application.field.applicant.phone')),
                            TextInput::make('applicant_email')
                                ->email()
                                ->maxLength(255)
                                ->label(__('application.field.applicant.email')),
                        ]),
                    Section::make(__('application.section.property.heading'))
                        ->description(__('application.section.property.description'))
                        ->aside()
                        ->components([
                            TextInput::make('developer')
                                ->maxLength(255)
                                ->label(__('application.field.developer')),
                            TextInput::make('property_name')
                                ->maxLength(255)
                                ->label(__('application.field.property.name')),
                            TextInput::make('property_type')
                                ->maxLength(255)
                                ->label(__('application.field.property.type')),
                            Fieldset::make()
                                ->label(__('application.field.property.price_range.label'))
                                ->components([
                                    MoneyInput::make('price_range_from')
                                        ->label(__('application.field.property.price_range.minimum')),
                                    MoneyInput::make('price_range_to')
                                        ->label(__('application.field.property.price_range.maximum'))
                                        ->gte('price_range_from'),
                                ]),
                        ]),
                    Section::make(__('application.section.internal.heading'))
                        ->description(__('application.section.internal.description'))
                        ->aside()
                        ->components([
                            TextInput::make('marketing_agent'),
                            RichEditor::make('notes'),
                        ]),
                ])
                ->columns(1)
                ->visible(fn (Get $get): bool => $get('status') === StatusType::HOT_PROSPECT),
        ];
    }
}
