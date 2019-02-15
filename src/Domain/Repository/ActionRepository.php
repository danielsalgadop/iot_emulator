<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Action;

interface ActionRepository
{
    public function save(Action $action);
}