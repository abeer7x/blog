<?php

namespace App\Rules;
use Illuminate\Contracts\Validation\Rule;

class ValidDate implements Rule {
    /**
     * Run the validation rule.
     */

     public function passes($attribute, $value)
     {
        if (!$value) {
            return false;
        }
        return strtotime($value) !== false && strtotime($value) > time();
    }

    public function message()
    {
        return 'The date is not valid';
    }     
    
}
