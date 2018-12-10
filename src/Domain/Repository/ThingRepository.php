<?php
namespace App\Domain\Repository;
use App\Domain\Entity\Thing;

interface ThingRepository
{
    public function create(Thing $thing);
}