<?php


namespace App\Trade;


class TradeDirection
{
    protected static $defaultDirection = 'btcxmr';
    protected static $validDirections = [
        'btcxmr',
        'xmrbtc'
    ];
    protected static $coinMapping = [
        'btcxmr' => [
            'base' => 'btc',
            'other' => 'xmr'
        ],
        'xmrbtc' => [
            'base' => 'xmr',
            'other' => 'btc'
        ],

    ];

    public static function getDefaultDirection(): string
    {
        return self::$defaultDirection;
    }

    public static function getValidDirections(): array
    {
        return self::$validDirections;
    }

    public static function isValidDirection($direction): bool
    {
        return in_array($direction, self::getValidDirections());
    }

    public static function getOtherDirection($currentDirection): string
    {
        $otherDirection = '';
        foreach (self::getValidDirections() as $direction) {
            if ($direction !== $currentDirection) {
                $otherDirection = $direction;
                break;
            }
        }
        return $otherDirection;
    }

    public static function getBaseCoin($direction)
    {
        return self::$coinMapping[$direction]['base'];
    }

    public static function getOtherCoin($direction)
    {
        return self::$coinMapping[$direction]['other'];
    }
}
