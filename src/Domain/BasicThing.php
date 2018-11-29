<?php


namespace App\Domain;


class BasicThing
{
    private $brand;
    private $model;

    public function __construct(string $brand, string $model)
    {
        $this->brand = $brand;
        $this->model = $model;
    }
}