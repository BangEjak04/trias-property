<?php

namespace App\Filament\Widgets;

use App\Models\ProductKnowledge;
use Filament\Widgets\Widget;

class ProductKnowledgeWidget extends Widget
{
    protected string $view = 'filament.widgets.product-knowledge-widget';

    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 1;

    public function getProductKnowledges()
    {
        return ProductKnowledge::query()->where('is_active', true)->orderBy('order')->get();
    }
}
