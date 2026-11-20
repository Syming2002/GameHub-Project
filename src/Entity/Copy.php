<?php

namespace App\Entity;

use App\Repository\CopyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CopyRepository::class)]
class Copy
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $copyNumber = null;

    /**
     * @var Collection<int, BoardGame>
     */
    #[ORM\OneToMany(targetEntity: BoardGame::class, mappedBy: 'copy')]
    private Collection $boardGames;

    public function __construct()
    {
        $this->boardGames = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCopyNumber(): ?int
    {
        return $this->copyNumber;
    }

    public function setCopyNumber(int $copyNumber): static
    {
        $this->copyNumber = $copyNumber;

        return $this;
    }

    /**
     * @return Collection<int, BoardGame>
     */
    public function getBoardGames(): Collection
    {
        return $this->boardGames;
    }

    public function addBoardGame(BoardGame $boardGame): static
    {
        if (!$this->boardGames->contains($boardGame)) {
            $this->boardGames->add($boardGame);
            $boardGame->setCopy($this);
        }

        return $this;
    }

    public function removeBoardGame(BoardGame $boardGame): static
    {
        if ($this->boardGames->removeElement($boardGame)) {
            // set the owning side to null (unless already changed)
            if ($boardGame->getCopy() === $this) {
                $boardGame->setCopy(null);
            }
        }

        return $this;
    }
}
