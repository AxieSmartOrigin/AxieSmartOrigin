<?php

namespace App\Controller\Admin;

use App\Entity\Tag;
use App\Entity\Card;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CardCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Card::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            AssociationField::new('class'),
            AssociationField::new('part'),
            AssociationField::new('tag')->formatValue(function ($value, $entity) {
                return implode(",",$entity->getTag()->toArray());
            }),
            ImageField::new('image')
                ->setBasePath('build/images/cards-upload')
                ->setUploadDir('assets/images/cards-upload')
                ->setUploadedFileNamePattern('[randomhash].[extension]'),
            IntegerField::new('cost'),
            IntegerField::new('damage'),
            IntegerField::new('shield'),
            IntegerField::new('heal'),
            TextareaField::new('description'),

        ];
    }
    
}
