<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class IsNotTheAuthUserEmail implements Rule
{

    public function passes($attribute, $value)
    {
        return $value != auth()->user()->email;
    }

    public function message()
    {
        return "You can't transfer to your own email.";
    }
}
