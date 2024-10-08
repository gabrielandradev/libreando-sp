<?php

namespace App\Entity;

use App\Repository\EspecialidadRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EspecialidadRepository::class)]
class Especialidad
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nombre = null;

    /**
     * @var Collection<int, Estudiante>
     */
    #[ORM\OneToMany(targetEntity: Estudiante::class, mappedBy: 'especialidad')]
    private Collection $estudiantes;

    public function __construct()
    {
        $this->estudiantes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * @return Collection<int, Estudiante>
     */
    public function getEstudiantes(): Collection
    {
        return $this->estudiantes;
    }

    public function addEstudiante(Estudiante $estudiante): static
    {
        if (!$this->estudiantes->contains($estudiante)) {
            $this->estudiantes->add($estudiante);
            $estudiante->setEspecialidad($this);
        }

        return $this;
    }

    public function removeEstudiante(Estudiante $estudiante): static
    {
        if ($this->estudiantes->removeElement($estudiante)) {
            // set the owning side to null (unless already changed)
            if ($estudiante->getEspecialidad() === $this) {
                $estudiante->setEspecialidad(null);
            }
        }

        return $this;
    }
}
