<?php

namespace App\Controller\Admin;

use App\Entity\AxieClass;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AxieClassCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return AxieClass::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('name'),
        ];
    }
    
}
