<?php
namespace App\Domain\Repository;
use App\Domain\Entinty\Thing;

interface ThingRepository
{
    public function create(Thing $thing);
}