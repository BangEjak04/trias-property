<?php

namespace App\Filament\Resources\ProductKnowledge;

use App\Enums\NavigationGroup;
use App\Filament\Resources\ProductKnowledge\Pages\CreateProductKnowledge;
use App\Filament\Resources\ProductKnowledge\Pages\EditProductKnowledge;
use App\Filament\Resources\ProductKnowledge\Pages\ListProductKnowledge;
use App\Filament\Resources\ProductKnowledge\Pages\ViewProductKnowledge;
use App\Filament\Resources\ProductKnowledge\Schemas\ProductKnowledgeForm;
use App\Filament\Resources\ProductKnowledge\Schemas\ProductKnowledgeInfolist;
use App\Filament\Resources\ProductKnowledge\Tables\ProductKnowledgeTable;
use App\Models\ProductKnowledge;
use BackedEnum;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class ProductKnowledgeResource extends Resource
{
    protected static ?string $model = ProductKnowledge::class;

    protected static string|BackedEnum|null $navigationIcon = LucideIcon::Link;

    protected static string|UnitEnum|null $navigationGroup = NavigationGroup::Management;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return ProductKnowledgeForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ProductKnowledgeInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProductKnowledgeTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProductKnowledge::route('/'),
            'create' => CreateProductKnowledge::route('/create'),
            'view' => ViewProductKnowledge::route('/{record}'),
            'edit' => EditProductKnowledge::route('/{record}/edit'),
        ];
    }
}
