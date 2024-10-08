<?php

namespace App\Entity;

use App\Repository\DisponibilidadCopiaLibroRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DisponibilidadCopiaLibroRepository::class)]
class DisponibilidadCopiaLibro
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $estado = null;

    /**
     * @var Collection<int, CopiaLibro>
     */
    #[ORM\OneToMany(targetEntity: CopiaLibro::class, mappedBy: 'disponibilidad')]
    private Collection $copiasLibros;

    public function __construct()
    {
        $this->copiasLibros = new ArrayCollection();
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
     * @return Collection<int, CopiaLibro>
     */
    public function getCopiasLibros(): Collection
    {
        return $this->copiasLibros;
    }

    public function addCopiasLibro(CopiaLibro $copiasLibro): static
    {
        if (!$this->copiasLibros->contains($copiasLibro)) {
            $this->copiasLibros->add($copiasLibro);
            $copiasLibro->setDisponibilidad($this);
        }

        return $this;
    }

    public function removeCopiasLibro(CopiaLibro $copiasLibro): static
    {
        if ($this->copiasLibros->removeElement($copiasLibro)) {
            // set the owning side to null (unless already changed)
            if ($copiasLibro->getDisponibilidad() === $this) {
                $copiasLibro->setDisponibilidad(null);
            }
        }

        return $this;
    }
}
