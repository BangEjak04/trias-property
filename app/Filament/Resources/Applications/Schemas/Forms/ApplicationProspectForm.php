<?php

namespace App\Filament\Resources\Applications\Schemas\Forms;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;

class ApplicationProspectForm
{
    public static function get(): array
    {
        return [
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
                        ->schema([
                            TextInput::make('price_range_from')->numeric()->minValue(1)->label('Dari')->prefix('Rp'), TextInput::make('price_range_to')->numeric()->minValue(1)->label('Sampai')->prefix('Rp')
                        ]),
                    RichEditor::make('notes')
                        ->label('Catatan'),
                ])
                ->visible(fn($get) => $get('status') == 'prospect')
        ];
    }
}
