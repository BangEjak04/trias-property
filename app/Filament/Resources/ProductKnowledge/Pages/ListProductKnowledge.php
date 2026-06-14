<?php

namespace App\Filament\Resources\ProductKnowledge\Pages;

use App\Filament\Resources\ProductKnowledge\ProductKnowledgeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListProductKnowledge extends ListRecords
{
    protected static string $resource = ProductKnowledgeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
