<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Bibliotheque;
use App\Entity\Livre;


class AppFixtures extends Fixture
{

    /**
     * Generate data initialization for the livres : 
     * [bibliotheque_description, titre, summary, number_of_page, date_parution]
     * @return \\Generator
     */
    private static function livresDataGenerator()
    {
        yield ["Description 1", "Livre 1", "Summary 1", 100, date_create("2020-01-01")];
        yield ["Description 1", "Livre 2", "Summary 2", 200, date_create("2020-01-02")];
        yield ["Description 1", "Livre 3", "Summary 3", 300, date_create("2020-01-03")];
        yield ["Description 2", "Livre 4", "Summary 4", 400, date_create("2020-01-04")];
        yield ["Description 2", "Livre 5", "Summary 5", 500, date_create("2020-01-05")];
        yield ["Description 2", "Livre 6", "Summary 6", 600, date_create("2020-01-06")];
        yield ["Description 2", "Livre 7", "Summary 7", 700, date_create("2020-01-07")];
        yield ["Description 2", "Livre 8", "Summary 8", 800, date_create("2020-01-08")];
        yield ["Description 2", "Livre 9", "Summary 9", 900, date_create("2020-01-09")];
        yield ["Description 3", "Livre 10", "Summary 10", 1000, date_create("2020-01-10")];
    }

    /**
     * Generate data initialization for bibiotheques :
     * [description]
     * @return \\Generator
     */
    private static function bibliothequesDataGenerator()
    {
        yield ["Description 1"];
        yield ["Description 2"];
        yield ["Description 3"];
    }

    public function load(ObjectManager $manager): void
    {
        $bibliothequeRepo = $manager->getRepository(Bibliotheque::class);

        foreach (self::bibliothequesDataGenerator() as [$description]) {
            $bibliotheque = new Bibliotheque();
            $bibliotheque->setDescription($description);
            $manager->persist($bibliotheque);
        }
        $manager->flush();

        foreach (self::livresDataGenerator() as [$bibliotheque_description, $titre, $summary, $number_of_page, $date_parution]) {
            $bibliotheque = $bibliothequeRepo->findOneBy(["description" => $bibliotheque_description]);
            $livre = new Livre();
            $livre->setTitre($titre);
            $livre->setSummary($summary);
            $livre->setNumberOfPage($number_of_page);
            $livre->setDateParution($date_parution);
            $bibliotheque->addLivre($livre);
            $manager->persist($bibliotheque);
        }
        $manager->flush();
    }
}