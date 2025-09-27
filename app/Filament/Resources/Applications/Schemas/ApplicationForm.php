<?php

namespace App\Filament\Resources\Applications\Schemas;

use App\Filament\Resources\Applications\Schemas\Forms\ApplicationHotProspectForm;
use App\Filament\Resources\Applications\Schemas\Forms\ApplicationProspectForm;
use App\Filament\Resources\Applications\Schemas\Forms\ApplicationUserForm;
use Filament\Forms\Components\Select;
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
                ...ApplicationProspectForm::get(),
                ...ApplicationHotProspectForm::get(),
                ...ApplicationUserForm::get(),
            ])
            ->columns(1);
    }
}
