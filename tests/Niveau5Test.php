<?php

declare(strict_types=1);

use Dungeon\Battle;
use Dungeon\Dragon;
use Dungeon\Goblin;
use Dungeon\Hero;
use Dungeon\Weapon;
use Tests\Support\FixedDice;

// Bonus niveau 5 — chapitre 7 : le combat. Le dé est donné au Battle au lieu
// d'être fabriqué dedans : c'est ce qui rend le résultat reproductible dans un test.

test('le dé truqué déroule toujours la même série', function (): void {
    $dice = new FixedDice([1, 3]);

    expect($dice->roll())->toBe(1);
    expect($dice->roll())->toBe(3);
    expect($dice->roll())->toBe(1);
})->group('niveau-5');

test('un héros solide vient à bout d\'un gobelin', function (): void {
    $hero = new Hero('Arthur', 20, 3);
    $goblin = new Goblin();

    $winner = (new Battle($hero, $goblin, new FixedDice([1])))->fight();

    expect($winner)->toBe($hero);
    expect($goblin->isAlive())->toBeFalse();
    expect($hero->hp)->toBe(17);
})->group('niveau-5');

test('un héros trop faible perd contre le dragon', function (): void {
    $hero = new Hero('Arthur', 10, 1);
    $dragon = new Dragon();

    $winner = (new Battle($hero, $dragon, new FixedDice([1])))->fight();

    expect($winner)->toBe($dragon);
    expect($hero->isAlive())->toBeFalse();
})->group('niveau-5');

test('avec une bonne arme, le même héros gagne', function (): void {
    $hero = new Hero('Arthur', 10, 1);
    $hero->equip(new Weapon('Lame du dragon', 3.0, 20));

    $winner = (new Battle($hero, new Dragon(), new FixedDice([1])))->fight();

    expect($winner)->toBe($hero);
})->group('niveau-5');
