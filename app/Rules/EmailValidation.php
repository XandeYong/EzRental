<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class EmailValidation implements Rule
{

    public function __construct()
    {
        //

    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        //
        $domainPart = explode('@', $value)[1] ?? null;

        if (!$domainPart) {
          return false;
        }
      
        if ($domainPart != 'gmail.com' && $domainPart != 'yahoo.com') {
          return false;
        }

        return true;

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Invalid email format. Only allow gmail.com and yahoo.com';
    }
}
