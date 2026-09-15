<?php

declare(strict_types=1);

namespace Tests\Support;

use Dungeon\Item;

/**
 * Un objet concret minimal, utilisé UNIQUEMENT par les tests du niveau 2.
 *
 * Pourquoi : au niveau 3, `Item` devient abstraite — on ne peut plus faire
 * `new Item(...)`. Pour que les tests du niveau 2 restent valables jusqu'au bout
 * du parcours, ils passent par cette petite sous-classe de test.
 */
final class SimpleItem extends Item
{
    public function describe(): string
    {
        return $this->name.' : objet ('.$this->weight.' kg)';
    }
}
