<?php

namespace App\Model;

use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class PakegeRequest
{
    #[NotBlank]
    private int $user_id;

    #[NotBlank]
    private int $pakage_id;

    #[NotBlank]
    private string $type_token;

    
    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getPakageId(): int
    {
        return $this->pakage_id;
    }

    public function setPakageId(int $pakage_id): self
    {
        $this->pakage_id = $pakage_id;

        return $this;
    }

    public function getTypeToken(): string
    {
        return $this->type_token;
    }

    public function setTypeToken(string $type_token): self
    {
        $this->type_token = $type_token;

        return $this;
    }

}
