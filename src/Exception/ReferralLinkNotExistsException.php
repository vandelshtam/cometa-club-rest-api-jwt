<?php

namespace App\Exception;

use RuntimeException;

class ReferralLinkNotExistsException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('Referral link is not valid or entered incorrectly');
    }
}
