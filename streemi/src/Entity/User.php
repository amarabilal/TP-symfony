<?php

namespace App\Entity;

use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $username = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $emailAddress = null;

    #[ORM\Column(length: 255)]
    private ?string $hashedPassword = null;

    #[ORM\Column(type: 'json')]
    private array $roles = [];

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * This method is required by UserInterface
     */
    public function getUserIdentifier(): string
    {
        return $this->emailAddress; // Utilise l'email comme identifiant unique
    }

    public function getUsername(): ?string
    {
        return $this->username; // Optionnel pour rétrocompatibilité
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getEmailAddress(): ?string
    {
        return $this->emailAddress;
    }

    public function setEmailAddress(string $emailAddress): self
    {
        $this->emailAddress = $emailAddress;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->hashedPassword;
    }

    public function setPassword(string $hashedPassword): self
    {
        $this->hashedPassword = $hashedPassword;

        return $this;
    }

    public function getRoles(): array
    {
        // Guarantee every user has at least ROLE_USER
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function eraseCredentials(): void
    {
        // Cette méthode est nécessaire pour l'interface UserInterface
        // Elle est laissée vide car tu n'as pas de données sensibles temporaires
    }
}
