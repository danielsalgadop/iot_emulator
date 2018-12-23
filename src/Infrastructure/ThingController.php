<?php


namespace App\Infrastructure;

//use http\Env\Response;
use App\Application\CommandHandler\Thing\CreateThingHandler;
use App\Domain\Entity\Thing;
use App\Domain\Entity\Action;
use App\Domain\Repository\ThingRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use App\Application\Command\Thing\CreateThingCommand;
//use App\Application\CommandHandler\Thing\CreateThingHandler; /* TODO add this as service */
use App\Infrastructure\MySQLThingRepository;
//use Symfony\Component\Routing\Annotation\Route;

//use Doctrine\ORM\EntityManager;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
//$registry = new Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;




class ThingController extends Controller
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

    public function create()
    {


        $thingRepository= $this->get('app.repository.thing');
//        var_dump($thingRepository);
//        $thingRepository = new ThingRepository($registry);
        $createThingCommandHandler = new CreateThingHandler($thingRepository);
//        $createThingCommandHandler = $this->get('app.command_handler.create_thing');

        try{
            $time = time();
            $command = new CreateThingCommand(json_encode(['brand' => 'hcBrand'.$time]),['actionName1'.$time,'actionName2'.$time]);
            $thing = $createThingCommandHandler->handle($command);
        } catch (Exception $e) {
            return new JsonResponse(['error' => 'An application error has occurred'], 500);
        }
//        return new Response("ddbb updated - thing created with this id " . $thing->getId());
        return new Response("no hay magia aqui");
    }

}