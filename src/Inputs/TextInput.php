<?php

declare(strict_types=1);

namespace InvolveDigital\LaravelForms\Inputs;

use InvolveDigital\LaravelForms\Traits\THasLabel;
use InvolveDigital\LaravelForms\Traits\THasTooltip;
use InvolveDigital\LaravelForms\Traits\THasType;

class TextInput extends BaseField
{

    use THasLabel;
    use THasTooltip;
    use THasType;

    public ?int $maxLength = null;

    public static function make(string $modelField, ?string $label = null): static
    {
        $input = new static();
        $input->setModel($modelField);
        $input->setLabel($label);
        $input->setType('text');
        $input->setThemeType('text');
        $input->setView('laravel-livewire-forms::components.text-input');

        return $input;
    }

    public function getMaxLength(): ?int
    {
        return $this->maxLength;
    }

    public function setMaxLength(?int $maxLength): static
    {
        $this->maxLength = $maxLength;

        return $this;
    }

}
