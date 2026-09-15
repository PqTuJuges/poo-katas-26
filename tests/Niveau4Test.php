<?php

declare(strict_types=1);

use Dungeon\Dragon;
use Dungeon\Fighter;
use Dungeon\Goblin;
use Dungeon\HasHealth;
use Dungeon\Hero;
use Dungeon\Inventory;
use Dungeon\Item;
use Dungeon\Monster;
use Dungeon\Potion;
use Dungeon\Rarity;
use Dungeon\Weapon;

// Niveau 4 — chapitre 7 : enum, interface, trait, interfaces natives de PHP.

test('l\'enum Rarity a ses trois cas', function (): void {
    expect(Rarity::cases())->toHaveCount(3);
    expect(Rarity::Common->value)->toBe('common');
    expect(Rarity::from('rare'))->toBe(Rarity::Rare);
    expect(Rarity::tryFrom('inconnu'))->toBeNull();
})->group('niveau-4');

test('chaque rareté a son multiplicateur et son libellé', function (): void {
    expect(Rarity::Common->multiplier())->toBe(1.0);
    expect(Rarity::Rare->multiplier())->toBe(1.5);
    expect(Rarity::Legendary->multiplier())->toBe(3.0);

    expect(Rarity::Common->label())->toBe('Commun');
    expect(Rarity::Rare->label())->toBe('Rare');
    expect(Rarity::Legendary->label())->toBe('Légendaire');
})->group('niveau-4');

test('un objet est commun par défaut', function (): void {
    expect((new Weapon('Épée courte', 2.0, 5))->rarity)->toBe(Rarity::Common);
})->group('niveau-4');

test('la valeur d\'un objet vaut son poids fois le multiplicateur de rareté', function (): void {
    expect((new Weapon('Épée courte', 2.0, 5))->value())->toBe(2.0);
    expect((new Weapon('Lame elfique', 2.0, 8, Rarity::Rare))->value())->toBe(3.0);
    expect((new Potion('Élixir', 1.0, 20, Rarity::Legendary))->value())->toBe(3.0);
})->group('niveau-4');

test('Item respecte le contrat Stringable', function (): void {
    $sword = new Weapon('Épée courte', 2.0, 5);

    expect($sword)->toBeInstanceOf(Stringable::class);
    expect((string) $sword)->toBe($sword->describe());
})->group('niveau-4');

test('Hero et Monster respectent tous les deux le contrat Fighter', function (): void {
    expect(new Hero('Arthur'))->toBeInstanceOf(Fighter::class);
    expect(new Goblin())->toBeInstanceOf(Fighter::class);
    expect(is_subclass_of(Monster::class, Fighter::class))->toBeTrue();
})->group('niveau-4');

test('on fait frapper n\'importe quel Fighter sans savoir ce que c\'est', function (): void {
    /** @var Fighter[] $fighters */
    $fighters = [new Hero('Arthur', 10, 2), new Goblin(), new Dragon()];

    $total = 0;
    foreach ($fighters as $fighter) {
        $total += $fighter->attack();
    }

    expect($total)->toBe(12);
})->group('niveau-4');

test('Hero et Monster partagent le trait HasHealth', function (): void {
    expect(class_uses(Hero::class))->toContain(HasHealth::class);
    expect(class_uses(Monster::class))->toContain(HasHealth::class);
})->group('niveau-4');

test('le trait donne exactement le même comportement aux deux classes', function (): void {
    $hero = new Hero('Arthur', 10);
    $goblin = new Goblin();

    $hero->takeDamage(100);
    $goblin->takeDamage(100);

    expect($hero->hp)->toBe(0);
    expect($goblin->hp)->toBe(0);
    expect($hero->isAlive())->toBeFalse();
    expect($goblin->isAlive())->toBeFalse();
})->group('niveau-4');

test('on compte l\'inventaire avec count()', function (): void {
    $bag = new Inventory();
    $bag->add(new Weapon('Épée courte', 2.0, 5));
    $bag->add(new Potion('Potion de soin', 0.5, 5));

    expect($bag)->toBeInstanceOf(Countable::class);
    expect(count($bag))->toBe(2);
})->group('niveau-4');

test('on parcourt l\'inventaire avec foreach', function (): void {
    $bag = new Inventory();
    $bag->add(new Weapon('Épée courte', 2.0, 5));
    $bag->add(new Potion('Potion de soin', 0.5, 5));

    expect($bag)->toBeInstanceOf(IteratorAggregate::class);

    $names = [];
    foreach ($bag as $item) {
        expect($item)->toBeInstanceOf(Item::class);
        $names[] = $item->name;
    }

    expect($names)->toBe(['Épée courte', 'Potion de soin']);
})->group('niveau-4');
