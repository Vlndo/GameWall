<?php

namespace App\Controller\Admin;

use App\Entity\Product;

use App\Entity\System;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProductCrudController extends AbstractCrudController
{



    public static function getEntityFqcn(): string
    {
        return Product::class;
    }


    public function configureFields(string $pageName): iterable
    {

        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title'),
            IntegerField::new('quantity'),
            DateTimeField::new('release_date'),
            NumberField::new('price'),
            TextEditorField::new('description'),
            IntegerField::new('rate'),
            TextEditorField::new('productcontent'),
            TextEditorField::new('requiredspecs'),
            TextField::new('edition'),
            AssociationField::new('platforms')->onlyOnForms()
                ->setFormTypeOptions(['by_reference' => false]),
            AssociationField::new('bill')->onlyOnForms()
                ->setFormTypeOptions(['by_reference' => false])
        ];
    }

}
