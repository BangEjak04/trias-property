<?php

namespace App\Filament\Resources\Applications\Schemas;

use App\Filament\Resources\Applications\Schemas\Infolists\ApplicationHotProspectInfolist;
use App\Filament\Resources\Applications\Schemas\Infolists\ApplicationProspectInfolist;
use App\Filament\Resources\Applications\Schemas\Infolists\ApplicationUserInfolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;

class ApplicationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->label(__('application.section.applicant.heading'))
                    ->description(__('application.section.applicant.description'))
                    ->aside()
                    ->components([
                        TextEntry::make('status')
                            ->weight(FontWeight::SemiBold),
                        TextEntry::make('priority')
                            ->label(__('application.field.priority.label'))
                            ->weight(FontWeight::SemiBold),
                        TextEntry::make('applicant_name')
                            ->label(__('application.field.applicant.name'))
                            ->weight(FontWeight::SemiBold),
                        TextEntry::make('applicant_phone')
                            ->label(__('application.field.applicant.phone'))
                            ->weight(FontWeight::SemiBold)
                            ->formatStateUsing(fn ($state) => '+62'.$state)
                            ->url(fn ($state) => 'https://wa.me/+62'.$state)
                            ->openUrlInNewTab(),
                        TextEntry::make('applicant_email')
                            ->label(__('application.field.applicant.email'))
                            ->weight(FontWeight::SemiBold)
                            ->url(fn ($state) => 'mailto:'.$state)
                            ->openUrlInNewTab(),
                    ]),
                ...ApplicationProspectInfolist::get(),
                ...ApplicationHotProspectInfolist::get(),
                ...ApplicationUserInfolist::get(),
            ])
            ->columns(1);
    }
}
