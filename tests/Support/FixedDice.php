<?php

declare(strict_types=1);

namespace Tests\Support;

use Dungeon\Dice;

/**
 * Un dé truqué : il ne tire rien au hasard, il déroule une liste de valeurs
 * en boucle. C'est ce qui rend le combat du niveau 5 reproductible.
 */
final class FixedDice extends Dice
{
    private int $index = 0;

    /** @param int[] $values Les valeurs renvoyées, dans l'ordre, en boucle. */
    public function __construct(private readonly array $values, int $sides = 6)
    {
        parent::__construct($sides);
    }

    public function roll(): int
    {
        $value = $this->values[$this->index % count($this->values)];
        $this->index++;

        return $value;
    }
}
