<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Bibliotheque;
use App\Entity\Livre;
use App\Entity\Membre;

class AppFixtures extends Fixture
{

    /**
     * Generate data initialization for the livres : 
     * [bibliotheque_name, titre, summary, number_of_page, date_parution]
     * @return \\Generator
     */
    private static function livresDataGenerator()
    {
        yield ["La belle biblio", "Livre 1", "Summary 1", 100, date_create("2020-01-01")];
        yield ["La belle biblio", "Livre 2", "Summary 2", 200, date_create("2020-01-02")];
        yield ["La belle biblio", "Livre 3", "Summary 3", 300, date_create("2020-01-03")];
        yield ["L'endoit des lecteurs", "Livre 4", "Summary 4", 400, date_create("2020-01-04")];
        yield ["L'endoit des lecteurs", "Livre 5", "Summary 5", 500, date_create("2020-01-05")];
        yield ["L'endoit des lecteurs", "Livre 6", "Summary 6", 600, date_create("2020-01-06")];
        yield ["L'endoit des lecteurs", "Livre 7", "Summary 7", 700, date_create("2020-01-07")];
        yield ["La belle biblio", "Livre 8", "Summary 8", 800, date_create("2020-01-08")];
        yield ["La biblio de l'enfer", "Livre 99", "Summary 9", 666, date_create("2020-06-06")];
        yield ["La biblio de l'enfer", "Livre 666", "Summary 10", 1000, date_create("2001-01-01")];
    }

    /**
     * Generate data initialization for bibiotheques :
     * [name, description]
     * @return \\Generator
     */
    private static function bibliothequesDataGenerator()
    {
        yield ["La belle biblio", "Dans cette bibliotheque, vous trouverez des livres avec beaucoup de visuels"];
        yield ["La biblio de l'enfer", "Ici que des livres de merde"];
        yield ["L'endoit des lecteurs", "Place aux livres, mais aussi aux lecteurs"];
    }

    /**
     * Generate data for the memebers :
     * [bibliotheque_name, name, description, birth_date]
     * @return \\Generator
     */
    private static function membresDataGenerator()
    {
        yield ["La belle biblio", "Samuel", "Guillemet", "Bonjour je suis Samuel Guillemet"];
        yield ["La biblio de l'enfer", "Jean", "Dujardin", "Je suis un lecteur"];
        yield ["L'endoit des lecteurs", "Michel", "Dupont", "Je suis un passioné"];
    }

    public function load(ObjectManager $manager): void
    {
        $bibliothequeRepo = $manager->getRepository(Bibliotheque::class);

        foreach (self::bibliothequesDataGenerator() as [$name, $description]) {
            $bibliotheque = new Bibliotheque();
            $bibliotheque->setName($name);
            $bibliotheque->setDescription($description);
            $manager->persist($bibliotheque);
        }
        $manager->flush();

        foreach (self::livresDataGenerator() as [$bibliotheque_name, $titre, $summary, $number_of_page, $date_parution]) {
            $bibliotheque = $bibliothequeRepo->findOneBy(["name" => $bibliotheque_name]);
            $livre = new Livre();
            $livre->setTitre($titre);
            $livre->setSummary($summary);
            $livre->setNumberOfPage($number_of_page);
            $livre->setDateParution($date_parution);
            $bibliotheque->addLivre($livre);
            $manager->persist($bibliotheque);
        }
        $manager->flush();

        foreach (self::membresDataGenerator() as [$bibliotheque_name, $nom, $prenom, $bio]) {
            $bibliotheque = $bibliothequeRepo->findOneBy(["name" => $bibliotheque_name]);
            $membre = new Membre();
            $membre->setNom($nom);
            $membre->setPrenom($prenom);
            $membre->setBio($bio);
            $membre->setBibliothequePerso($bibliotheque);
            $manager->persist($membre);
        }
        $manager->flush();
    }
}