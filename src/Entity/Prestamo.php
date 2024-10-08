<?php

namespace App\Entity;

use App\Repository\PrestamoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PrestamoRepository::class)]
class Prestamo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'prestamos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CopiaLibro $copia_libro = null;

    #[ORM\ManyToOne(inversedBy: 'prestamos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Usuario $prestatario = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fecha_solicitud = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $fecha_prestamo = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $fecha_devolucion = null;

    #[ORM\ManyToOne(inversedBy: 'prestamos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?EstadoPrestamo $estado_prestamo = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCopiaLibro(): ?CopiaLibro
    {
        return $this->copia_libro;
    }

    public function setCopiaLibro(?CopiaLibro $copia_libro): static
    {
        $this->copia_libro = $copia_libro;

        return $this;
    }

    public function getPrestatario(): ?Usuario
    {
        return $this->prestatario;
    }

    public function setPrestatario(?Usuario $prestatario): static
    {
        $this->prestatario = $prestatario;

        return $this;
    }

    public function getFechaSolicitud(): ?\DateTimeInterface
    {
        return $this->fecha_solicitud;
    }

    public function setFechaSolicitud(\DateTimeInterface $fecha_solicitud): static
    {
        $this->fecha_solicitud = $fecha_solicitud;

        return $this;
    }

    public function getFechaPrestamo(): ?\DateTimeInterface
    {
        return $this->fecha_prestamo;
    }

    public function setFechaPrestamo(?\DateTimeInterface $fecha_prestamo): static
    {
        $this->fecha_prestamo = $fecha_prestamo;

        return $this;
    }

    public function getFechaDevolucion(): ?\DateTimeInterface
    {
        return $this->fecha_devolucion;
    }

    public function setFechaDevolucion(?\DateTimeInterface $fecha_devolucion): static
    {
        $this->fecha_devolucion = $fecha_devolucion;

        return $this;
    }

    public function getEstadoPrestamo(): ?EstadoPrestamo
    {
        return $this->estado_prestamo;
    }

    public function setEstadoPrestamo(?EstadoPrestamo $estado_prestamo): static
    {
        $this->estado_prestamo = $estado_prestamo;

        return $this;
    }
}
