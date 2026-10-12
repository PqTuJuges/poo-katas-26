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
        return match ($this) {
            self::Common => 1.0,
            self::Rare => 1.5,
            self::Legendary => 3.0,
        };
    }

    /** Doit renvoyer le libellé français : "Commun", "Rare", "Légendaire". */
    public function label(): string
    {
        return match ($this) {
            self::Common => 'Commun',
            self::Rare => 'Rare',
            self::Legendary => 'Légendaire',
        };
    }
}
