<?php


namespace App\Domain;


class BasicIot
{
    private $brand;
    private $model;

    public function __construct(string $brand, string $model)
    {
        $this->brand = $brand;
        $this->model = $model;
    }
}