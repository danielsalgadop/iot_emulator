<?php
namespace App\Domain\Repository;

use App\Domain\Entity\Property;

interface UserRepository
{
    public function save(Property $property);
}
