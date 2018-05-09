<?php
/**
 * Created by PhpStorm.
 * User: petrux
 * Date: 24/03/18
 * Time: 10.25
 */

namespace App\Entity\Main;

use App\Entity\CrudEntityInterface;


interface SiteRelateEntityInterface extends CrudEntityInterface
{
    public function getSiteId(): int;
}