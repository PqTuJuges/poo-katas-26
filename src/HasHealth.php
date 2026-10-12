<?php

declare(strict_types=1);

namespace Dungeon;

/**
 * Niveau 4 : déplacez ici les propriétés et méthodes de santé communes à Hero
 * et Monster ($maxHp, $hp avec son hook `set`, $isFullHealth, takeDamage(),
 * heal(), isAlive()), puis remplacez-les par `use HasHealth;` dans les deux classes.
 *
 * Un trait n'est pas un parent : c'est du code copié dans la classe qui l'utilise.
 * `private(set)` et les hooks y fonctionnent comme dans une classe.
 */
trait HasHealth
{
    /** Le maximum de points de vie. Lecture publique, écriture réservée à la classe. */
    public private(set) int $maxHp;

    /** Les points de vie courants, bornés entre 0 et $maxHp grâce au hook `set`. */
    public private(set) int $hp = 0 {
        set => max(0, min($this->maxHp, $value));
    }

    /** Propriété virtuelle : vaut true quand hp est égal à maxHp. */
    public bool $isFullHealth {
        get => $this->hp === $this->maxHp;
    }

    /** Doit retirer $amount points de vie, sans jamais descendre sous 0. */
    public function takeDamage(int $amount): void
    {
        $this->hp -= $amount;
    }

    /** Doit rendre $amount points de vie, sans jamais dépasser $maxHp. */
    public function heal(int $amount): void
    {
        $this->hp += $amount;
    }

    /** Doit renvoyer true tant qu'il reste au moins 1 point de vie. */
    public function isAlive(): bool
    {
        return $this->hp > 0;
    }
}

