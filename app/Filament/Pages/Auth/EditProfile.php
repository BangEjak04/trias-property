<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\EditProfile as BaseEditProfile;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Override;

class EditProfile extends BaseEditProfile
{
    #[Override]
    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make(__('user.section.information.label'))
                ->description(__('user.section.information.description'))
                ->aside()
                ->components([
                    TextInput::make('username')
                        ->label(__('auth.field.username'))
                        ->required()
                        ->unique()
                        ->maxLength(255),
                    $this->getNameFormComponent(),
                    $this->getEmailFormComponent(),
                ]),
            Section::make(__('user.section.password.label'))
                ->description(__('user.section.password.description'))
                ->aside()
                ->components([
                    $this->getPasswordFormComponent(),
                    $this->getPasswordConfirmationFormComponent(),
                ]),
        ]);
    }
}
