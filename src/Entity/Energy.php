<?php

namespace App\Entity;

use App\Repository\EnergyRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EnergyRepository::class)
 */
class Energy
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="boolean")
     */
    private $renewable;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getRenewable(): ?bool
    {
        return $this->renewable;
    }

    public function setRenewable(bool $renewable): self
    {
        $this->renewable = $renewable;

        return $this;
    }
}
