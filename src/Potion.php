<?php

declare(strict_types=1);

namespace Dungeon;

/** Une potion : un objet qui rend des points de vie. Niveau 3. */
final class Potion extends Item
{
    /** Doit appeler le constructeur parent avec nom, poids et rareté ; $healing est gardé par la promotion. */
    public function __construct(
        string $name,
        float $weight,
        public readonly int $healing,
        Rarity $rarity = Rarity::Common,
    ) {
        parent::__construct($name, $weight, $rarity);
    }

    /** Doit renvoyer : "Potion de soin : potion (0.5 kg, +5 PV)". */
    public function describe(): string
    {
        return "{$this->name} : potion ({$this->weight} kg, +{$this->healing} PV)";
    }
}
