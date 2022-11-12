<?php

namespace App\DataFixtures;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Bibliotheque;
use App\Entity\Livre;
use App\Entity\Membre;
use App\Entity\Type;
use App\Entity\User;
use App\Entity\Vitrine;

class VitrinesFixtures extends Fixture implements DependentFixtureInterface
{


    /**
     * Generate data initialization for the vitrines : 
     * [description, published, createur, livres]
     * @return \\Generator
     */
    private function vitrinesDataGenerator()
    {
        yield [
            'Description de la vitrine 1',
            true,
            'Guillemet',
            ['Livre 1', 'Livre 2', 'Livre 8']
        ];
        yield [
            'Description de la vitrine 2',
            false,
            'Guillemet',
            ['Livre 3']
        ];
        yield [
            'Description de la vitrine 3',
            true,
            'Dupont',
            ['Livre 5', 'Livre 6']
        ];
        yield [
            'Description de la vitrine 4',
            false,
            'Dupont',
            ['Livre 4', 'Livre 6', 'Livre 7']
        ];
        yield [
            'Description de la vitrine 5',
            true,
            'Dujardin',
            ['Livre 99', 'Livre 666']
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $membreRepo = $manager->getRepository(Membre::class);
        $livreRepo = $manager->getRepository(Livre::class);
        foreach ($this->vitrinesDataGenerator() as [$description, $published, $createur, $livres]) {
            $vitrine = new Vitrine();
            $vitrine->setDescription($description);
            $vitrine->setPublished($published);
            $vitrine->setCreateur($membreRepo->findOneBy(['nom' => $createur]));
            foreach ($livres as $livre) {
                $vitrine->addLivre($livreRepo->findOneBy(['titre' => $livre]));
            }
            $manager->persist($vitrine);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            AppFixtures::class,
        ];
    }
}