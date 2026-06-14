<?php

namespace App\Models;

use Database\Factories\ProductKnowledgeFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'url', 'order', 'is_active'])]
class ProductKnowledge extends Model
{
    /** @use HasFactory<ProductKnowledgeFactory> */
    use HasFactory;

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
