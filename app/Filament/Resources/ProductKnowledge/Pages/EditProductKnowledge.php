<?php

namespace App\Filament\Resources\ProductKnowledge\Pages;

use App\Filament\Resources\ProductKnowledge\ProductKnowledgeResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditProductKnowledge extends EditRecord
{
    protected static string $resource = ProductKnowledgeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
