<?php

namespace App\Exceptions;

use Exception;

class objetiveNotFoundException extends Exception
{
    public function __construct($message = "Objetivo no encontrado", $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
