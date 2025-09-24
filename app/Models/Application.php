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
        'price_range_start',
        'price_range_end',
        'notes',
        'price',
        'address',
        'land_area',
        'building_area',
        'id_card',
        'payment_method',
        'payment_proof',
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
