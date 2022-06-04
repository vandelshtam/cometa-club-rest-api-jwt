<?php

namespace App\Exception;

use RuntimeException;

class EmailNotFoundException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('email not found');
    }
}
