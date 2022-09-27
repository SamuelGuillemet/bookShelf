<?php

namespace App\Controller\Admin;

use App\Entity\Bibliotheque;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class BibliothequeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Bibliotheque::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('membre'),
            TextField::new('name'),
            TextEditorField::new('description'),
            CollectionField::new('Livres'),
        ];
    }
}