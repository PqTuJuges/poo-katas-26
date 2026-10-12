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
    public private(set) int $hp = 0 {
        set => max(0, min($this->maxHp,$value));
    }

    /** Propriété virtuelle : doit valoir true quand hp est égal à maxHp. */
    public bool $isFullHealth {
        get => $this->hp ===$this->maxHp;
    }

    /** Doit garder le nom et initialiser maxHp puis hp à $maxHp. */
    public function __construct(
        public readonly string $name,
        int $maxHp,
    ) {
        $this->maxHp = max(0,$maxHp);
        $this->hp =$this->maxHp;
    }

    /** Doit retirer $amount points de vie, sans jamais descendre sous 0. */
    public function takeDamage(int $amount): void
    {
        if ($amount > 0) {
            $this->hp -=$amount;
        }
    }

    /** Doit rendre $amount points de vie, sans jamais dépasser $maxHp. */
    public function heal(int $amount): void
    {
        if ($amount > 0) {
            $this->hp +=$amount;
        }
    }

    /** Doit renvoyer true tant qu'il reste au moins 1 point de vie. */
    public function isAlive(): bool
    {
        return $this->hp > 0;
    }

    /** Chaque monstre frappe à sa façon : c'est aux sous-classes de l'écrire. */
    abstract public function attack(): int;

    /** Doit renvoyer "Gobelin (5/5 PV)". */
    public function __toString(): string
    {
        return "{$this->name} ({$this->hp}/{$this->maxHp} PV)";
    }
}