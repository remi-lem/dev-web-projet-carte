<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 25, unique: true)]
    private ?string $Name = null;

    #[ORM\Column(length: 25, unique: true)]
    private ?string $Surname = null;

    #[ORM\Column(length: 25)]
    private ?string $Password = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $Address = null;

    #[ORM\OneToMany(mappedBy: 'IdUser', targetEntity: FavouriteStations::class)]
    private Collection $favouriteStations;

    public function __construct()
    {
        $this->favouriteStations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $Id): static
    {
        $this->Id = $Id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): static
    {
        $this->Name = $Name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->Surname;
    }

    public function setSurname(string $Surname): static
    {
        $this->Surname = $Surname;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->Password;
    }

    public function setPassword(string $Password): static
    {
        $this->Password = $Password;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->Address;
    }

    public function setAddress(string $Address): static
    {
        $this->Address = $Address;

        return $this;
    }

    /**
     * @return Collection<int, FavouriteStations>
     */
    public function getFavouriteStations(): Collection
    {
        return $this->favouriteStations;
    }

    public function addFavouriteStation(FavouriteStations $favouriteStation): static
    {
        if (!$this->favouriteStations->contains($favouriteStation)) {
            $this->favouriteStations->add($favouriteStation);
            $favouriteStation->setIdUser($this);
        }

        return $this;
    }

    public function removeFavouriteStation(FavouriteStations $favouriteStation): static
    {
        if ($this->favouriteStations->removeElement($favouriteStation)) {
            // set the owning side to null (unless already changed)
            if ($favouriteStation->getIdUser() === $this) {
                $favouriteStation->setIdUser(null);
            }
        }

        return $this;
    }
}
