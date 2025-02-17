<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    // Identificador único del usuario
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    // Correo electrónico del usuario
    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> Los roles del usuario
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string La contraseña encriptada
     */
    #[ORM\Column]
    private ?string $password = null;

    // Obtener el identificador del usuario
    public function getId(): ?int
    {
        return $this->id;
    }

    // Obtener el correo electrónico del usuario
    public function getEmail(): ?string
    {
        return $this->email;
    }

    // Establecer el correo electrónico del usuario
    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Un identificador visual que representa a este usuario.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     * @return list<string>
     */
    // Obtener los roles del usuario
    public function getRoles(): array
    {
        $roles = $this->roles;
        // garantizar que cada usuario tenga al menos ROLE_USER
        //$roles = ['ROLE_USER'];

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    // Establecer los roles del usuario
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;
        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    // Obtener la contraseña del usuario
    public function getPassword(): ?string
    {
        return $this->password;
    }

    // Establecer la contraseña del usuario
    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    // Borrar credenciales temporales o sensibles del usuario
    public function eraseCredentials(): void
    {
        // Si almacenas datos temporales o sensibles en el usuario, límpialos aquí
        // $this->plainPassword = null;
    }
}
