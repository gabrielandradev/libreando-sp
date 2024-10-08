<?php

namespace App\Entity;

use App\Repository\CopiaLibroRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CopiaLibroRepository::class)]
class CopiaLibro
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'copiasLibro')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Libro $libro = null;

    #[ORM\ManyToOne(inversedBy: 'copiasLibros')]
    #[ORM\JoinColumn(nullable: false)]
    private ?DisponibilidadCopiaLibro $disponibilidad = null;

    /**
     * @var Collection<int, Prestamo>
     */
    #[ORM\OneToMany(targetEntity: Prestamo::class, mappedBy: 'copia_libro')]
    private Collection $prestamos;

    public function __construct()
    {
        $this->prestamos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibro(): ?Libro
    {
        return $this->libro;
    }

    public function setLibro(?Libro $libro): static
    {
        $this->libro = $libro;

        return $this;
    }

    public function getDisponibilidad(): ?DisponibilidadCopiaLibro
    {
        return $this->disponibilidad;
    }

    public function setDisponibilidad(?DisponibilidadCopiaLibro $disponibilidad): static
    {
        $this->disponibilidad = $disponibilidad;

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
            $prestamo->setCopiaLibro($this);
        }

        return $this;
    }

    public function removePrestamo(Prestamo $prestamo): static
    {
        if ($this->prestamos->removeElement($prestamo)) {
            // set the owning side to null (unless already changed)
            if ($prestamo->getCopiaLibro() === $this) {
                $prestamo->setCopiaLibro(null);
            }
        }

        return $this;
    }
}
