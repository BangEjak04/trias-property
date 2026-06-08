<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('user.section.information.label'))
                    ->description(__('user.section.information.description'))
                    ->aside()
                    ->components([
                        TextInput::make('name')
                            ->label(__('user.field.name'))
                            ->required(),
                        TextInput::make('username')
                            ->label(__('user.field.username'))
                            ->required(),
                        TextInput::make('email')
                            ->label(__('user.field.email'))
                            ->required(),
                        Select::make('roles')
                            ->label(__('user.field.role'))
                            ->relationship('roles', 'name')
                            ->multiple()
                            ->preload()
                            ->searchable()
                            ->getOptionLabelFromRecordUsing(fn (Model $record): string => Str::headline($record->name)),
                    ]),
                Section::make(__('user.section.password.label'))
                    ->description(__('user.section.password.description'))
                    ->aside()
                    ->components([
                        Grid::make(1)
                            ->components([
                                TextInput::make('password')
                                    ->label(__('user.field.password'))
                                    ->required()
                                    ->password()
                                    ->rule(Password::default()),
                            ])->visibleOn('create'),
                        Grid::make(1)
                            ->components([
                                TextInput::make('new_password')
                                    ->label(__('user.field.password_change'))
                                    ->password()
                                    ->rule(Password::default()),
                                TextInput::make('new_password_confirmation')
                                    ->label(__('user.field.password_confirmation'))
                                    ->requiredIfAccepted('new_password')
                                    ->same('new_password'),
                            ])->visibleOn('edit'),
                    ]),
            ])
            ->columns(1);
    }
}
