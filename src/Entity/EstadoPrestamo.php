<?php

namespace App\Entity;

use App\Repository\EstadoPrestamoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EstadoPrestamoRepository::class)]
class EstadoPrestamo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $estado = null;

    /**
     * @var Collection<int, Prestamo>
     */
    #[ORM\OneToMany(targetEntity: Prestamo::class, mappedBy: 'estado_prestamo')]
    private Collection $prestamos;

    public function __construct()
    {
        $this->prestamos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEstado(): ?string
    {
        return $this->estado;
    }

    public function setEstado(string $estado): static
    {
        $this->estado = $estado;

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
            $prestamo->setEstadoPrestamo($this);
        }

        return $this;
    }

    public function removePrestamo(Prestamo $prestamo): static
    {
        if ($this->prestamos->removeElement($prestamo)) {
            // set the owning side to null (unless already changed)
            if ($prestamo->getEstadoPrestamo() === $this) {
                $prestamo->setEstadoPrestamo(null);
            }
        }

        return $this;
    }
}
