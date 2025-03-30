<?php

namespace App\Services;

class UtilService
{
    public static function moneyFormat($amount)
    {
        return fmod($amount, 1) == 0
            ? number_format((int) $amount)
            : number_format((float) $amount, 2);
    }
}