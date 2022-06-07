<?php

namespace App\Exception;

use RuntimeException;

class WalletNotExistsException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('You do not have access rights or this is not your wallet');
    }
}
