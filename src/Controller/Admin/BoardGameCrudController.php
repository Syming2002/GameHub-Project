<?php

namespace App\Controller\Admin;

use App\Entity\BoardGame;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;

class BoardGameCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return BoardGame::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title'),
            TextEditorField::new('description'),
            IntegerField::new('numberPlayer', 'Max number of player'),
            TimeField::new('averageDuration', 'Average Duration')->setFormat("HH:mm"),
            IntegerField::new('minAge', 'Age minimum'),
            IntegerField::new('copyNumber', 'Number of copy of the game'),
            AssociationField::new('category', 'Category')
        ];
    }
    
}
