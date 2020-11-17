<?php

namespace App\Controller\Admin;

use App\Entity\Academic;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AcademicCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Academic::class;
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
