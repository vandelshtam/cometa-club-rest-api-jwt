<?php

namespace App\Exception;

use RuntimeException;

class CategoryTableNotFoundException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('The entry with the entered category was not found.');
    }
}
