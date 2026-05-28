<?php

namespace App\Filament\Resources\Applications\Schemas\Forms;

use App\Enums\AkadStatus;
use App\Enums\ApprovalStatus;
use App\Enums\PaymentMethod;
use App\Enums\StatusType;
use App\Filament\Forms\Components\MoneyInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;

class ApplicationUserForm
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
                    Section::make(__('application.section.internal.heading'))
                        ->description(__('application.section.internal.description'))
                        ->aside()
                        ->components([
                            TextInput::make('marketing_agent'),
                            RichEditor::make('notes'),
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
                            TextInput::make('property_block')
                                ->maxLength(255)
                                ->label(__('application.field.property.block')),
                            TextInput::make('property_number')
                                ->maxLength(255)
                                ->label(__('application.field.property.number')),
                            Grid::make()
                                ->components([
                                    TextInput::make('building_area')
                                        ->label(__('application.field.property.building_area'))
                                        ->numeric()
                                        ->suffix('m²'),
                                    TextInput::make('land_area')
                                        ->label(__('application.field.property.land_area'))
                                        ->numeric()
                                        ->suffix('m²'),
                                ])
                                ->columns(['default' => 2]),
                            MoneyInput::make('price')
                                ->label(__('application.field.property.price')),
                            MoneyInput::make('down_payment_amount')
                                ->label(__('application.field.down_payment_amount')),
                            MoneyInput::make('loan_amount')
                                ->label(__('application.field.loan_amount')),
                        ]),
                    Section::make(__('application.section.credit.heading'))
                        ->description(__('application.section.credit.description'))
                        ->aside()
                        ->components([
                            Select::make('payment_method')
                                ->label(__('application.field.payment_method'))
                                ->options(PaymentMethod::class)
                                ->native(false),
                            DatePicker::make('down_payment_date')
                                ->label(__('application.field.down_payment_date'))
                                ->native(false),
                            FileUpload::make('down_payment_proof')
                                ->label(__('application.field.down_payment_proof'))
                                ->image()
                                ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
                                ->maxSize(2048)
                                ->imagePreviewHeight('250')
                                ->directory('payment-proofs'),
                            FileUpload::make('id_card')
                                ->label(__('application.field.id_card'))
                                ->image()
                                ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
                                ->maxSize(2048)
                                ->imagePreviewHeight('250')
                                ->directory('id-cards'),
                        ]),
                    Section::make(__('application.section.approval.heading'))
                        ->description(__('application.section.approval.description'))
                        ->aside()
                        ->components([
                            TextInput::make('bank_name')
                                ->label(__('application.field.bank_name')),
                            TextInput::make('document_progress')
                                ->label(__('application.field.document_progress')),
                            Select::make('approval_status')
                                ->label(__('application.field.approval'))
                                ->options(ApprovalStatus::class)
                                ->native(false),
                            MoneyInput::make('credit_approval')
                                ->label(__('application.field.credit_approval')),
                            DatePicker::make('approval_date')
                                ->label(__('application.field.approval_date'))
                                ->native(false),
                        ]),
                    Section::make(__('application.section.akad.heading'))
                        ->description(__('application.section.akad.description'))
                        ->aside()
                        ->components([
                            DateTimePicker::make('akad_scheduled_at')
                                ->label(__('application.field.akad_scheduled_at'))
                                ->native(false)
                                ->seconds(false),
                            TextInput::make('akad_location')
                                ->label(__('application.field.akad_location'))
                                ->maxLength(255)
                                ->placeholder(__('application.field.akad_location_placeholder')),
                            Select::make('akad_status')
                                ->label(__('application.field.akad_status'))
                                ->options(AkadStatus::class),
                        ]),
                ])
                ->columns(1)
                ->visible(fn (Get $get): bool => $get('status') === StatusType::USER),
        ];
    }
}
