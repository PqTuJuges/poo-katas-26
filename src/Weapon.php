<?php

declare(strict_types=1);

namespace Dungeon;

/** Une arme : un objet qui inflige des dégâts. Niveau 3. */
final class Weapon extends Item
{
    /** Doit appeler le constructeur parent avec nom, poids et rareté ; $damage est gardé par la promotion. */
    public function __construct(
        string $name,
        float $weight,
        public readonly int $damage,
        Rarity $rarity = Rarity::Common,
    ) {
        throw new \LogicException('À implémenter');
    }

    /** Doit renvoyer : "Épée courte : arme (2 kg, 5 dégâts)". */
    public function describe(): string
    {
        throw new \LogicException('À implémenter');
    }
}
