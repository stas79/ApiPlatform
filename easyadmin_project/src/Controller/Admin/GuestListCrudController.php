<?php

namespace App\Controller\Admin;

use App\Entity\GuestList;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use App\Controller\Admin\TablesCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;

class GuestListCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return GuestList::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
//            IdField::new('id', 'ID'),
            TextField::new('name', 'Имя гостя'),
            BooleanField::new('isPresent', 'Присутствует'),
            AssociationField::new('table_id', 'Столы'),
        ];
    }

}
