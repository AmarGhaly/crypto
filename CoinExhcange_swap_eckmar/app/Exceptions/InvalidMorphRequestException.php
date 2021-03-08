<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class InvalidMorphRequestException extends Exception
{
    protected $data;
    public function __construct($data = null,$message = "", $code = 0, Throwable $previous = null)
    {
        $this->data = $data;
        parent::__construct($message, $code, $previous);
    }

    public function getData()
    {
        return $this->data;
    }
}
