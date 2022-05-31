<?php

namespace App\Exception;

use RuntimeException;

class SettingOptionsAlreadyExistsException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('Failed to create new record, only one setting options record can be created');
    }
}
