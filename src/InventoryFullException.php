<?php

declare(strict_types=1);

namespace Dungeon;

/**
 * Levée par Inventory::add() quand l'objet ne rentre plus dans le sac. Niveau 3.
 * Rien à écrire : tout est hérité de RuntimeException. C'est le nom qui compte.
 */
final class InventoryFullException extends \RuntimeException
{
}
