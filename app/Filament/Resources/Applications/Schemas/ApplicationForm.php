<?php

namespace App\Filament\Resources\Applications\Schemas;

use App\Enums\StatusType;
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
                    ->options(StatusType::class)
                    ->native(false)
                    ->live(),
                ...ApplicationProspectForm::get(),
                ...ApplicationHotProspectForm::get(),
                ...ApplicationUserForm::get(),
            ])
            ->columns(1);
    }
}
