<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;
use Override;

enum PriorityType: string implements HasColor, HasLabel
{
    case LOW = 'low';
    case MEDIUM = 'medium';
    case HIGH = 'high';

    #[Override]
    public function getLabel(): string|Htmlable|null
    {
        return match ($this) {
            self::LOW => __('application.field.priority.type.low'),
            self::MEDIUM => __('application.field.priority.type.medium'),
            self::HIGH => __('application.field.priority.type.high'),
        };
    }

    #[Override]
    public function getColor(): string|array|null
    {
        return match ($this) {
            self::LOW => 'success',
            self::MEDIUM => 'warning',
            self::HIGH => 'danger',
        };
    }
}
