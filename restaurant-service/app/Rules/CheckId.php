<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;

class CheckId implements Rule
{


    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute,$value)
    {
        if(strlen(trim($value)) != 9){
            return false;
        }
        $b = 0;
        for ($i=1; $i < 9; $i++) {
            $a = (int)substr($value,$i-1,1);
            if($i % 2 == 0){
                $a = $a * 2;
            }
            if($a > 9){
                $a = $a - 9;
            }
            $b = $b + $a;
        }
        $b = $b % 10;
        $b = (10 - $b) % 10;
        if($b == (int)substr($value,8,1)){
            return true;
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'يرجي إدخال رقم هوية صحيح ';
    }
}
