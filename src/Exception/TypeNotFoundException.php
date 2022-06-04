<?php

namespace App\Exception;

use RuntimeException;

class TypeNotFoundException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('requested operation type does not exist');
    }
}
