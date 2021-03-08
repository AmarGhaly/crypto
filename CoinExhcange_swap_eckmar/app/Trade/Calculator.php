<?php


namespace App\Trade;


class Calculator
{
    protected $fee;
    protected $base;

    public function __construct(float $base)
    {
        $this->base = $base;
        $this->fee = intval(config('settings.fee_percentage'));
    }

    public function increaseTotal(): float
    {
        return $this->base * (1 + $this->fee / 100);
    }
    public function decreaseTotal(): float
    {
        return $this->base * (1 - $this->fee / 100);
    }

    public function getFeePercentage(): int
    {
        return $this->fee;
    }

    public function getFeeAmount(): float
    {
        return $this->base - $this->decreaseTotal();
    }

}
