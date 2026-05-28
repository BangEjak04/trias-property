<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\TextInput;
use Filament\Support\RawJs;
use Override;

class MoneyInput extends TextInput
{
    protected string $thousandsSeparator = '.';

    protected string $decimalSeparator = ',';

    protected int $decimalPlaces = 2;

    protected string $currencyPrefix = 'Rp';

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->numeric()
            ->minValue(1)
            ->prefix($this->currencyPrefix)
            ->stripCharacters($this->thousandsSeparator)
            ->mask(fn () => RawJs::make("
                \$money(\$input, '{$this->decimalSeparator}', '{$this->thousandsSeparator}', {$this->decimalPlaces})
            "));
    }

    public function thousandsSeparator(string $separator): static
    {
        $this->thousandsSeparator = $separator;

        return $this;
    }

    public function decimalSeparator(string $separator): static
    {
        $this->decimalSeparator = $separator;

        return $this;
    }

    public function decimalPlaces(int $places): static
    {
        $this->decimalPlaces = $places;

        return $this;
    }

    public function currencyPrefix(string $prefix): static
    {
        $this->currencyPrefix = $prefix;

        $this->prefix($prefix);

        return $this;
    }
}
