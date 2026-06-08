<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;
use Override;

enum AkadStatus: string implements HasColor, HasLabel
{
    case SCHEDULED = 'scheduled';
    case DONE = 'done';
    case CANCELLED = 'cancelled';

    #[Override]
    public function getLabel(): string|Htmlable|null
    {
        return match ($this) {
            self::SCHEDULED => __('application.field.akad_status_type_scheduled'),
            self::DONE => __('application.field.akad_status_type_done'),
            self::CANCELLED => __('application.field.akad_status_type_cancelled'),
        };
    }

    #[Override]
    public function getColor(): string|array|null
    {
        return match ($this) {
            self::SCHEDULED => 'gray',
            self::DONE => 'success',
            self::CANCELLED => 'danger',
        };
    }
}
