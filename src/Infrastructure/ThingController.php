<?php


namespace App\Infrastructure;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
//use Symfony\Component\Routing\Annotation\Route;

class ThingController extends AbstractController
{

    public function index(Request $request): Response
    {
        return new Response("listado de things");
    }
}