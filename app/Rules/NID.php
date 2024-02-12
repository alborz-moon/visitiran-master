<?php

namespace App\Rules;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Validation\Rule;

class NID implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
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
        return Controller::_custom_check_national_code($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'کدملی وارد شده نامعتبر است';
    }
}
