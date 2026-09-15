<?php

declare(strict_types=1);

use Dungeon\Dice;
use Dungeon\Hero;

// Encapsulation — chapitre 3 : un objet garantit lui-même ses invariants.
// Validation dans le constructeur, hook `set` qui borne hp, propriété
// virtuelle isFullHealth (hook `get`), private(set) sur ce que seule la classe écrit.

test('un dé refuse moins de 2 faces', function (): void {
    expect(fn () => new Dice(1))->toThrow(InvalidArgumentException::class);
    expect(fn () => new Dice(0))->toThrow(InvalidArgumentException::class);
})->group('encapsulation');

test('un dé à 2 faces est le plus petit dé accepté', function (): void {
    expect((new Dice(2))->sides)->toBe(2);
})->group('encapsulation');

test('un héros sans nom est refusé', function (): void {
    expect(fn () => new Hero('  '))->toThrow(InvalidArgumentException::class);
})->group('encapsulation');

test('un héros avec 0 point de vie maximum est refusé', function (): void {
    expect(fn () => new Hero('Arthur', 0))->toThrow(InvalidArgumentException::class);
})->group('encapsulation');

test('le maximum de points de vie ne s\'écrit pas de l\'extérieur', function (): void {
    $hero = new Hero('Arthur');

    expect(function () use ($hero): void {
        $hero->maxHp = 99;
    })->toThrow(Error::class);
})->group('encapsulation');

test('isFullHealth suit les points de vie sans rien stocker', function (): void {
    $hero = new Hero('Arthur');
    expect($hero->isFullHealth)->toBeTrue();

    $hero->takeDamage(1);
    expect($hero->isFullHealth)->toBeFalse();

    $hero->heal(100);
    expect($hero->isFullHealth)->toBeTrue();
})->group('encapsulation');

test('isFullHealth est une propriété virtuelle : on ne peut pas l\'écrire', function (): void {
    $hero = new Hero('Arthur');

    expect(function () use ($hero): void {
        $hero->isFullHealth = true;
    })->toThrow(Error::class);
})->group('encapsulation');
