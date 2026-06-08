<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('user.section.information.label'))
                    ->description(__('user.section.information.description'))
                    ->aside()
                    ->components([
                        TextEntry::make('name')
                            ->label(__('user.field.name')),
                        TextEntry::make('username')
                            ->label(__('user.field.username')),
                        TextEntry::make('email')
                            ->label(__('user.field.email')),
                        TextEntry::make('roles.name')
                            ->label(__('user.field.role'))
                            ->badge()
                            ->formatStateUsing(fn (string $state): string => Str::headline($state)),
                    ]),
            ])
            ->columns(1);
    }
}
