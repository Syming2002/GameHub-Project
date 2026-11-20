<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $categoryName = null;

    /**
     * @var Collection<int, BoardGame>
     */
    #[ORM\OneToMany(targetEntity: BoardGame::class, mappedBy: 'category')]
    private Collection $boardGames;

    public function __construct()
    {
        $this->boardGames = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategoryName(): ?string
    {
        return $this->categoryName;
    }

    public function setCategoryName(string $categoryName): static
    {
        $this->categoryName = $categoryName;

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
            $boardGame->setCategory($this);
        }

        return $this;
    }

    public function removeBoardGame(BoardGame $boardGame): static
    {
        if ($this->boardGames->removeElement($boardGame)) {
            // set the owning side to null (unless already changed)
            if ($boardGame->getCategory() === $this) {
                $boardGame->setCategory(null);
            }
        }

        return $this;
    }
}
