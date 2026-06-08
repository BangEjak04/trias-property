<?php

namespace App\Filament\Resources\Applications\Schemas;

use App\Filament\Resources\Applications\Schemas\Infolists\ApplicationHotProspectInfolist;
use App\Filament\Resources\Applications\Schemas\Infolists\ApplicationProspectInfolist;
use App\Filament\Resources\Applications\Schemas\Infolists\ApplicationUserInfolist;
use App\Models\Application;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
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
                            ->weight(FontWeight::SemiBold)
                            ->placeholder('-'),
                        TextEntry::make('priority')
                            ->label(__('application.field.priority'))
                            ->weight(FontWeight::SemiBold)
                            ->placeholder('-'),
                        TextEntry::make('applicant_name')
                            ->label(__('application.field.applicant_name'))
                            ->weight(FontWeight::SemiBold)
                            ->placeholder('-'),
                        TextEntry::make('applicant_phone')
                            ->label(__('application.field.applicant_phone'))
                            ->weight(FontWeight::SemiBold)
                            ->formatStateUsing(fn ($state) => $state ? '+62'.$state : '-')
                            ->url(fn ($state) => $state ? 'https://wa.me/+62'.$state : null)
                            ->openUrlInNewTab()
                            ->placeholder('-'),
                        TextEntry::make('applicant_email')
                            ->label(__('application.field.applicant_email'))
                            ->weight(FontWeight::SemiBold)
                            ->url(fn ($state) => $state ? 'mailto:'.$state : null)
                            ->openUrlInNewTab()
                            ->placeholder('-'),
                    ]),
                ...ApplicationProspectInfolist::get(),
                ...ApplicationHotProspectInfolist::get(),
                ...ApplicationUserInfolist::get(),
                Section::make(__('application.comment.heading'))
                    ->icon(LucideIcon::MessagesSquare)
                    ->description(__('application.comment.description'))
                    ->collapsible()
                    ->collapsed(fn ($record) => $record->status === 'prospect')
                    ->schema([
                        TextEntry::make('comments')
                            ->state(function (Application $record) {
                                if (method_exists($record, 'comments')) {
                                    return $record->comments()->with('user')->latest()->get();
                                }

                                return collect();
                            })
                            ->view('filament.infolists.components.latest-comment'),
                    ])
                    ->columnSpanFull(),
            ])
            ->columns(1);
    }
}
