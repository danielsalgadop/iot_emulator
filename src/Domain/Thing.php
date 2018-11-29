<?php


namespace App\Domain;
use App\Domain\BasicThing;

class Thing extends BasicThing
{
    public function something(){
        print "something called";
    }
}