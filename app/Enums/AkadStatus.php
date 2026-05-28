<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;
use Override;

enum AkadStatus: string implements HasColor, HasLabel
{
    case ON_PROGRESS = 'on_progress';
    case DONE = 'done';
    case CANCELED = 'canceled';

    #[Override]
    public function getLabel(): string|Htmlable|null
    {
        return match ($this) {
            self::ON_PROGRESS => 'On Progress',
            self::DONE => 'Done',
            self::CANCELED => 'Canceled',
        };
    }

    #[Override]
    public function getColor(): string|array|null
    {
        return match ($this) {
            self::ON_PROGRESS => 'gray',
            self::DONE => 'success',
            self::CANCELED => 'danger',
        };
    }
}
