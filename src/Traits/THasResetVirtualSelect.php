<?php

declare(strict_types=1);

namespace InvolveDigital\LaravelForms\Traits;

use InvolveDigital\LaravelForms\Inputs\VirtualSelect;
use ReflectionMethod;

trait THasResetVirtualSelect
{

    protected function resetVirtualSelect(string $modelToReset, array $options = []): void
    {
        $this->dispatch("resetVirtualSelect:$modelToReset", $options);
    }

}
