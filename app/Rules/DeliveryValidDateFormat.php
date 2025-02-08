<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class DeliveryValidDateFormat implements Rule
{
    public function passes($attribute, $value)
    {
        // YYYYMMDD形式のチェック
        if (preg_match('/^\d{8}$/', $value)) {
            $year = substr($value, 0, 4);
            $month = substr($value, 4, 2);
            $day = substr($value, 6, 2);

            return checkdate((int)$month, (int)$day, (int)$year);
        }
        return false;
    }

    public function message()
    {
        return __('delivery.errors.invalid_date_format');
    }
}
