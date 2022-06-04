<?php

namespace App\Exception;

use RuntimeException;

class DateNotFoundException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('no data found with the specified date');
    }
}
