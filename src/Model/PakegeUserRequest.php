<?php

namespace App\Model;

use Symfony\Component\Validator\Constraints\NotBlank;

class PakegeUserRequest
{
    #[NotBlank]
    private int $user_id;

    
    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }
}
