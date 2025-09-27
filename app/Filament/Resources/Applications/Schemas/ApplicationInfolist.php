<?php

namespace App\Filament\Resources\Applications\Schemas;

use App\Models\Application;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Fieldset;
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
                Section::make('Informasi')
                    ->collapsed(fn($record) => $record->status !== 'prospect')
                    ->icon(LucideIcon::Info)
                    ->description('Detail tentang permohonan')
                    ->schema([
                        TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->size(TextSize::Large)
                            ->formatStateUsing(fn(?string $state): string => match ($state) {
                                'prospect' => 'Prospect',
                                'hot_prospect' => 'Hot Prospect',
                                'user' => 'User',
                                default => $state ?? null,
                            })
                            ->color(fn(string $state): string => match ($state) {
                                'prospect' => 'success',
                                'hot_prospect' => 'warning',
                                'user' => 'primary',
                                default => 'gray',
                            }),
                        Grid::make(1)
                            ->schema([
                                TextEntry::make('priority')
                                    ->label('Prioritas')
                                    ->badge()
                                    ->size(TextSize::Large)
                                    ->formatStateUsing(fn(?string $state): string => match ($state) {
                                        'high' => 'High',
                                        'mid' => 'Mid',
                                        'low' => 'Low',
                                        default => $state ?? null,
                                    })
                                    ->color(fn(string $state): string => match ($state) {
                                        'high' => 'danger',
                                        'mid' => 'warning',
                                        'low' => 'success',
                                        default => 'gray',
                                    }),
                                TextEntry::make('created_at')
                                    ->label('Dibuat')
                                    ->dateTime()
                                    ->weight(FontWeight::SemiBold),
                                TextEntry::make('updated_at')
                                    ->label('Diubah')
                                    ->dateTime()
                                    ->weight(FontWeight::SemiBold),
                                TextEntry::make('name')
                                    ->label('Nama')
                                    ->size(TextSize::Large)
                                    ->weight(FontWeight::Bold),
                                TextEntry::make('phone')
                                    ->label('Telepon')
                                    ->weight(FontWeight::SemiBold),
                                TextEntry::make('email')
                                    ->label('Email')
                                    ->weight(FontWeight::SemiBold),
                                TextEntry::make('developer')
                                    ->label('Developer')
                                    ->weight(FontWeight::SemiBold),
                                TextEntry::make('property')
                                    ->label('Properti')
                                    ->weight(FontWeight::SemiBold),
                                TextEntry::make('type')
                                    ->label('Tipe')
                                    ->weight(FontWeight::SemiBold),
                                Fieldset::make('Rentang Harga')
                                    ->schema([
                                        TextEntry::make('price_range_start')
                                            ->label('Dari')
                                            ->beforeContent('Rp')
                                            ->numeric(decimalPlaces: 0)
                                            ->weight(FontWeight::SemiBold),
                                            TextEntry::make('price_range_end')
                                                ->label('Sampai')
                                                ->beforeContent('Rp')
                                                ->numeric(decimalPlaces: 0)
                                                ->weight(FontWeight::SemiBold),
                                    ]),
                                TextEntry::make('notes')
                                    ->label('Catatan')
                                    ->weight(FontWeight::SemiBold)
                                    ->html(),
                            ])
                            ->visible(fn(callable $get) => $get('status') == 'prospect'),
                        Grid::make(1)
                            ->schema([
                                TextEntry::make('created_at')
                                    ->label('Dibuat')
                                    ->dateTime()
                                    ->weight(FontWeight::SemiBold),
                                TextEntry::make('updated_at')
                                    ->label('Diubah')
                                    ->dateTime()
                                    ->weight(FontWeight::SemiBold),
                                TextEntry::make('name')
                                    ->label('Nama')
                                    ->size(TextSize::Large)
                                    ->weight(FontWeight::Bold),
                                TextEntry::make('phone')
                                    ->label('Telepon')
                                    ->weight(FontWeight::SemiBold),
                                TextEntry::make('email')
                                    ->label('Email')
                                    ->weight(FontWeight::SemiBold),
                                TextEntry::make('developer')
                                    ->label('Developer')
                                    ->weight(FontWeight::SemiBold),
                                TextEntry::make('property')
                                    ->label('Properti')
                                    ->weight(FontWeight::SemiBold),
                                TextEntry::make('type')
                                    ->label('Tipe')
                                    ->weight(FontWeight::SemiBold),
                                Fieldset::make('Rentang Harga')
                                    ->schema([
                                        TextEntry::make('price_range_start')
                                            ->label('Dari')
                                            ->beforeContent('Rp')
                                            ->numeric(decimalPlaces: 0)
                                            ->weight(FontWeight::SemiBold),
                                            TextEntry::make('price_range_end')
                                                ->label('Sampai')
                                                ->beforeContent('Rp')
                                                ->numeric(decimalPlaces: 0)
                                                ->weight(FontWeight::SemiBold),
                                    ]),
                                TextEntry::make('notes')
                                    ->label('Catatan')
                                    ->weight(FontWeight::SemiBold)
                                    ->html(),
                                TextEntry::make('marketing_agent')
                                    ->label('Marketing Agent')
                                    ->weight(FontWeight::SemiBold),
                            ])
                            ->visible(fn(callable $get) => $get('status') == 'hot_prospect'),
                        Grid::make(1)
                            ->schema([
                                TextEntry::make('created_at')
                                    ->label('Dibuat')
                                    ->dateTime()
                                    ->weight(FontWeight::SemiBold),
                                TextEntry::make('updated_at')
                                    ->label('Diubah')
                                    ->dateTime()
                                    ->weight(FontWeight::SemiBold),
                                TextEntry::make('name')
                                    ->label('Nama')
                                    ->size(TextSize::Large)
                                    ->weight(FontWeight::Bold),
                                TextEntry::make('phone')
                                    ->label('Telepon')
                                    ->weight(FontWeight::SemiBold),
                                TextEntry::make('email')
                                    ->label('Email')
                                    ->weight(FontWeight::SemiBold),
                                TextEntry::make('marketing_agent')
                                    ->label('Marketing Agent')
                                    ->weight(FontWeight::SemiBold),
                                TextEntry::make('notes')
                                    ->label('Catatan')
                                    ->weight(FontWeight::SemiBold)
                                    ->html(),
                                TextEntry::make('developer')
                                    ->label('Developer')
                                    ->weight(FontWeight::SemiBold),
                                TextEntry::make('property')
                                    ->label('Properti')
                                    ->weight(FontWeight::SemiBold),
                                TextEntry::make('type')
                                    ->label('Tipe')
                                    ->weight(FontWeight::SemiBold),
                                Grid::make(2)
                                    ->schema([
                                        TextEntry::make('block')
                                            ->label('Blok')
                                            ->weight(FontWeight::SemiBold),
                                        TextEntry::make('number')
                                            ->label('Nomor')
                                            ->weight(FontWeight::SemiBold),
                                        TextEntry::make('building_area')
                                            ->label('Luas Bangunan')
                                            ->formatStateUsing(fn(string $state): string => $state . ' m²')
                                            ->weight(FontWeight::SemiBold),
                                        TextEntry::make('land_area')
                                                ->label('Luas Tanah')
                                                ->formatStateUsing(fn(string $state): string => $state . ' m²')
                                                ->weight(FontWeight::SemiBold),
                                    ]),
                                TextEntry::make('price')
                                    ->label('Harga')
                                    ->beforeContent('Rp')
                                    ->numeric(decimalPlaces: 0)
                                    ->weight(FontWeight::SemiBold),
                                TextEntry::make('payment_method')
                                    ->label('Cara Pembelian')
                                    ->weight(FontWeight::SemiBold)
                                    ->formatStateUsing(fn(?string $state): string => match ($state) {
                                        'cash' => 'Cash',
                                        'home_credit' => 'KPR',
                                        'inhouse' => 'Inhouse',
                                        default => $state ?? null,
                                    }),
                                ImageEntry::make('id_card')
                                    ->label('Kartu Tanda Penduduk'),
                                TextEntry::make('down_payment_date')
                                    ->date()
                                    ->label('Tanggal UTJ'),
                                TextEntry::make('payment_proof')
                                    ->label('Bukti UTJ'),
                                Fieldset::make('Progress Bank')
                                    ->schema([
                                        TextEntry::make('bank_name')
                                            ->label('Nama Bank'),
                                        TextEntry::make('document_progress')
                                            ->label('Progress Dokumen'),
                                        TextEntry::make('approval')
                                            ->badge()
                                            ->formatStateUsing(fn (string $state): string => match ($state) {
                                                'accepted' => 'Acc',
                                                'rejected' => 'Reject',
                                            })
                                            ->color(fn (string $state): string => match ($state) {
                                                'accepted' => 'info',
                                                'rejected' => 'danger',
                                            })
                                            ->label('Approval'),
                                        TextEntry::make('approval_date')
                                            ->date()
                                            ->label('Tanggal Akad')
                                            ->visible(fn ($get): string => $get('approval') == 'accepted'),
                                    ])
                                    ->columns(1),
                            ])
                            ->visible(fn(callable $get) => $get('status') == 'user'),
                    ])
                    ->columnSpanFull(),
                Section::make('Komentar')
                    ->icon(LucideIcon::MessagesSquare)
                    ->description('Diskusi tentang permohonan')
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
