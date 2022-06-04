<?php

namespace App\Exception;

use RuntimeException;

class PakegeUserNotExistsException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('User has no purchased packages');
    }
}
