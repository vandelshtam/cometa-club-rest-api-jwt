<?php

namespace App\Exception;

use RuntimeException;

class TypeTokenNotExistsException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('No such type of token');
    }
}
