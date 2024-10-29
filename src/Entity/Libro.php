<?php

namespace App\Entity;

use App\Repository\LibroRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Serializer\Normalizer\NormalizableInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

#[ORM\Entity(repositoryClass: LibroRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Libro implements NormalizableInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titulo = null;

    #[ORM\Column(length: 13)]
    private ?string $isbn = null;

    #[ORM\Column(length: 255)]
    private ?string $editorial = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $numero_edicion = null;

    #[ORM\Column(length: 255)]
    private ?string $lugar_edicion = null;

    #[ORM\Column(length: 50)]
    private ?string $idioma = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $notas = null;

    #[ORM\Column(length: 20)]
    private ?string $numero_paginas = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fecha_creacion = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $fecha_edicion = null;

    /**
     * @var Collection<int, Autor>
     */
    #[ORM\ManyToMany(targetEntity: Autor::class, inversedBy: 'libros', cascade: ['persist'])]
    private Collection $autores;

    /**
     * @var Collection<int, Descriptor>
     */
    #[ORM\ManyToMany(targetEntity: Descriptor::class, inversedBy: 'libros', cascade: ['persist'])]
    private Collection $descriptores_secundarios;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Descriptor $descriptor_primario = null;

    /**
     * @var Collection<int, CopiaLibro>
     */
    #[ORM\OneToMany(targetEntity: CopiaLibro::class, mappedBy: 'libro', orphanRemoval: true, cascade: ['persist'])]
    private Collection $copiasLibro;

    #[ORM\ManyToOne(inversedBy: 'libros')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ClasificacionDecimalDewey $numero_cdd = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $publicacion_edicion = null;

    public function __construct()
    {
        $this->autores = new ArrayCollection();
        $this->descriptores_secundarios = new ArrayCollection();
        $this->copiasLibro = new ArrayCollection();
    }

    #[ORM\PrePersist]
    public function setFechaCreacionDefault(): void
    {
        $this->fecha_creacion = new \DateTimeImmutable();
    }

    #[ORM\PreUpdate]
    public function setFechaEdicionOnUpdate(): void
    {
        $this->fecha_edicion = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    #[Groups(['searchable'])]
    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): static
    {
        $this->titulo = $titulo;

        return $this;
    }
    
    public function getIsbn(): ?string
    {
        return $this->isbn;
    }

    public function setIsbn(string $isbn): static
    {
        $this->isbn = $isbn;

        return $this;
    }

    public function getEditorial(): ?string
    {
        return $this->editorial;
    }

    public function setEditorial(string $editorial): static
    {
        $this->editorial = $editorial;

        return $this;
    }

    public function getNumeroEdicion(): ?int
    {
        return $this->numero_edicion;
    }

    public function setNumeroEdicion(int $numero_edicion): static
    {
        $this->numero_edicion = $numero_edicion;

        return $this;
    }

    public function getLugarEdicion(): ?string
    {
        return $this->lugar_edicion;
    }

    public function setLugarEdicion(string $lugar_edicion): static
    {
        $this->lugar_edicion = $lugar_edicion;

        return $this;
    }

    public function getIdioma(): ?string
    {
        return $this->idioma;
    }

    public function setIdioma(string $idioma): static
    {
        $this->idioma = $idioma;

        return $this;
    }

    public function getNotas(): ?string
    {
        return $this->notas;
    }

    public function setNotas(?string $notas): static
    {
        $this->notas = $notas;

        return $this;
    }

    public function getNumeroPaginas(): ?string
    {
        return $this->numero_paginas;
    }

    public function setNumeroPaginas(string $numero_paginas): static
    {
        $this->numero_paginas = $numero_paginas;

        return $this;
    }

    public function getFechaCreacion(): ?\DateTimeInterface
    {
        return $this->fecha_creacion;
    }

    public function setFechaCreacion(\DateTimeInterface $fecha_creacion): static
    {
        $this->fecha_creacion = $fecha_creacion;

        return $this;
    }

    public function getFechaEdicion(): ?\DateTimeInterface
    {
        return $this->fecha_edicion;
    }

    public function setFechaEdicion(?\DateTimeInterface $fecha_edicion): static
    {
        $this->fecha_edicion = $fecha_edicion;

        return $this;
    }

    /**
     * @return Collection<int, Autor>
     */
    #[Groups(['searchable'])]
    public function getAutores(): Collection
    {
        return $this->autores;
    }

    public function addAutor(Autor $autore): static
    {
        if (!$this->autores->contains($autore)) {
            $this->autores->add($autore);
        }

        return $this;
    }

    public function removeAutor(Autor $autore): static
    {
        $this->autores->removeElement($autore);

        return $this;
    }

    /**
     * @return Collection<int, Descriptor>
     */
    public function getDescriptoresSecundarios(): Collection
    {
        return $this->descriptores_secundarios;
    }

    public function addDescriptoresSecundario(Descriptor $descriptoresSecundario): static
    {
        if (!$this->descriptores_secundarios->contains($descriptoresSecundario)) {
            $this->descriptores_secundarios->add($descriptoresSecundario);
        }

        return $this;
    }

    public function removeDescriptoresSecundario(Descriptor $descriptoresSecundario): static
    {
        $this->descriptores_secundarios->removeElement($descriptoresSecundario);

        return $this;
    }

    public function getDescriptorPrimario(): ?Descriptor
    {
        return $this->descriptor_primario;
    }

    public function setDescriptorPrimario(?Descriptor $descriptor_primario): static
    {
        $this->descriptor_primario = $descriptor_primario;

        return $this;
    }

    /**
     * @return Collection<int, CopiaLibro>
     */
    public function getCopiasLibro(): Collection
    {
        return $this->copiasLibro;
    }

    public function addCopiaLibro(CopiaLibro $copiasLibro): static
    {
        if (!$this->copiasLibro->contains($copiasLibro)) {
            $this->copiasLibro->add($copiasLibro);
            $copiasLibro->setLibro($this);
        }

        return $this;
    }

    public function removeCopiaLibro(CopiaLibro $copiasLibro): static
    {
        if ($this->copiasLibro->removeElement($copiasLibro)) {
            // set the owning side to null (unless already changed)
            if ($copiasLibro->getLibro() === $this) {
                $copiasLibro->setLibro(null);
            }
        }

        return $this;
    }

    public function getNumeroCdd(): ?ClasificacionDecimalDewey
    {
        return $this->numero_cdd;
    }

    public function setNumeroCdd(?ClasificacionDecimalDewey $numero_cdd): static
    {
        $this->numero_cdd = $numero_cdd;

        return $this;
    }

    public function getPublicacionEdicion(): ?\DateTimeInterface
    {
        return $this->publicacion_edicion;
    }

    public function setPublicacionEdicion(\DateTimeInterface $publicacion_edicion): static
    {
        $this->publicacion_edicion = $publicacion_edicion;

        return $this;
    }

    public function normalize(NormalizerInterface $serializer, ?string $format = null, array $context = []): array
    {
        return [
            'titulo' => $this->getTitulo(),
            'isbn' => $this->getIsbn(),
            'autores' => array_unique(array_map(function ($autor) {
              return $autor->getNombre();
            }, $this->getAutores()->toArray()))
        ];
    }
}
