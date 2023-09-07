<?php

namespace App\Controller\Admin;

use App\Entity\System;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class SystemCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return System::class;
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
