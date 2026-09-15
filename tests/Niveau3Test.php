<?php

declare(strict_types=1);

use Dungeon\Dragon;
use Dungeon\Goblin;
use Dungeon\Hero;
use Dungeon\Inventory;
use Dungeon\InventoryFullException;
use Dungeon\Item;
use Dungeon\Monster;
use Dungeon\Potion;
use Dungeon\Weapon;

// Niveau 3 — chapitre 6 : héritage, classes abstraites, polymorphisme, exceptions.

test('Item est une classe abstraite : on ne peut pas l\'instancier', function (): void {
    expect((new ReflectionClass(Item::class))->isAbstract())->toBeTrue();
})->group('niveau-3');

test('une arme est un Item avec des dégâts', function (): void {
    $sword = new Weapon('Épée courte', 2.0, 5);

    expect($sword)->toBeInstanceOf(Item::class);
    expect($sword->name)->toBe('Épée courte');
    expect($sword->weight)->toBe(2.0);
    expect($sword->damage)->toBe(5);
})->group('niveau-3');

test('une potion est un Item qui soigne', function (): void {
    $potion = new Potion('Potion de soin', 0.5, 5);

    expect($potion)->toBeInstanceOf(Item::class);
    expect($potion->healing)->toBe(5);
})->group('niveau-3');

test('chaque type d\'objet se décrit à sa façon (polymorphisme)', function (): void {
    expect((new Weapon('Épée courte', 2.0, 5))->describe())
        ->toBe('Épée courte : arme (2 kg, 5 dégâts)');
    expect((new Potion('Potion de soin', 0.5, 5))->describe())
        ->toBe('Potion de soin : potion (0.5 kg, +5 PV)');
})->group('niveau-3');

test('Monster est abstraite et Goblin comme Dragon en héritent', function (): void {
    expect((new ReflectionClass(Monster::class))->isAbstract())->toBeTrue();
    expect(new Goblin())->toBeInstanceOf(Monster::class);
    expect(new Dragon())->toBeInstanceOf(Monster::class);
})->group('niveau-3');

test('le gobelin et le dragon ne frappent pas pareil', function (): void {
    expect((new Goblin())->attack())->toBe(2);
    expect((new Dragon())->attack())->toBe(8);
})->group('niveau-3');

test('un monstre a un nom et des points de vie', function (): void {
    $goblin = new Goblin();

    expect($goblin->name)->toBe('Gobelin');
    expect($goblin->hp)->toBe(5);
    expect($goblin->maxHp)->toBe(5);
    expect((string) $goblin)->toBe('Gobelin (5/5 PV)');

    $dragon = new Dragon();
    expect($dragon->name)->toBe('Dragon');
    expect($dragon->hp)->toBe(30);
})->group('niveau-3');

test('on parcourt une liste de monstres sans un seul if', function (): void {
    $monsters = [new Goblin(), new Dragon(), new Goblin()];

    $total = 0;
    foreach ($monsters as $monster) {
        $total += $monster->attack();
    }

    expect($total)->toBe(12);
})->group('niveau-3');

test('un monstre encaisse des dégâts et finit par mourir', function (): void {
    $goblin = new Goblin();

    $goblin->takeDamage(3);
    expect($goblin->hp)->toBe(2);
    expect($goblin->isAlive())->toBeTrue();

    $goblin->takeDamage(99);
    expect($goblin->hp)->toBe(0);
    expect($goblin->isAlive())->toBeFalse();
})->group('niveau-3');

test('un sac trop chargé lève une InventoryFullException', function (): void {
    $bag = new Inventory(5.0);

    expect(fn () => $bag->add(new Weapon('Enclume', 50.0, 1)))
        ->toThrow(InventoryFullException::class);
    expect($bag->count())->toBe(0);
})->group('niveau-3');

test('InventoryFullException est une RuntimeException', function (): void {
    expect(new InventoryFullException('test'))->toBeInstanceOf(RuntimeException::class);
})->group('niveau-3');

test('le héros équipe une arme et frappe plus fort', function (): void {
    $hero = new Hero('Arthur', 10, 2);

    expect($hero->attack())->toBe(2);
    expect($hero->weapon)->toBeNull();

    $hero->equip(new Weapon('Épée courte', 2.0, 5));

    expect($hero->weapon)->toBeInstanceOf(Weapon::class);
    expect($hero->attack())->toBe(7);
})->group('niveau-3');

test('boire une potion soigne le héros et retire la potion du sac', function (): void {
    $hero = new Hero('Arthur');
    $potion = new Potion('Potion de soin', 0.5, 5);
    $hero->inventory->add($potion);
    $hero->takeDamage(6);

    $hero->drink($potion);

    expect($hero->hp)->toBe(9);
    expect($hero->inventory->has('Potion de soin'))->toBeFalse();
})->group('niveau-3');
