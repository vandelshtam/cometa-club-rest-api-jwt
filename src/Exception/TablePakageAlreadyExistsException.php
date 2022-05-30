<?php

namespace App\Exception;

use RuntimeException;

class TablePakageAlreadyExistsException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('pakage already exists');
    }
}
