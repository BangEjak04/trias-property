<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;
use Override;

enum ApprovalStatus: string implements HasColor, HasLabel
{
    case ACCEPTED = 'accepted';
    case REJECTED = 'rejected';
    case PENDING = 'pending';

    #[Override]
    public function getLabel(): string|Htmlable|null
    {
        return match ($this) {
            self::ACCEPTED => 'Accepted',
            self::REJECTED => 'Rejected',
            self::PENDING => 'Pending',
        };
    }

    #[Override]
    public function getColor(): string|array|null
    {
        return match ($this) {
            self::ACCEPTED => 'success',
            self::REJECTED => 'danger',
            self::PENDING => 'gray',
        };
    }
}
