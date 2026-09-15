<?php

declare(strict_types=1);

namespace Dungeon;

/**
 * Contrat de tout ce qui peut se battre dans le donjon. Niveau 4.
 * Implémenté par Hero et par Monster : rien à écrire ici, une interface n'a pas de code.
 */
interface Fighter
{
    /** Doit renvoyer les dégâts infligés par une attaque. */
    public function attack(): int;

    /** Doit encaisser des dégâts. */
    public function takeDamage(int $amount): void;

    /** Doit dire si le combattant est encore debout. */
    public function isAlive(): bool;
}
