<?php

namespace App\Entity;

use App\Repository\FavouriteStationsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FavouriteStationsRepository::class)]
class FavouriteStations
{

    #[ORM\Id]
    #[ORM\Column]
    private ?int $IdStation = null;

    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'favouriteStations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $IdUser = null;

    public function getIdStation(): ?int
    {
        return $this->IdStation;
    }

    public function setIdStation(int $IdStation): static
    {
        $this->IdStation = $IdStation;

        return $this;
    }

    public function getIdUser(): ?User
    {
        return $this->IdUser;
    }

    public function setIdUser(?User $IdUser): static
    {
        $this->IdUser = $IdUser;

        return $this;
    }
}
