<?php

namespace App\Rules;
use Illuminate\Contracts\Validation\Rule;

class ValidSlug implements Rule
{
    public function passes($attribute, $value)
    {
        return preg_match('/^[a-z0-9\-]+$/', $value);
    }

    public function message()
    {
        return 'The :attribute must contain only lowercase letters, numbers, and dashes.';
    }
}

