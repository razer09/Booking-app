<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ExceedBalanceRule implements Rule
{

    public function passes($attribute, $value)
    {
        return $value <= auth()->user()->balance;
    }

    public function message()
    {
        $balance = auth()->user()->balance;
        return "The amount exceeds your balance ($$balance).";
    }
}
