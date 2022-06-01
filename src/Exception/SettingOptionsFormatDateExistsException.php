<?php

namespace App\Exception;

use RuntimeException;

class SettingOptionsFormatDateExistsException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('Date format error, please enter date in "YYYY-mm-dd" format');
    }
}
