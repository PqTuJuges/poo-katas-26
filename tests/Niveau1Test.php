<?php

declare(strict_types=1);

use Dungeon\Dice;
use Dungeon\Hero;

// Niveau 1 — chapitre 1 : classe, objet, constructeur, readonly, private(set), static, __toString.

test('un dé garde le nombre de faces qu\'on lui donne', function (): void {
    expect((new Dice(6))->sides)->toBe(6);
    expect((new Dice(20))->sides)->toBe(20);
})->group('niveau-1');

test('un lancer de dé reste entre 1 et le nombre de faces', function (): void {
    $dice = new Dice(6);

    for ($i = 0; $i < 100; $i++) {
        expect($dice->roll())->toBeGreaterThanOrEqual(1)->toBeLessThanOrEqual(6);
    }
})->group('niveau-1');

test('Dice::d6() et Dice::d20() fabriquent les dés classiques', function (): void {
    expect(Dice::d6())->toBeInstanceOf(Dice::class);
    expect(Dice::d6()->sides)->toBe(6);
    expect(Dice::d20()->sides)->toBe(20);
})->group('niveau-1');

test('un héros démarre avec tous ses points de vie', function (): void {
    $hero = new Hero('Arthur');

    expect($hero->name)->toBe('Arthur');
    expect($hero->maxHp)->toBe(10);
    expect($hero->hp)->toBe(10);
    expect($hero->isAlive())->toBeTrue();
})->group('niveau-1');

test('on peut choisir les points de vie et la force à la création', function (): void {
    $hero = new Hero('Morgane', 20, 5);

    expect($hero->maxHp)->toBe(20);
    expect($hero->hp)->toBe(20);
    expect($hero->strength)->toBe(5);
})->group('niveau-1');

test('takeDamage retire des points de vie', function (): void {
    $hero = new Hero('Arthur');

    $hero->takeDamage(3);

    expect($hero->hp)->toBe(7);
})->group('niveau-1');

test('les points de vie ne descendent jamais sous zéro', function (): void {
    $hero = new Hero('Arthur');

    $hero->takeDamage(999);

    expect($hero->hp)->toBe(0);
    expect($hero->isAlive())->toBeFalse();
})->group('niveau-1');

test('heal ne dépasse jamais le maximum de points de vie', function (): void {
    $hero = new Hero('Arthur');
    $hero->takeDamage(4);

    $hero->heal(100);

    expect($hero->hp)->toBe(10);
})->group('niveau-1');

test('un héros affiché donne "Arthur (7/10 PV)"', function (): void {
    $hero = new Hero('Arthur');
    $hero->takeDamage(3);

    expect((string) $hero)->toBe('Arthur (7/10 PV)');
})->group('niveau-1');

test('le nom du héros est readonly : le réécrire lève une Error', function (): void {
    $hero = new Hero('Arthur');

    expect(function () use ($hero): void {
        $hero->name = 'Mordred';
    })->toThrow(Error::class);
})->group('niveau-1');

test('les points de vie ne s\'écrivent pas de l\'extérieur : private(set) lève une Error', function (): void {
    $hero = new Hero('Arthur');

    expect(function () use ($hero): void {
        $hero->hp = 5;
    })->toThrow(Error::class);
})->group('niveau-1');
