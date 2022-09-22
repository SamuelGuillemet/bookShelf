<?php

namespace App\Controller\Admin;

use App\Entity\Bibliotheque;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class BibliothequeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Bibliotheque::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
