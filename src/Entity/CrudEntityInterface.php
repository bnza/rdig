<?php

namespace App\Entity;

interface CrudEntityInterface
{
    public function toArray(bool $ancestors = true, bool $descendants = false);

    public function getId(): int;

}
