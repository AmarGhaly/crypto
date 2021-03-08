<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class WalletSendException extends Exception
{
    protected $coin;
    public function __construct($coin,$message = "", $code = 0, Throwable $previous = null)
    {
        $this->coin = $coin;
        parent::__construct($message, $code, $previous);
    }

    public function getCoin()
    {
        return $this->coin;
    }
}
