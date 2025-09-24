<?php

namespace App\Filament\Resources\Applications\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class ApplicationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('status')
                ->required()
                ->options([
                    'prospect' => 'Prospect',
                    'hot_prospect' => 'Hot Prospect',
                    'user' => 'User',
                ])
                ->native(false)
                ->live()
                ->label('Status'),
            Select::make('priority')
                ->required()
                ->options([
                    'high' => 'High',
                    'mid' => 'Mid',
                    'low' => 'Low',
                ])
                ->native(false)
                ->live()
                ->label('Priority'),
            Select::make('approval')
                ->required()
                ->options([
                    'accepted' => 'Accepted',
                    'rejected' => 'Rejected',
                ])
                ->native(false)
                ->live()
                ->label('Approval'),
            TextInput::make('name')
                ->required()
                ->maxLength(255)
                ->label('Name'),
            TextInput::make('email')
                ->email()
                ->maxLength(255)
                ->label('Email'),
            TextInput::make('phone')
                ->required()
                ->tel()
                ->label('Phone'),
            TextInput::make('developer')
                ->maxLength(255)
                ->label('Developer'),
            TextInput::make('location')
                ->maxLength(255)
                ->label('Location'),
            Fieldset::make()
                ->label('Price Range')
                ->schema([
                    TextInput::make('price_range_from')
                        ->numeric()
                        ->minValue(1)
                        ->label('From')
                        ->prefix('Rp'),
                    TextInput::make('price_range_to')
                        ->numeric()
                        ->minValue(1)
                        ->label('To')
                        ->prefix('Rp')
                    ]),
            RichEditor::make('notes')
                ->maxLength(65535)
                ->label('Notes'),
            TextInput::make('address')
                // ->required()
                ->maxLength(255)
                ->label('Address'),
            Grid::make()
                ->schema([
                    TextInput::make('land_area')
                        // ->required()
                        ->numeric()
                        ->minValue(1)
                        ->label('Land Area (m²)'),
                    TextInput::make('building_area')
                        // ->required()
                        ->numeric()
                        ->minValue(1)
                        ->label('Building Area (m²)'),
                    ]),
            TextInput::make('price')
                // ->required()
                ->numeric()
                ->minValue(1)
                ->label('Price')
                ->prefix('Rp'),
            FileUpload::make('id_card')
                // ->required()
                ->label('ID Card')
                ->image()
                ->maxSize(2048)
                ->imagePreviewHeight('250')
                ->directory('id-cards'),
            Select::make('payment_method')
                // ->required()
                ->options([
                    'cash' => 'Cash',
                    'bank_transfer' => 'KPR',
                    'credit_card' => 'Inhouse',
                ])
                ->native(false)
                ->label('Payment Method'),
            FileUpload::make('payment_proof')
                ->label('Payment Proof')
                ->image()
                ->maxSize(2048)
                ->imagePreviewHeight('250')
                ->directory('payment-proofs'),
            DatePicker::make('down_payemnt_date')
        ])
        ->columns(1);
    }
}
