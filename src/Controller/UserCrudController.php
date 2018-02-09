<?php
/**
 * Created by PhpStorm.
 * User: petrux
 * Date: 07/02/18
 * Time: 16.30
 */

namespace App\Controller;

use App\Entity\User;


class UserCrudController extends AbstractCrudController
{

    public function getEntityClass($entity = '')
    {
        return User::class;
    }


}