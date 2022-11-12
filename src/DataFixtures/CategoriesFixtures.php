<?php

namespace App\DataFixtures;

use App\Entity\Auteur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Type;

class CategoriesFixtures extends Fixture
{
    /**
     * Generate data initialization for auteur :
     * [nom, prenom, description]
     * @return \Generator
     */
    private function  auteurDataGenerator()
    {
        yield [
            'Tolkien',
            'J.R.R.',
            'John Ronald Reuel Tolkien, CBE, FRSL (3 janvier 1892 - 2 septembre 1973) est un écrivain britannique, professeur d\'anglais et philologue. Il est surtout connu pour avoir écrit la trilogie Le Seigneur des anneaux, qui a été adaptée au cinéma par Peter Jackson.'
        ];
        yield [
            'Martin',
            'George R.R.',
            'George Raymond Richard Martin, né le 20 septembre 1948 à Bayonne, dans le New Jersey, est un écrivain américain de fantasy et de science-fiction.'
        ];
        yield [
            'Rowling',
            'J.K.',
            'Joanne Rowling, née le 31 juillet 1965 à Yate, est une romancière britannique, auteure de la série de romans Harry Potter.'
        ];
        yield [
            'Gaiman',
            'Neil',
            'Neil Richard MacKinnon Gaiman, né le 10 novembre 1960 à Portchester, Hampshire, est un écrivain britannique de fantasy et de science-fiction.'
        ];
        yield [
            'Pratchett',
            'Terry',
            'Terry Pratchett, né le 28 avril 1948 à Beaconsfield, Buckinghamshire, est un écrivain britannique de fantasy et de science-fiction.'
        ];
        yield [
            'King',
            'Stephen',
            'Stephen Edwin King, né le 21 septembre 1947 à Portland, dans le Maine, est un écrivain américain de fantasy et de science-fiction.'
        ];
        yield [
            'Asimov',
            'Isaac',
            'Isaac Asimov, né Isaak Yudovich Ozimov le 2 janvier 1920 à Petrovichi, en Russie impériale (aujourd’hui en Biélorussie), et mort le 6 avril 1992 à New York, est un écrivain américain de science-fiction.'
        ];
    }

    /**
     * Generate data initialization for type (type of book) :
     * [label, parent]
     * @return \Generator
     */
    private function typeDataGenerator()
    {
        yield [
            'Roman',
            null
        ];
        yield [
            'Roman policier',
            'Roman'
        ];
        yield [
            'Roman d\'amour',
            'Roman'
        ];
        yield [
            'Roman graphique',
            'Roman'
        ];
        yield [
            'Roman d\'aventure',
            'Roman graphique'
        ];
        yield [
            'Roman historique',
            'Roman graphique'
        ];
        yield [
            'Théatre',
            null
        ];
        yield [
            'Comédie',
            'Théatre'
        ];
        yield [
            'Comédie musicale',
            'Comédie'
        ];
        yield [
            'Comédie dramatique',
            'Comédie'
        ];
        yield [
            'Théatre d\'improvisation',
            'Théatre'
        ];
        yield [
            "Poésie",
            null
        ];
        yield [
            "Bande dessinée",
            null
        ];
    }

    public function load(ObjectManager $manager): void
    {
        foreach (self::auteurDataGenerator() as [$nom, $prenom, $bio]) {
            $auteur = new Auteur();
            $auteur->setNom($nom);
            $auteur->setPrenom($prenom);
            $auteur->setDescription($bio);
            $manager->persist($auteur);
        }
        $manager->flush();

        foreach (self::typeDataGenerator() as [$label, $parent_label]) {
            $type = new Type();
            $type->setLabel($label);
            if ($parent_label) {
                $parent = $manager->getRepository(Type::class)->findOneBy(["label" => $parent_label]);
                $type->setParent($parent);
            }
            $manager->persist($type);
            $manager->flush();
        }
    }
}
