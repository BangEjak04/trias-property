<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;
use Override;

enum StatusType: string implements HasLabel
{
    case PROSPECT = 'prospect';
    case HOT_PROSPECT = 'hot_prospect';
    case USER = 'user';

    #[Override]
    public function getLabel(): string|Htmlable|null
    {
        return match ($this) {
            self::PROSPECT => 'Prospect',
            self::HOT_PROSPECT => 'Hot Prospect',
            self::USER => 'User',
        };
    }
}
