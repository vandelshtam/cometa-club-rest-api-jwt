<?php

namespace App\Exception;

use RuntimeException;

class RoleUserNotExistsException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('You entered the user role incorrectly, enter one of the roles in the "ROLE_SUPERADMIN","ROLE_ADMIN","ROLE_USER"');
    }
}
