<?php


namespace App\Infrastructure;

//use http\Env\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Domain\Entity\Thing;
use Doctrine\ORM\EntityManagerInterface;

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
        // delete Thing
        return new JsonResponse(["will delete this id"=>$id]);
    }

    public function ddbb(EntityManagerInterface $em)
    {
        $thing = new Thing();
        $thing->setBrand(date('H:i:s')); // mocking brand name (it is only a date, I know)
        $em->persist($thing);
        $em->flush();
//        return new Response("ddbb updated - thing created with this id " . $thing->id);
        return new Response("ddbb updated - thing created with this id ");
    }

}