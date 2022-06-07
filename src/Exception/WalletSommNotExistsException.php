<?php

namespace App\Exception;

use RuntimeException;

class WalletSommNotExistsException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('You do not have enough funds, replenish your balance or select another token.');
    }
}
