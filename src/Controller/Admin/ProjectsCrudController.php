<?php

namespace App\Controller\Admin;

use App\Entity\Projects;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProjectsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Projects::class;
    }

    
    public function configureFields(string $pageName): iterable
{
    $uploadDir = __DIR__.'/build/images/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $mappingParams = $this->getParameter('vich_uploader.mappings');
    $projetsImagePath = $mappingParams['projects']['uri_prefix'];

    yield TextField::new('title', 'Titre du projet');
    yield TextEditorField::new('description', 'Description du projet');
    yield TextareaField::new('imageFile')->setFormType(VichImageType::class)->hideOnIndex();
    yield ImageField::new('imageName')->setBasePath($projetsImagePath)->hideOnForm();
}
    
}
