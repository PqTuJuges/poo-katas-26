<?php

declare(strict_types=1);

use Dungeon\Hero;
use Dungeon\Inventory;
use Tests\Support\SimpleItem;

// Niveau 2 — chapitre 5 : un objet en possède d'autres (Hero → Inventory → Item).
// `Item` devenant abstraite au niveau 3, ces tests passent par SimpleItem,
// une sous-classe concrète définie dans tests/Support/.

test('un objet a un nom et un poids', function (): void {
    $item = new SimpleItem('Épée courte', 2.0);

    expect($item->name)->toBe('Épée courte');
    expect($item->weight)->toBe(2.0);
})->group('niveau-2');

test('un poids négatif est refusé', function (): void {
    expect(fn () => new SimpleItem('Plume', -1.0))->toThrow(InvalidArgumentException::class);
})->group('niveau-2');

test('un sac neuf est vide et porte 20 kg par défaut', function (): void {
    $bag = new Inventory();

    expect($bag->count())->toBe(0);
    expect($bag->totalWeight())->toBe(0.0);
    expect($bag->maxWeight)->toBe(20.0);
})->group('niveau-2');

test('on ajoute un objet dans le sac et on l\'y retrouve', function (): void {
    $bag = new Inventory();

    $bag->add(new SimpleItem('Épée courte', 2.0));

    expect($bag->count())->toBe(1);
    expect($bag->has('Épée courte'))->toBeTrue();
    expect($bag->has('Bouclier'))->toBeFalse();
})->group('niveau-2');

test('le poids total est la somme des poids des objets', function (): void {
    $bag = new Inventory();
    $bag->add(new SimpleItem('Épée courte', 2.0));
    $bag->add(new SimpleItem('Potion', 0.5));

    expect($bag->totalWeight())->toBe(2.5);
})->group('niveau-2');

test('un objet trop lourd n\'entre pas dans le sac', function (): void {
    $bag = new Inventory(5.0);

    // Niveau 2 : add() renvoie false. Niveau 3 : add() lève une exception.
    // Le test accepte les deux, seul compte le fait que le sac reste vide.
    try {
        $result = $bag->add(new SimpleItem('Enclume', 50.0));
        expect($result)->toBeFalse();
    } catch (RuntimeException) {
        // Comportement du niveau 3 : très bien aussi.
    }

    expect($bag->count())->toBe(0);
    expect($bag->totalWeight())->toBe(0.0);
})->group('niveau-2');

test('on retire un objet du sac par son nom', function (): void {
    $bag = new Inventory();
    $bag->add(new SimpleItem('Potion', 0.5));

    $bag->remove('Potion');

    expect($bag->has('Potion'))->toBeFalse();
    expect($bag->count())->toBe(0);
})->group('niveau-2');

test('retirer un objet absent ne casse rien', function (): void {
    $bag = new Inventory();
    $bag->add(new SimpleItem('Potion', 0.5));

    $bag->remove('Dragon en peluche');

    expect($bag->count())->toBe(1);
})->group('niveau-2');

test('le héros possède un inventaire créé dans son constructeur', function (): void {
    $hero = new Hero('Arthur');

    expect($hero->inventory)->toBeInstanceOf(Inventory::class);
    expect($hero->inventory->count())->toBe(0);
})->group('niveau-2');

test('deux héros ont chacun leur propre sac', function (): void {
    $arthur = new Hero('Arthur');
    $morgane = new Hero('Morgane');

    $arthur->inventory->add(new SimpleItem('Épée courte', 2.0));

    expect($arthur->inventory->count())->toBe(1);
    expect($morgane->inventory->count())->toBe(0);
})->group('niveau-2');
