<?php

declare(strict_types=1);

namespace Dungeon;

/**
 * Un monstre du donjon. Classe ABSTRAITE : on ne croise jamais "un monstre",
 * on croise un gobelin ou un dragon. Niveau 3, devient Fighter au niveau 4.
 */
abstract class Monster implements Fighter
{
    /** Le maximum de points de vie. Lecture publique, écriture réservée à la classe. */
    public private(set) int $maxHp = 0;

    /** Les points de vie courants. Doit porter le même hook `set` que dans Hero : borné entre 0 et $maxHp. */
    public private(set) int $hp = 0;

    /** Propriété virtuelle : doit valoir true quand hp est égal à maxHp. */
    public bool $isFullHealth {
        get => throw new \LogicException('À implémenter');
    }

    /** Doit garder le nom et initialiser maxHp puis hp à $maxHp. */
    public function __construct(
        public readonly string $name,
        int $maxHp,
    ) {
        throw new \LogicException('À implémenter');
    }

    /** Doit retirer $amount points de vie, sans jamais descendre sous 0. */
    public function takeDamage(int $amount): void
    {
        throw new \LogicException('À implémenter');
    }

    /** Doit rendre $amount points de vie, sans jamais dépasser $maxHp. */
    public function heal(int $amount): void
    {
        throw new \LogicException('À implémenter');
    }

    /** Doit renvoyer true tant qu'il reste au moins 1 point de vie. */
    public function isAlive(): bool
    {
        throw new \LogicException('À implémenter');
    }

    /** Chaque monstre frappe à sa façon : c'est aux sous-classes de l'écrire. */
    abstract public function attack(): int;

    /** Doit renvoyer "Gobelin (5/5 PV)". */
    public function __toString(): string
    {
        throw new \LogicException('À implémenter');
    }
}
