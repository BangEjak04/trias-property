<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Illuminate\Validation\Rules\Password;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('username')
                    ->required(),
                TextInput::make('email')
                    ->email()
                    ->required(),
                Grid::make(1)
                    ->schema([
                        TextInput::make('password')
                            ->required()
                            ->rule(Password::default()),
                    ])
                    ->visibleOn('create'),
                Grid::make(1)
                    ->schema([
                        TextInput::make('new_password')
                            ->label('New Password')
                            ->nullable()
                            ->rule(Password::default()),
                        TextInput::make('new_password_confirmation')
                            ->requiredIfAccepted('new_password')
                            ->same('new_password'),
                    ])
                    ->visibleOn('edit'),
                Select::make('roles')
                    ->relationship('roles', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->visible(fn (): bool => auth()->user()->hasRole('super_admin')),
            ])
            ->columns(1);
    }
}
