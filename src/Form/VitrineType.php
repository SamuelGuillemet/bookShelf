<?php

namespace App\Form;

use App\Entity\Vitrine;
use App\Repository\LivreRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VitrineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        //dump($options);

        $inventaire = $options['data'] ?? null;
        $membre = $inventaire ? $inventaire->getCreateur() : null;

        $builder
            ->add('description')
            ->add('published')
            ->add('createur', null, [
                'disabled' => true,
            ])
            ->add('livres', null, [
                'query_builder' => function (LivreRepository $er) use ($membre) {
                    return $er->createQueryBuilder('l')
                        ->leftJoin('l.bibliotheque', 'b')
                        ->andWhere('b.membre = :membre')
                        ->setParameter('membre', $membre);
                },
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vitrine::class,
        ]);
    }
}