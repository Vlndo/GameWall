<?php

namespace App\Controller\Admin;

use App\Entity\Key;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class KeyCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Key::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('keyNumber'),
            AssociationField::new('keyProduct')
                ->setFormTypeOptions(['by_reference' => true]),
            AssociationField::new('billKey')
                ->setFormTypeOptions(['by_reference' => true]),
        ];
    }
}