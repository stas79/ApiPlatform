<?php

namespace App\Controller\Admin;

use App\Entity\Tables;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TablesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Tables::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
//            IdField::new('id'),
            IntegerField::new('num', 'Номер стола'),
            TextField::new('description', 'Описание'),
            IntegerField::new('maxGuests', 'Макс. кол-во гостей'),
            IntegerField::new('guestsDef', 'Кол-во гостей по умолчанию'),
            IntegerField::new('guestsNow', 'Кол-во гостей сейчас'),
        ];
    }

}
