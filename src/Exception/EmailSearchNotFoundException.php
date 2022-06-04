<?php

namespace App\Exception;

use RuntimeException;

class EmailSearchNotFoundException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('Record with entered email not found');
    }
}
