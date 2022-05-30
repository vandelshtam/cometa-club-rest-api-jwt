<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Table(name: '`user`')]
#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\Column(type: 'string')]
    private string $firstName;

    #[ORM\Column(type: 'string', nullable: true)]
    private string $lastName;

    #[ORM\Column(type: 'string', unique: true)]
    private string $email;

    #[ORM\Column(type: 'string')]
    private string $password;

    #[ORM\Column(type: 'simple_array')]
    private array $roles;

    #[ORM\Column(type: 'integer')]
    private $user_id;

    #[ORM\Column(type: 'string', length: 255)]
    private $referral_link;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $personal_data_id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $pesonal_code;

    #[ORM\Column(type: 'string', length: 255)]
    private $secret_code;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $locale;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $pakage_status;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $pakage_id;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $multi_pakage;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $created_at;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $updated_at;

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function eraseCredentials(): void
    {
    }

    public function getUsername(): string
    {
        return $this->email;
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getReferralLink(): ?string
    {
        return $this->referral_link;
    }

    public function setReferralLink(string $referral_link): self
    {
        $this->referral_link = $referral_link;

        return $this;
    }

    public function getPersonalDataId(): ?int
    {
        return $this->personal_data_id;
    }

    public function setPersonalDataId(?int $personal_data_id): self
    {
        $this->personal_data_id = $personal_data_id;

        return $this;
    }

    public function getPesonalCode(): ?string
    {
        return $this->pesonal_code;
    }

    public function setPesonalCode(?string $pesonal_code): self
    {
        $this->pesonal_code = $pesonal_code;

        return $this;
    }

    public function getSecretCode(): ?string
    {
        return $this->secret_code;
    }

    public function setSecretCode(string $secret_code): self
    {
        $this->secret_code = $secret_code;

        return $this;
    }

    public function getLocale(): ?string
    {
        return $this->locale;
    }

    public function setLocale(?string $locale): self
    {
        $this->locale = $locale;

        return $this;
    }

    public function getPakageStatus(): ?int
    {
        return $this->pakage_status;
    }

    public function setPakageStatus(?int $pakage_status): self
    {
        $this->pakage_status = $pakage_status;

        return $this;
    }

    public function getPakageId(): ?int
    {
        return $this->pakage_id;
    }

    public function setPakageId(?int $pakage_id): self
    {
        $this->pakage_id = $pakage_id;

        return $this;
    }

    public function getMultiPakage(): ?int
    {
        return $this->multi_pakage;
    }

    public function setMultiPakage(?int $multi_pakage): self
    {
        $this->multi_pakage = $multi_pakage;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(?\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }
}
