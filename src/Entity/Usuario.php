<?php

namespace App\Entity;

use App\Repository\UsuarioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UsuarioRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'Ya existe una cuenta con este email')]
class Usuario implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank]
    #[Assert\Email(
        message: 'El email {{ value }} no es una dirección de email válida.',
    )]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Assert\NotBlank]
    private ?string $password = null;

    #[ORM\OneToOne(mappedBy: 'usuario', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private ?Estudiante $estudiante = null;

    #[ORM\OneToOne(mappedBy: 'usuario', cascade: ['persist', 'remove'])]
    private ?Profesor $profesor = null;

    /**
     * @var Collection<int, Prestamo>
     */
    #[ORM\OneToMany(targetEntity: Prestamo::class, mappedBy: 'prestatario')]
    private Collection $prestamos;

    #[ORM\Column]
    private ?bool $es_usuario_activo = null;

    #[ORM\OneToOne(mappedBy: 'usuario', cascade: ['persist', 'remove'])]
    private ?ListaDeseados $listaDeseados = null;

    #[ORM\OneToOne(mappedBy: 'usuario', cascade: ['persist', 'remove'])]
    private ?Administrador $administrador = null;

    /**
     * @var Collection<int, Reserva>
     */
    #[ORM\OneToMany(targetEntity: Reserva::class, mappedBy: 'usuario', orphanRemoval: true)]
    private Collection $reservas;

    public function __construct()
    {
        $this->prestamos = new ArrayCollection();
        $this->reservas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getEstudiante(): ?Estudiante
    {
        return $this->estudiante;
    }

    public function setEstudiante(Estudiante $estudiante): static
    {
        // set the owning side of the relation if necessary
        if ($estudiante->getUsuario() !== $this) {
            $estudiante->setUsuario($this);
        }

        $this->estudiante = $estudiante;

        return $this;
    }

    public function getProfesor(): ?Profesor
    {
        return $this->profesor;
    }

    public function setProfesor(Profesor $profesor): static
    {
        // set the owning side of the relation if necessary
        if ($profesor->getUsuario() !== $this) {
            $profesor->setUsuario($this);
        }

        $this->profesor = $profesor;

        return $this;
    }

    /**
     * @return Collection<int, Prestamo>
     */
    public function getPrestamos(): Collection
    {
        return $this->prestamos;
    }

    public function addPrestamo(Prestamo $prestamo): static
    {
        if (!$this->prestamos->contains($prestamo)) {
            $this->prestamos->add($prestamo);
            $prestamo->setPrestatario($this);
        }

        return $this;
    }

    public function removePrestamo(Prestamo $prestamo): static
    {
        if ($this->prestamos->removeElement($prestamo)) {
            // set the owning side to null (unless already changed)
            if ($prestamo->getPrestatario() === $this) {
                $prestamo->setPrestatario(null);
            }
        }

        return $this;
    }

    public function esUsuarioActivo(): ?bool
    {
        return $this->es_usuario_activo;
    }

    public function setEsUsuarioActivo(bool $es_usuario_activo): static
    {
        $this->es_usuario_activo = $es_usuario_activo;

        return $this;
    }

    public function getListaDeseados(): ?ListaDeseados
    {
        return $this->listaDeseados;
    }

    public function setListaDeseados(ListaDeseados $listaDeseados): static
    {
        // set the owning side of the relation if necessary
        if ($listaDeseados->getUsuario() !== $this) {
            $listaDeseados->setUsuario($this);
        }

        $this->listaDeseados = $listaDeseados;

        return $this;
    }

    public function getAdministrador(): ?Administrador
    {
        return $this->administrador;
    }

    public function setAdministrador(Administrador $administrador): static
    {
        // set the owning side of the relation if necessary
        if ($administrador->getUsuario() !== $this) {
            $administrador->setUsuario($this);
        }

        $this->administrador = $administrador;

        return $this;
    }

    /**
     * @return Collection<int, Reserva>
     */
    public function getReservas(): Collection
    {
        return $this->reservas;
    }

    public function addReserva(Reserva $reserva): static
    {
        if (!$this->reservas->contains($reserva)) {
            $this->reservas->add($reserva);
            $reserva->setUsuario($this);
        }

        return $this;
    }

    public function removeReserva(Reserva $reserva): static
    {
        if ($this->reservas->removeElement($reserva)) {
            // set the owning side to null (unless already changed)
            if ($reserva->getUsuario() === $this) {
                $reserva->setUsuario(null);
            }
        }

        return $this;
    }
}
