<?php

namespace App\Exception;

use RuntimeException;

class TypeTableNotFoundException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('requested operation not found.');
    }
}
