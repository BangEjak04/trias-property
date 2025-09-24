<?php

namespace App\Filament\Resources\Applications\Schemas;

use App\Models\Application;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\TextSize;

class ApplicationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Application Information')
                    ->collapsed(fn($record) => $record->status !== 'prospect')
                    ->icon(LucideIcon::Info)
                    ->description('Details about this application')
                    ->schema([
                        TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->size(TextSize::Large)
                            ->formatStateUsing(fn(?string $state): string => match ($state) {
                                'prospect' => 'Prospect',
                                'hot_prospect' => 'Hot Prospect',
                                'user' => 'User',
                                default => $state ?? '-',
                            })
                            ->color(fn(string $state): string => match ($state) {
                                'prospect' => 'success',
                                'hot_prospect' => 'warning',
                                'user' => 'primary',
                                default => 'gray',
                            }),
                        TextEntry::make('created_at')
                            ->label('Created At')
                            ->dateTime()
                            ->weight(FontWeight::SemiBold),
                        TextEntry::make('updated_at')
                            ->label('Updated At')
                            ->dateTime()
                            ->weight(FontWeight::SemiBold),
                        TextEntry::make('name')
                            ->label('Name')
                            ->size(TextSize::Large)
                            ->weight(FontWeight::Bold),
                        TextEntry::make('email')
                            ->label('Email')
                            ->weight(FontWeight::SemiBold),
                        TextEntry::make('phone')
                            ->label('Phone')
                            ->weight(FontWeight::SemiBold),
                        TextEntry::make('developer')
                            ->label('Developer')
                            ->weight(FontWeight::SemiBold),
                        TextEntry::make('location')
                            ->label('Location')
                            ->weight(FontWeight::SemiBold),
                        TextEntry::make('price_range_start')
                            ->label('Price Range Start')
                            ->beforeContent('IDR')
                            ->numeric(decimalPlaces: 0)
                            ->weight(FontWeight::SemiBold),
                        TextEntry::make('price_range_end')
                            ->label('Price Range End')
                            ->beforeContent('IDR')
                            ->numeric(decimalPlaces: 0)
                            ->weight(FontWeight::SemiBold),
                        TextEntry::make('notes')
                            ->label('Notes')
                            ->weight(FontWeight::SemiBold)
                            ->html(),
                        Grid::make()
                            ->schema([
                                TextEntry::make('price')
                                    ->label('Price')
                                    ->beforeContent('IDR')
                                    ->numeric(decimalPlaces: 0)
                                    ->weight(FontWeight::SemiBold),
                                TextEntry::make('address')
                                    ->label('Address')
                                    ->weight(FontWeight::SemiBold),
                                TextEntry::make('land_area')
                                    ->label('Land Area')
                                    ->formatStateUsing(fn(string $state): string => $state . ' m²')
                                    ->weight(FontWeight::SemiBold),
                                TextEntry::make('building_area')
                                    ->label('Building Area')
                                    ->formatStateUsing(fn(string $state): string => $state . ' m²')
                                    ->weight(FontWeight::SemiBold),
                                ImageEntry::make('id_card')
                                    ->label('ID Card'),
                                TextEntry::make('payment_method')
                                    ->label('Payment Method')
                                    ->weight(FontWeight::SemiBold)
                                    ->formatStateUsing(fn(?string $state): string => match ($state) {
                                        'bank_transfer' => 'Bank Transfer',
                                        'credit_card' => 'Credit Card',
                                        'cash' => 'Cash',
                                        'other' => 'Other',
                                        default => $state ?? '-',
                                    }),
                                ImageEntry::make('payment_proof')
                                    ->label('Payment Proof'),
                            ])
                            ->columns(1)
                            ->hidden(fn(callable $get) => $get('status') !== 'user')
                    ])
                    ->columnSpanFull(),
                Section::make('Comment')
                    ->icon(LucideIcon::MessagesSquare)
                    ->description('Discussion about this application')
                    ->collapsible()
                    ->collapsed(fn($record) => $record->status === 'prospect')
                    ->schema([
                        TextEntry::make('comments')
                            ->state(function (Application $record) {
                                if (method_exists($record, 'comments')) {
                                    return $record->comments()->with('user')->latest()->get();
                                }

                                return collect();
                            })
                            ->view('filament.infolists.components.latest-comment')
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
