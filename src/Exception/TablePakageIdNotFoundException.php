<?php

namespace App\Exception;

use RuntimeException;

class TablePakageIdNotFoundException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('no such package');
    }
}
