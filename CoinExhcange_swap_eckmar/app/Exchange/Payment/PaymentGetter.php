<?php


namespace App\Exchange\Payment;


class PaymentGetter
{
    public static function getPayment($coin) : Coin
    {
        $payment = config('coins.coin_list')[$coin];
        return new $payment;
    }
}
