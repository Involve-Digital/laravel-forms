<?php

declare(strict_types=1);

namespace InvolveDigital\LaravelForms\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use InvolveDigital\LaravelForms\Inputs\Select;

class InOptions implements ValidationRule
{

    public function __construct(private readonly Select $select)
    {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value === null || $value === '' || $value === []) {
            return;
        }

        $options = $this->select->getOptions();
        $allowedValues = array_map('strval', array_keys($options));
        $values = is_array($value) ? $value : [$value];

        foreach ($values as $item) {
            $isValid = is_scalar($item) && in_array((string) $item, $allowedValues, true);

            if (!$isValid) {
                $fail('validation.in')->translate();

                return;
            }
        }
    }

}