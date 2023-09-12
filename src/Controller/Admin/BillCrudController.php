<?php

namespace App\Controller\Admin;

use App\Entity\Bill;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;

class BillCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Bill::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            IntegerField::new('billNumber'),
            AssociationField::new('user')
                ->setFormTypeOptions(['by_reference' => true]),
            AssociationField::new('keeys')->hideOnForm(),
        ];
    }

}