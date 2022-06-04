<?php

namespace App\Model;

use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\EqualTo;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class SavingMailRequest
{
    #[Email]
    #[NotBlank]
    private string $to_mail;


    public function getToMail(): string
    {
        return $this->to_mail;
    }

    public function setToMail(string $to_mail): self
    {
        $this->to_mail = $to_mail;

        return $this;
    }

}
