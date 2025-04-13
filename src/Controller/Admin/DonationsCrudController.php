<?php

namespace App\Controller\Admin;

use App\Entity\Donations;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;


class DonationsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Donations::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        yield MoneyField::new('sum', 'Montant du don')->setCurrency('EUR');
        yield TextEditorField::new('message', 'Message');
        yield DateTimeField::new('date', 'Date du don');
        yield AssociationField::new('projects', 'Projet');
        yield AssociationField::new('user', 'Donateur');  
    }
    
}
