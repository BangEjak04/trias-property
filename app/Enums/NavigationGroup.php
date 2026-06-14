<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;
use Override;

enum NavigationGroup: string implements HasLabel
{
    case Management = 'management';

    #[Override]
    public function getLabel(): string|Htmlable|null
    {
        return match ($this) {
            self::Management => __('common.navigation.groups.management'),
        };
    }
}
