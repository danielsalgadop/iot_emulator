<?php


namespace App\Infrastructure;

//use http\Env\Response;
use App\Application\Command\Thing\GetActionsByThingIdCommand;
use App\Application\Command\Thing\ExecuteActionCommand;
use App\Application\CommandHandler\Thing\CreateThingHandler;
use App\Application\Dto\UserCredentialsDTO;
use App\Domain\Entity\Thing;
use App\Domain\Entity\Action;
use App\Domain\Repository\ThingRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Config\Definition\Exception\Exception;
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
        $thingRepository = $this->get('app.repository.thing');
        $array_ids = $thingRepository->getAllIdOThings();
        $array_things = [];
        foreach($array_ids as $id_thing){
            $thing = $thingRepository->findThingById($id_thing);
            $array_things[] = Thing::publicInfoAsObject($thing);
        }
        return new JsonResponse($array_things);
    }

    public function getThing(int $id, Request $request): JsonResponse
    {
        try{
            $this->requestHasUserAndPasswordOrException($request);
            $UserCredentialsDTO = new UserCredentialsDTO($request->headers->get('user'), $request->headers->get('password'));

            $thing = $this->getThingByThingIdOrException($id, $UserCredentialsDTO);
            // find Thing
        } catch (\Exception $e) {

            return new JsonResponse(['error' => $e->getMessage()], 500);
        }
        $obj = Thing::privateInfoAsObject($thing);
        return new JsonResponse($obj,201);
    }

    public function delete(int $id, Request $request): JsonResponse
    {
        try{
            $this->requestHasUserAndPasswordOrException($request);
            $UserCredentialsDTO = new UserCredentialsDTO($request->headers->get('user'), $request->headers->get('password'));


            // TODO use getThingByThingIdOrException
            $thingRepository = $this->get('app.repository.thing');
            $thing = $this->getThingByThingIdOrException($id, $UserCredentialsDTO);
            $thingRepository->remove($thing);
            $thingRepository->flush();
        } catch (\Exception $e) {

            return new JsonResponse(['error' => $e->getMessage()], 500);
        }
        return new JsonResponse('',204);
    }

    public function create(Request $request)
    {
        try{
            $array = $this->decodeJsonToArrayOrException($request->getContent());
            $this->requestHasUserAndPasswordOrException($request);
            $UserCredentialsDTO = new UserCredentialsDTO($request->headers->get('user'), $request->headers->get('password'));

            $createThingCommandHandler = $this->get('app.command_handler.create_thing');
            $command = new CreateThingCommand($array, $UserCredentialsDTO);
            $thing = $createThingCommandHandler->handle($command);
            $thingRepository = $this->get('app.repository.thing');
            $thingRepository->save($thing);
            $thingRepository->flush();

        } catch (\Exception $e) {

            return new JsonResponse(['error' => $e->getMessage()], 500);
        }
        return new Response("ddbb updated - thing created with this id " . $thing->getId(),201);
    }

    public function executeAction($id,$action_name,Request $request)
    {

        try{
            $this->requestHasUserAndPasswordOrException($request);
            $UserCredentialsDTO = new UserCredentialsDTO($request->headers->get('user'), $request->headers->get('password'));
            $thing = $this->getThingByThingIdOrException($id, $UserCredentialsDTO);

            $executeActionHandler = $this->get('app.command_handler.execute_action');
            $array = $this->decodeJsonToArrayOrException($request->getContent());

            $command = new ExecuteActionCommand($thing, $action_name, $array);
            $executeActionHandler->handle($command);
            $thingRepository = $this->get('app.repository.thing');
            $thingRepository->flush();
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
    public function getActionsByThingId($id, Request $request)
    {
        try {
            $this->requestHasUserAndPasswordOrException($request);
            $searchThingByIdCommandHandler = $this->get('app.command_handler.search_thing_by_id');
            $UserCredentialsDTO = new UserCredentialsDTO($request->headers->get('user'), $request->headers->get('password'));

            $command = new SearchThingByIdCommand($id,$UserCredentialsDTO);
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


        return new JsonResponse($array_actions);
    }

    public function getValueOfProperty($id,$property_name, Request $request)
    {
        # we assume property name === action name (in fact, there is NO property_name)

        try{
            $this->requestHasUserAndPasswordOrException($request);
            $UserCredentialsDTO = new UserCredentialsDTO($request->headers->get('user'), $request->headers->get('password'));
            $thing = $this->getThingByThingIdOrException($id,$UserCredentialsDTO);
            $actions = $thing->getActions();
            foreach ($actions as $action) {
                if($action->getName() === $property_name){
                    $property = $action->getProperty();
                    return new JsonResponse($property->asArray());
                }
            }
        } catch (\Exception $e){
            return new JsonResponse(['error' => $e->getMessage()], 500);
        }
        return new JsonResponse(['error' => "unknown Property"], 500);
    }

    // TODO use it in this file where 'app.command_handler.search_thing_by_id' is being used
    // DUDA, esto es "sospechosamente" MUY parecido a thingRepository->searchThingByIdOrException($id)
    private function getThingByThingIdOrException($id, UserCredentialsDTO $UserCredentialsDTO){

        $searchThingByIdCommandHandler = $this->get('app.command_handler.search_thing_by_id');
        $command = new SearchThingByIdCommand($id,$UserCredentialsDTO);
        return $searchThingByIdCommandHandler->handle($command);
    }


    // TODO: poner aqui un DTO userCredentials extractUserAndPasswordFromRequestOrException: DTO
    private function requestHasUserAndPasswordOrException(Request $request)
    {
        $user = $request->headers->get('user');
        $password = $request->headers->get('password');
        if(!isset($user) || !isset($password)){
            throw new Exception("Invalid Request: cant find mandatory http-headers, user and password");
        }
    }


    private function decodeJsonToArrayOrException($json)
    {
        $array = json_decode($json,true);

        if ($array === null && json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception("Bad Json");
        }

        return $array;
    }
}
