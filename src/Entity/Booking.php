<?php

namespace App\Entity;

use App\Repository\BookingRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookingRepository::class)]
class Booking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTime $bookingDate = null;

    #[ORM\ManyToOne(inversedBy: 'booking')]
    private ?PartyGame $partyGame = null;

    #[ORM\ManyToOne(inversedBy: 'bookings')]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBookingDate(): ?\DateTime
    {
        return $this->bookingDate;
    }

    public function setBookingDate(\DateTime $bookingDate): static
    {
        $this->bookingDate = $bookingDate;

        return $this;
    }

    public function getPartyGame(): ?PartyGame
    {
        return $this->partyGame;
    }

    public function setPartyGame(?PartyGame $partyGame): static
    {
        $this->partyGame = $partyGame;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
