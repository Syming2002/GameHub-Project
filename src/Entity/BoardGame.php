<?php

namespace App\Entity;

use App\Repository\BoardGameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BoardGameRepository::class)]
class BoardGame
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $numberPlayer = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTime $averageDuration = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $minAge = null;

    #[ORM\ManyToOne(inversedBy: 'boardGames')]
    private ?Copy $copy = null;

    #[ORM\ManyToOne(inversedBy: 'boardGames')]
    private ?Category $category = null;

    /**
     * @var Collection<int, PartyGame>
     */
    #[ORM\OneToMany(targetEntity: PartyGame::class, mappedBy: 'boardGame')]
    private Collection $partyGame;

    public function __construct()
    {
        $this->partyGame = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getNumberPlayer(): ?int
    {
        return $this->numberPlayer;
    }

    public function setNumberPlayer(int $numberPlayer): static
    {
        $this->numberPlayer = $numberPlayer;

        return $this;
    }

    public function getAverageDuration(): ?\DateTime
    {
        return $this->averageDuration;
    }

    public function setAverageDuration(\DateTime $averageDuration): static
    {
        $this->averageDuration = $averageDuration;

        return $this;
    }

    public function getMinAge(): ?int
    {
        return $this->minAge;
    }

    public function setMinAge(int $minAge): static
    {
        $this->minAge = $minAge;

        return $this;
    }

    public function getCopy(): ?Copy
    {
        return $this->copy;
    }

    public function setCopy(?Copy $copy): static
    {
        $this->copy = $copy;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, PartyGame>
     */
    public function getPartyGame(): Collection
    {
        return $this->partyGame;
    }

    public function addPartyGame(PartyGame $partyGame): static
    {
        if (!$this->partyGame->contains($partyGame)) {
            $this->partyGame->add($partyGame);
            $partyGame->setBoardGame($this);
        }

        return $this;
    }

    public function removePartyGame(PartyGame $partyGame): static
    {
        if ($this->partyGame->removeElement($partyGame)) {
            // set the owning side to null (unless already changed)
            if ($partyGame->getBoardGame() === $this) {
                $partyGame->setBoardGame(null);
            }
        }

        return $this;
    }
}
