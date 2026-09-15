<?php

declare(strict_types=1);

namespace Dungeon;

/** Le petit monstre de base : 5 PV. Niveau 3. */
final class Goblin extends Monster
{
    /** Doit appeler le constructeur parent avec le nom "Gobelin" et 5 points de vie. */
    public function __construct()
    {
        throw new \LogicException('À implémenter');
    }

    /** Doit renvoyer 2 (valeur fixe, pour que les tests restent prévisibles). */
    public function attack(): int
    {
        throw new \LogicException('À implémenter');
    }
}
