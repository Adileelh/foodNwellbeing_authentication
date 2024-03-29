<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

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
            TextField::new('name'),
            SlugField::new('slug')->setTargetFieldName('name')->hideOnIndex(),
            TextField::new('brand'),
            TextEditorField::new('description'),
            TextEditorField::new('moreInformation')->hideOnIndex(),
            MoneyField::new('price')->setCurrency('EUR'),
            IntegerField::new('quantity'),
            TextField::new('tags'),
            BooleanField::new('isBestSeller', 'Best seller'),
            BooleanField::new('isNewArrival', 'New Arrival'),
            BooleanField::new('isFeatured', 'Featured'),
            BooleanField::new('isSpecialOffer', 'Special Offer'),
            AssociationField::new('category'),
            ImageField::new('image')->setBasePath('/assets/uploads/products/')
                                    ->setUploadDir('public/assets/uploads/products/')
                                    ->setUploadedFileNamePattern('[randomhash].[extension]')
                                    ->setRequired(false),
        ];
    }
    
}
