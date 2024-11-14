<?php

namespace App\Entity;

use App\Repository\ClasificacionDecimalDeweyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClasificacionDecimalDeweyRepository::class)]
class ClasificacionDecimalDewey
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $numero_cdd = null;

    #[ORM\Column(length: 255)]
    private ?string $descripcion = null;

    /**
     * @var Collection<int, Libro>
     */
    #[ORM\OneToMany(targetEntity: Libro::class, mappedBy: 'numero_cdd')]
    private Collection $libros;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $referencia = null;

    public function __construct()
    {
        $this->libros = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroCdd(): ?string
    {
        return $this->numero_cdd;
    }

    public function setNumeroCdd(string $numero_cdd): static
    {
        $this->numero_cdd = $numero_cdd;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): static
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * @return Collection<int, Libro>
     */
    public function getLibros(): Collection
    {
        return $this->libros;
    }

    public function addLibro(Libro $libro): static
    {
        if (!$this->libros->contains($libro)) {
            $this->libros->add($libro);
            $libro->setNumeroCdd($this);
        }

        return $this;
    }

    public function removeLibro(Libro $libro): static
    {
        if ($this->libros->removeElement($libro)) {
            // set the owning side to null (unless already changed)
            if ($libro->getNumeroCdd() === $this) {
                $libro->setNumeroCdd(null);
            }
        }

        return $this;
    }

    public function getReferencia(): ?string
    {
        return $this->referencia;
    }

    public function setReferencia(?string $referencia): static
    {
        $this->referencia = $referencia;

        return $this;
    }
}
