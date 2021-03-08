<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class BalanceCheckingException extends Exception
{
    /**
     * @var string
     */
    protected $coin;

    public function __construct(string $coin, $message = "", $code = 0, Throwable $previous = null)
    {
        $this->coin = $coin;
        parent::__construct($message, $code, $previous);
    }

    public function getCoin()
    {
        return $this->coin;
    }
}
