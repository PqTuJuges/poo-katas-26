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
        parent::__construct($name,$weight,$rarity);
    }

    /** Doit renvoyer : "Épée courte : arme (2 kg, 5 dégâts)". */
    public function describe(): string
    {
        return "{$this->name} : arme ({$this->weight} kg, {$this->damage} dégâts)";
    }
}
