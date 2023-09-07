<?php

namespace App\Controller\Admin;

use App\Entity\Paiment;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PaimentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Paiment::class;
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
