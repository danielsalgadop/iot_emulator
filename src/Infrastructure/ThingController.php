<?php


namespace App\Infrastructure;

//use http\Env\Response;
use App\Domain\Entity\Thing;
use App\Domain\Entity\Action;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use App\Application\Command\Thing\CreateThingCommand;
//use App\Application\CommandHandler\Thing\CreateThingHandler; /* TODO add this as service */
//use App\Infrastructure\MySQLThingRepository;
//use Symfony\Component\Routing\Annotation\Route;

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

        $thing = new Thing();
        $thing->setBrand("branding setting".time());

        $action1 = new Action();
        $action1->setName("hardcodedAction1");
        $action2 = new Action();
        $action2->setName("hardcodedAction2");
        $thing->addAction($action1);
        $thing->addAction($action2);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($thing);
        $entityManager->persist($action1);
        $entityManager->persist($action2);
        $entityManager->flush();
        return new Response($thing->getId());
//
//        $action = new \App\Domain\Entity\Action();
//        $action->setAction('accionHardcodeada');
//        $command = new CreateThingCommand(json_encode(['hardcoded' => 'hc']),$action);
//        $commandHandler = $this->get('app.command_handler.create_thing');
//        try{
//            $thing = $commandHandler->handle($command);
//        } catch (Exception $e) {
//            return new JsonResponse(['error' => 'An application error has occurred'], 500);
//        }
//
//        return new Response("ddbb updated - thing created with this id " . $thing->getId());
    }

}