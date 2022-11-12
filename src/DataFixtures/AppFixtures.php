<?php

namespace App\DataFixtures;

use App\Entity\Auteur;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Bibliotheque;
use App\Entity\Livre;
use App\Entity\Membre;
use App\Entity\Type;
use App\Entity\User;

class AppFixtures extends Fixture implements DependentFixtureInterface
{


    /**
     * Generate data initialization for the livres : 
     * [bibliotheque_name, titre, summary, number_of_page, date_parution, auteur_nom, auteur_prenom, type_label]
     * @return \\Generator
     */
    private static function livresDataGenerator()
    {
        yield ["La belle biblio", "Livre 1", "Summary 1", 100, date_create("2020-01-01"), "Tolkien", "J.R.R.", "Roman"];
        yield ["La belle biblio", "Livre 2", "Summary 2", 200, date_create("2020-01-02"), "Martin", "George R.R.", "Roman"];
        yield ["La belle biblio", "Livre 3", "Summary 3", 300, date_create("2020-01-03"), "Rowling", "J.K.", "Roman policier"];
        yield ["L'endoit des lecteurs", "Livre 4", "Summary 4", 400, date_create("2020-01-04"), "Gaiman", "Neil", "Roman historique"];
        yield ["L'endoit des lecteurs", "Livre 5", "Summary 5", 500, date_create("2020-01-05"), "Pratchett", "Terry", "Bande dessinée"];
        yield ["L'endoit des lecteurs", "Livre 6", "Summary 6", 600, date_create("2020-01-06"), "King", "Stephen", "Roman d'aventure"];
        yield ["L'endoit des lecteurs", "Livre 7", "Summary 7", 700, date_create("2020-01-07"), "Asimov", "Isaac", "Théatre d'improvisation"];
        yield ["La belle biblio", "Livre 8", "Summary 8", 800, date_create("2020-01-08"), "Tolkien", "J.R.R.", "Poésie"];
        yield ["La biblio de l'enfer", "Livre 99", "Summary 9", 666, date_create("2020-06-06"), "Asimov", "Isaac", "Comédie"];
        yield ["La biblio de l'enfer", "Livre 666", "Summary 10", 1000, date_create("2001-01-01"), "King", "Stephen", "Comédie musicale"];
    }

    /**
     * Generate data initialization for bibiotheques :
     * [name, description]
     * @return \\Generator
     */
    private static function bibliothequesDataGenerator()
    {
        yield ["La belle biblio", "Dans cette bibliotheque, vous trouverez des livres avec beaucoup de visuels", "Guillemet"];
        yield ["La biblio de l'enfer", "Ici que des livres de merde", "Dujardin"];
        yield ["L'endoit des lecteurs", "Place aux livres, mais aussi aux lecteurs", "Dupont"];
    }

    /**
     * Generate data for the memebers :
     * [bibliotheque_name, prenom, nom, description, email]
     * @return \\Generator
     */
    private static function membresDataGenerator()
    {
        yield ["Samuel", "Guillemet", "Bonjour je suis Samuel Guillemet", "sam@localhost"];
        yield ["Jean", "Dujardin", "Je suis un lecteur", null];
        yield ["Michel", "Dupont", "Je suis un passioné", null];
    }

    public function load(ObjectManager $manager): void
    {
        $bibliothequeRepo = $manager->getRepository(Bibliotheque::class);
        $membreRepo = $manager->getRepository(Membre::class);

        foreach (self::membresDataGenerator() as [$prenom, $nom, $bio, $useremail]) {
            $membre = new Membre();
            if ($useremail) {
                $user = $manager->getRepository(User::class)->findOneByEmail($useremail);
                $membre->setUser($user);
            }
            $membre->setNom($nom);
            $membre->setPrenom($prenom);
            $membre->setBio($bio);
            $manager->persist($membre);
        }
        $manager->flush();

        foreach (self::bibliothequesDataGenerator() as [$name, $description, $membre_nom]) {
            $membre = $membreRepo->findOneBy(["nom" => $membre_nom]);
            $bibliotheque = new Bibliotheque();
            $bibliotheque->setName($name);
            $bibliotheque->setDescription($description);
            $bibliotheque->setMembre($membre);
            $manager->persist($bibliotheque);
        }
        $manager->flush();

        foreach (self::livresDataGenerator() as [$bibliotheque_name, $titre, $summary, $number_of_page, $date_parution, $auteur_nom, $auteur_prenom, $type_label]) {
            $bibliotheque = $bibliothequeRepo->findOneBy(["name" => $bibliotheque_name]);
            $auteur = $manager->getRepository(Auteur::class)->findOneBy(["nom" => $auteur_nom, "prenom" => $auteur_prenom]);
            $type = $manager->getRepository(Type::class)->findOneBy(["label" => $type_label]);
            $livre = new Livre();
            $livre->setTitre($titre);
            $livre->setSummary($summary);
            $livre->setNumberOfPage($number_of_page);
            $livre->setDateParution($date_parution);
            $bibliotheque->addLivre($livre);
            $livre->setAuteur($auteur);
            $livre->addType($type);
            $manager->persist($bibliotheque);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            CategoriesFixtures::class,
        ];
    }
}