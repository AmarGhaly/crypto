<?php


namespace App\Traits;


trait TradeStates
{
    protected static $availableStates = [
        'waiting_payment',
        'waiting_confirmation',
        'processing',
        'complete',
        'refunded',
        'canceled'
    ];
    protected static $privateStates = [
        'refunded',
        'canceled'
    ];

    public static function getAvailableStates(): array
    {
        return self::$availableStates;
    }

    public static function getStateFriendlyName($state)
    {
        return ucwords(str_replace("_", " ", $state));
    }

    public static function getStateOriginalName($friendlyName)
    {
        return strtolower(str_replace(" ", "_", $friendlyName));
    }

    public static function getPublicStates()
    {
        $states = [];
        foreach (self::getAvailableStates() as $state) {
            if (!in_array($state, self::$privateStates)) {
                array_push($states, self::getStateFriendlyName($state));
            }
        }
        return $states;
    }

    public static function getPendingState(): string
    {
        return 'waiting_payment';
    }
    public static function getWaitingConfirmationState(): string
    {
        return 'waiting_confirmation';
    }
    public static function getProcessingState(): string
    {
        return 'processing';
    }
    public static function getCanceledState(): string
    {
        return 'canceled';
    }
    public static function getRefundedState(): string
    {
        return 'refunded';
    }
    public static function getCompletedState(): string
    {
        return 'complete';
    }

    public function isPending(): bool
    {
        return $this->state == self::getPendingState();
    }
    public function isWaitingConfirmations(): bool
    {
        return $this->state == self::getWaitingConfirmationState();
    }
    public function isProcessing(): bool
    {
        return $this->state == self::getProcessingState();
    }
    public function isCanceled(): bool
    {
        return $this->state == self::getCanceledState();
    }
}
