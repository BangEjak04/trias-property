<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Application extends Model
{
    /** @use HasFactory<\Database\Factories\ApplicationFactory> */
    use HasFactory;

    protected $fillable = [
        'status',
        'priority',
        'approval',
        'name',
        'email',
        'phone',
        'developer',
        'location',
        'price_range_from',
        'price_range_to',
        'notes',
        'price',
        'address',
        'property',
        'type',
        'block',
        'number',
        'land_area',
        'building_area',
        'id_card',
        'bank_name',
        'payment_method',
        'payment_proof',
        'down_payment_date',
        'marketing_agent',
        'document_progress',
        'approval_date',
        'credit_approval',
    ];

    protected $casts = [
        'price_range_from' => 'double',
        'price_range_to' => 'double',
        'price' => 'double',
    ];

    public function comments(): HasMany
    {
        return $this->hasMany(ApplicationComment::class)->orderBy('created_at', 'asc');
    }
}
