<?php

declare(strict_types=1);

namespace Dungeon;

/**
 * La rareté d'un objet. Niveau 4.
 * Enum "backed" : chaque cas porte une valeur string, utilisable avec Rarity::from().
 */
enum Rarity: string
{
    case Common = 'common';
    case Rare = 'rare';
    case Legendary = 'legendary';

    /** Doit renvoyer le coefficient de valeur : 1.0, 1.5 ou 3.0. */
    public function multiplier(): float
    {
        throw new \LogicException('À implémenter');
    }

    /** Doit renvoyer le libellé français : "Commun", "Rare", "Légendaire". */
    public function label(): string
    {
        throw new \LogicException('À implémenter');
    }
}
