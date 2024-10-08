<?php

namespace App\Entity;

use App\Repository\ListaDeseadosRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ListaDeseadosRepository::class)]
class ListaDeseados
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, Libro>
     */
    #[ORM\ManyToMany(targetEntity: Libro::class)]
    private Collection $libro;

    #[ORM\OneToOne(inversedBy: 'listaDeseados', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Usuario $usuario = null;

    public function __construct()
    {
        $this->libro = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Libro>
     */
    public function getLibros(): Collection
    {
        return $this->libro;
    }

    public function addLibro(Libro $libro): static
    {
        if (!$this->libro->contains($libro)) {
            $this->libro->add($libro);
        }

        return $this;
    }

    public function removeLibro(Libro $libro): static
    {
        $this->libro->removeElement($libro);

        return $this;
    }

    public function getUsuario(): ?Usuario
    {
        return $this->usuario;
    }

    public function setUsuario(Usuario $usuario): static
    {
        $this->usuario = $usuario;

        return $this;
    }
}
