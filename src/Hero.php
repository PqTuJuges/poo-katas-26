<?php

declare(strict_types=1);

namespace Dungeon;

/**
 * Le personnage joueur. Niveau 1, complété au chapitre Encapsulation puis aux niveaux 2, 3 et 4.
 * Fighter (niveau 4) : le contrat commun avec les monstres.
 *
 * Pas de getter ici : les propriétés se lisent directement ($hero->hp). Ce qui
 * empêche l'extérieur de les écrire, c'est `private(set)` (ou `readonly`).
 */
final class Hero implements Fighter
{
    use HasHealth;

    /** Le sac, créé dans le constructeur : composition. Jamais remplacé, donc readonly. Niveau 2. */
    public readonly Inventory $inventory;

    /** L'arme équipée, ou null si le héros se bat à mains nues. Écrite par equip() seulement. Niveau 3. */
    public private(set) ?Weapon $weapon = null;

    /**
     * Doit initialiser maxHp et hp, et créer l'inventaire du héros (niveau 2).
     * Chapitre Encapsulation : doit d'abord refuser un nom vide
     * (InvalidArgumentException('Un héros a un nom.')) et un maxHp inférieur à 1
     * (InvalidArgumentException("maxHp doit valoir au moins 1, $maxHp reçu.")).
     */
    public function __construct(
        public readonly string $name,
        int $maxHp = 10,
        public readonly int $strength = 2,
    ) {
        if (trim($name) === '') {
            throw new \InvalidArgumentException('Un héros a un nom.');
        }

        if ($maxHp < 1) {
            throw new \InvalidArgumentException("maxHp doit valoir au moins 1, $maxHp reçu.");
        }

        $this->maxHp =$maxHp;
        $this->hp =$maxHp;
        $this->inventory = new Inventory();
    }

    /** Doit équiper l'arme passée en paramètre (elle remplace la précédente). Niveau 3. */
    public function equip(Weapon $weapon): void
    {
        $this->weapon =$weapon;
    }

    /** Doit soigner le héros du montant de la potion, puis retirer la potion de l'inventaire. Niveau 3. */
    public function drink(Potion $potion): void
    {
        $this->heal($potion->healing);
        $this->inventory->remove($potion->name);
    }

    /** Doit renvoyer strength, plus les dégâts de l'arme équipée s'il y en a une. */
    public function attack(): int
    {
        $weaponDamage =$this->weapon?->damage ?? 0;
        return $this->strength +$weaponDamage;
    }

    /** Doit renvoyer "Arthur (7/10 PV)". */
    public function __toString(): string
    {
        return sprintf('%s (%d/%d PV)', $this->name, $this->hp,$this->maxHp);
    }
}