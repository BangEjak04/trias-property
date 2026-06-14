<?php

namespace App\Filament\Resources\ProductKnowledge\Pages;

use App\Filament\Resources\ProductKnowledge\ProductKnowledgeResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewProductKnowledge extends ViewRecord
{
    protected static string $resource = ProductKnowledgeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
