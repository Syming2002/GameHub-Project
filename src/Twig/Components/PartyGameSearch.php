<?php

namespace App\Twig\Components;

use App\Repository\PartyGameRepository;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
final class PartyGameSearch
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public string $partyGameName = "";


    public function __construct(private PartyGameRepository $partyGameRepository) {
        
    }

    public function getPartyGames(): array {
        if ($this->partyGameName === "") {
            return $this->partyGameRepository->findAll();
        }

        return $this->partyGameRepository->rechercheParTitre($this->partyGameName);
    }
}
