<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;
use Override;

enum PaymentMethod: string implements HasLabel
{
    case CASH = 'cash';
    case HOME_CREDIT = 'home_credit';
    case INHOUSE = 'inhouse';

    #[Override]
    public function getLabel(): string|Htmlable|null
    {
        return match ($this) {
            self::CASH => 'Cash',
            self::HOME_CREDIT => 'Home Credit',
            self::INHOUSE => 'Inhouse',
        };
    }
}
