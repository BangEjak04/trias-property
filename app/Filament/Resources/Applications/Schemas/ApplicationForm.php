<?php

namespace App\Filament\Resources\Applications\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ApplicationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
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
                Grid::make(1)
                    ->schema([
                        Select::make('priority')
                            ->options([
                                'high' => 'High',
                                'mid' => 'Mid',
                                'low' => 'Low',
                            ])
                            ->native(false)
                            ->live()
                            ->label('Prioritas'),
                        TextInput::make('name')->required()->maxLength(255)->label('Nama'),
                        TextInput::make('phone')->required()->tel()->label('Nomor Telepon'),
                        TextInput::make('email')->email()->maxLength(255)->label('Email'),
                        TextInput::make('developer')->maxLength(255)->label('Developer'),
                        TextInput::make('property')->maxLength(255)->label('Properti'),
                        TextInput::make('type')
                            // ->required()
                            ->maxLength(255)
                            ->label('Tipe'),
                        Fieldset::make()
                            ->label('Rentang Harga')
                            ->schema([TextInput::make('price_range_from')->numeric()->minValue(1)->label('Dari')->prefix('Rp'), TextInput::make('price_range_to')->numeric()->minValue(1)->label('Sampai')->prefix('Rp')]),
                    ])
                    ->visible(fn($get) => $get('status') == 'prospect'),
                Grid::make(1)
                    ->schema([
                        Select::make('priority')
                            ->options([
                                'high' => 'High',
                                'mid' => 'Mid',
                                'low' => 'Low',
                            ])
                            ->native(false)
                            ->live()
                            ->label('Prioritas'),
                        TextInput::make('name')->required()->maxLength(255)->label('Nama'),
                        TextInput::make('phone')->required()->tel()->label('Nomor Telepon'),
                        TextInput::make('email')->email()->maxLength(255)->label('Email'),
                        TextInput::make('developer')->maxLength(255)->label('Developer'),
                        TextInput::make('property')->maxLength(255)->label('Properti'),
                        TextInput::make('type')
                            // ->required()
                            ->maxLength(255)
                            ->label('Tipe'),
                        Fieldset::make()
                            ->label('Rentang Harga')
                            ->schema([TextInput::make('price_range_from')->numeric()->minValue(1)->label('Dari')->prefix('Rp'), TextInput::make('price_range_to')->numeric()->minValue(1)->label('Sampai')->prefix('Rp')]),
                        TextInput::make('marketing_agent')->label('Marketing Agent'),
                    ])
                    ->visible(fn($get) => $get('status') == 'hot_prospect'),
                Grid::make(1)
                    ->schema([
                        TextInput::make('name')->required()->maxLength(255)->label('Nama'),
                        TextInput::make('phone')->required()->tel()->label('Nomor Telepon'),
                        TextInput::make('email')->email()->maxLength(255)->label('Email'),
                        TextInput::make('marketing_agent'),
                        TextInput::make('developer')->maxLength(255)->label('Developer'),
                        TextInput::make('property')->maxLength(255)->label('Properti'),
                        TextInput::make('type')
                            // ->required()
                            ->maxLength(255)
                            ->label('Tipe'),
                        Grid::make(2)->schema([
                            TextInput::make('block')
                                // ->required()
                                ->maxLength(255)
                                ->label('Block'),
                            TextInput::make('number')
                                // ->required()
                                ->maxLength(255)
                                ->label('Number'),
                        ]),
                        TextInput::make('price')
                            // ->required()
                            ->numeric()
                            ->minValue(1)
                            ->label('Price')
                            ->prefix('Rp'),
                        Select::make('payment_method')
                            // ->required()
                            ->options([
                                'cash' => 'Cash',
                                'bank_transfer' => 'KPR',
                                'credit_card' => 'Inhouse',
                            ])
                            ->native(false)
                            ->label('Cara Pembelian'),
                        FileUpload::make('id_card')
                            // ->required()
                            ->label('Kartu Tanda Penduduk')
                            ->image()
                            ->maxSize(2048)
                            ->imagePreviewHeight('250')
                            ->directory('id-cards'),
                        DatePicker::make('down_payment_date')->native(false)->label('Tanggal UTJ'),
                        FileUpload::make('payment_proof')->label('Bukti UTJ')->image()->maxSize(2048)->imagePreviewHeight('250')->directory('payment-proofs'),
                        Section::make('Progress Bank')->schema([
                            TextInput::make('bank_name')->maxLength(255)->label('Nama Bank'),
                            TextInput::make('document_progress')->maxLength(255)->label('Progress Berkas'),
                            TextInput::make('credit_approval')
                                // ->required()
                                ->numeric()
                                ->minValue(1)
                                ->label('Acc KPR')
                                ->prefix('Rp'),
                            Select::make('approval')
                                ->options([
                                    'accepted' => 'Acc',
                                    'rejected' => 'Reject',
                                ])
                                ->native(false)
                                ->live()
                                ->label('Approval'),
                            DatePicker::make('approval_date')->native(false)->label('Tanggal Akad'),
                        ]),
                    ])
                    ->visible(fn($get) => $get('status') == 'user'),
            ])
            ->columns(1);
    }
}
