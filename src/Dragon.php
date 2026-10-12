<?php

declare(strict_types=1);

namespace Dungeon;

/** Le gros morceau : 30 PV. Niveau 3. */
final class Dragon extends Monster
{
    /** Doit appeler le constructeur parent avec le nom "Dragon" et 30 points de vie. */
    public function __construct()
    {
        parent::__construct('Dragon', 30);
    }

    /** Doit renvoyer 8 (valeur fixe, pour que les tests restent prévisibles). */
    public function attack(): int
    {
        return 8;
    }
}
