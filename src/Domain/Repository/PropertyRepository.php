<?php
namespace App\Domain\Repository;

use App\Domain\Entity\Property;

interface PropertyRepository
{
    public function save(Property $property);
}
