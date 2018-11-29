<?php


namespace App\Infrastructure;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
//use Symfony\Component\Routing\Annotation\Route;

class ThingController extends AbstractController
{

    public function index(): JsonResponse
    {
        return new JsonResponse(["key"=>"listado de things"]);
    }

    public function search(int $id): JsonResponse
    {
        // find Thing
        return new JsonResponse(["will search for this "=>$id]);
    }

    public function delete(int $id): JsonResponse
    {
        // find Thing
        return new JsonResponse(["will delete this id"=>$id]);
    }

}