<?php

declare(strict_types=1);

namespace Dungeon;

/**
 * Un duel tour par tour entre deux Fighter. Bonus niveau 5.
 * Le dé est reçu en paramètre au lieu d'être fabriqué ici : c'est ce qui rend
 * le combat testable (on peut lui donner un dé truqué).
 */
final class Battle
{
    public function __construct(
        private readonly Fighter $a,
        private readonly Fighter $b,
        private readonly Dice $dice,
    ) {
    }

    /**
     * Doit dérouler le combat et renvoyer le vainqueur.
     * Règle : $a frappe en premier, les dégâts valent attack() + un lancer de dé ;
     * on s'arrête dès qu'un des deux n'est plus en vie.
     */
    public function fight(): Fighter
    {
        $attacker = $this->a;
        $defender = $this->b;

        while ($this->a->isAlive() && $this->b->isAlive()) {
            // Les dégâts = attack() + un lancer de dé ($this->dice->roll())
            $damage = $attacker->attack() + $this->dice->roll();
            $defender->takeDamage($damage);

            // Si le défenseur est mort après ce coup, le combat s'arrête immédiatement
            if (!$defender->isAlive()) {
                break;
            }

            // On échange les rôles pour le tour suivant
            $temp = $attacker;
            $attacker = $defender;
            $defender = $temp;
        }

        // Renvoie celui qui est encore en vie
        return $this->a->isAlive() ? $this->a : $this->b;
    }
}
