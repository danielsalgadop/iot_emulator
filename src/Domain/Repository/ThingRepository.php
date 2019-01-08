<?php
namespace App\Domain\Repository;
use App\Domain\Entity\Thing;

interface ThingRepository
{
    public function save(Thing $thing);
    public function searchThingByIdOrException(int $id): ?\App\Domain\Entity\Thing;
    public function remove(Thing $thing);
}