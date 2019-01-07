<?php


namespace App\Infrastructure;

//use http\Env\Response;
use App\Application\Command\Thing\GetActionsByThingIdCommand;
use App\Application\Command\Thing\UpdatePropertyCommand;
use App\Application\CommandHandler\Thing\CreateThingHandler;
use App\Domain\Entity\Thing;
use App\Domain\Entity\Action;
use App\Domain\Repository\ThingRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use App\Application\Command\Thing\CreateThingCommand;
use App\Application\Command\Thing\SearchThingByIdCommand;
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
        $searchThingByIdCommandHandler = $this->get('app.command_handler.search_thing_by_id');

        try{
            $command = new SearchThingByIdCommand($id);
            $thing = $searchThingByIdCommandHandler->handle($command);
        } catch (\Exception $e) {

            return new JsonResponse(['error' => $e->getMessage()], 500);
        }
        $array = $thing->searchOutput();
        return new JsonResponse($array,201);
//        return new JsonResponse(json_encode($thing));
        return new JsonResponse(["will search for this "=>$id]);
    }

    public function delete(int $id): JsonResponse
    {
        // delete Thing
        return new JsonResponse(["will delete this id"=>$id]);
    }

    public function create(Request $request)
    {

        $createThingCommandHandler = $this->get('app.command_handler.create_thing');

        try{
            $command = new CreateThingCommand($request->getContent());
            $thing = $createThingCommandHandler->handle($command);
        } catch (\Exception $e) {

            return new JsonResponse(['error' => $e->getMessage()], 500);
        }
        return new Response("ddbb updated - thing created with this id " . $thing->getId(),201);
    }

    public function updateProperty($id,$action_name,Request $request)
    {
        //file_put_contents("/tmp/debug.txt", var_export($request->getContent(), true) . PHP_EOL, FILE_APPEND);

        // find Thing
        $searchThingByIdCommandHandler = $this->get('app.command_handler.search_thing_by_id');
        $updatePropertyHandler = $this->get('app.command_handler.update_property');

        try{
            $command = new SearchThingByIdCommand($id);
            $thing = $searchThingByIdCommandHandler->handle($command);
            $command = new UpdatePropertyCommand($thing, $action_name, $request->getContent());
            $updatePropertyHandler->handle($command);
        } catch (\Exception $e) {

            return new JsonResponse(['error' => $e->getMessage()], 500);
        }
        return new JsonResponse("updated property for id ".$thing->getId(), 204);

        /*
        $objData = json_decode($request->getContent());
        $new_value = $objData[0]->$action_name;
//                file_put_contents("/tmp/debug.txt", var_export($objData,true).PHP_EOL,FILE_APPEND);
//                file_put_contents("/tmp/debug.txt", var_export($request->getContent(),true).PHP_EOL,FILE_APPEND);
        file_put_contents("/tmp/debug.txt", var_export($new_value,true).PHP_EOL,FILE_APPEND);
        return new JsonResponse("ruta ok $id $action_name");
        */
    }
    public function getActionsByThingId($id)
    {

        $searchThingByIdCommandHandler = $this->get('app.command_handler.search_thing_by_id');

        try {
            $command = new SearchThingByIdCommand($id);
            $thing = $searchThingByIdCommandHandler->handle($command);


            $array_actions = [];
            foreach ($thing->getActions() as $action) {
                // TODO better json {} creation- https://stackoverflow.com/questions/3281354/create-json-object-the-correct-way

                $objAction = new \stdClass();
                $objAction->id= $action->getId();
                $objAction->name= $action->getName();
                $array_actions[] = $objAction;
            }
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 500);
        }

        return new JsonResponse(json_encode($array_actions));
    }
}