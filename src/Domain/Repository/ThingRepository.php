<?php
namespace App\Domain\Repository;
use App\Domain\Thing;

interface ThingRepository
{
    public function create(Thing $thing):void;
}