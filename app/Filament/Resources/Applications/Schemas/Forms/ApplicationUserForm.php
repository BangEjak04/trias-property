<?php

namespace App\Filament\Resources\Applications\Schemas\Forms;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;

class ApplicationUserForm
{
    public static function get(): array
    {
        return [
            Grid::make(1)
                ->schema([
                    TextInput::make('name')->required()->maxLength(255)->label('Nama'),
                    TextInput::make('phone')->required()->tel()->label('Nomor Telepon'),
                    TextInput::make('email')->email()->maxLength(255)->label('Email'),
                    TextInput::make('marketing_agent'),
                    RichEditor::make('notes')
                        ->label('Catatan'),
                    TextInput::make('developer')->maxLength(255)->label('Developer'),
                    TextInput::make('property')->maxLength(255)->label('Properti'),
                    TextInput::make('type')
                        ->maxLength(255)
                        ->label('Tipe'),
                    Grid::make(2)->schema([
                        TextInput::make('block')
                            ->maxLength(255)
                            ->label('Blok'),
                        TextInput::make('number')
                            ->maxLength(255)
                            ->label('Nomor'),
                        TextInput::make('building_area')
                            ->numeric()
                            ->maxLength(255)
                            ->label('Luas Bangunan'),
                        TextInput::make('land_area')
                            ->numeric()
                            ->maxLength(255)
                            ->label('Luas Tanah'),
                    ]),
                    TextInput::make('price')
                        ->numeric()
                        ->minValue(1)
                        ->label('Harga')
                        ->prefix('Rp'),
                    Select::make('payment_method')
                        ->options([
                            'cash' => 'Cash',
                            'home_credit' => 'KPR',
                            'inhouse' => 'Inhouse',
                        ])
                        ->native(false)
                        ->label('Cara Pembelian'),
                    FileUpload::make('id_card')
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
                ->visible(fn($get) => $get('status') == 'user')
        ];
    }
}
