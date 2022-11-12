<?php

namespace App\Controller\Admin;

use App\Entity\Vitrine;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class VitrineCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Vitrine::class;
    }

    public function configureFields(string $pageName): iterable
    {

        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('createur'),
            BooleanField::new('published')
                ->onlyOnForms()
                ->hideWhenCreating(),
            TextField::new('description'),

            AssociationField::new('livres')
                ->onlyOnForms()
                ->hideWhenCreating()
                ->setTemplatePath('admin/fields/bibliotheque_livres.html.twig')
                ->setQueryBuilder(
                    function (QueryBuilder $queryBuilder) {
                        // récupération de l'instance courante de Vitrine
                        $currentVitrine = $this->getContext()->getEntity()->getInstance();
                        $createur = $currentVitrine->getCreateur();
                        $memberId = $createur->getId();
                        // charge les seuls [objets] dont le 'owner' de l'[inventaire] est le membre de la galerie
                        $queryBuilder->leftJoin('entity.bibliotheque', 'i')
                            ->leftJoin('i.owner', 'm')
                            ->andWhere('m.id = :member_id')
                            ->setParameter('member_id', $memberId);
                        return $queryBuilder;
                    }
                ),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }
}