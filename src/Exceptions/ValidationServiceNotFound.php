<?php

namespace App\Exceptions;

class ValidationServiceNotFound extends \Exception
{

    /**
     * @param string $message
     */
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}