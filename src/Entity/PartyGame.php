<?php

namespace App\Entity;

use App\Repository\PartyGameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PartyGameRepository::class)]
class PartyGame
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $partyGameName = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $partyGameDescription = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $availableSpace = null;

    #[ORM\ManyToOne(inversedBy: 'partyGame')]
    private ?BoardGame $boardGame = null;

    /**
     * @var Collection<int, Booking>
     */
    #[ORM\OneToMany(targetEntity: Booking::class, mappedBy: 'partyGame')]
    private Collection $booking;

    public function __construct()
    {
        $this->booking = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPartyGameName(): ?string
    {
        return $this->partyGameName;
    }

    public function setPartyGameName(?string $partyGameName): static
    {
        $this->partyGameName = $partyGameName;

        return $this;
    }

    public function getPartyGameDescription(): ?string
    {
        return $this->partyGameDescription;
    }

    public function setPartyGameDescription(?string $partyGameDescription): static
    {
        $this->partyGameDescription = $partyGameDescription;

        return $this;
    }

    public function getAvailableSpace(): ?int
    {
        return $this->availableSpace;
    }

    public function setAvailableSpace(int $availableSpace): static
    {
        $this->availableSpace = $availableSpace;

        return $this;
    }

    public function getBoardGame(): ?BoardGame
    {
        return $this->boardGame;
    }

    public function setBoardGame(?BoardGame $boardGame): static
    {
        $this->boardGame = $boardGame;

        return $this;
    }

    /**
     * @return Collection<int, Booking>
     */
    public function getBooking(): Collection
    {
        return $this->booking;
    }

    public function addBooking(Booking $booking): static
    {
        if (!$this->booking->contains($booking)) {
            $this->booking->add($booking);
            $booking->setPartyGame($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): static
    {
        if ($this->booking->removeElement($booking)) {
            // set the owning side to null (unless already changed)
            if ($booking->getPartyGame() === $this) {
                $booking->setPartyGame(null);
            }
        }

        return $this;
    }
}
