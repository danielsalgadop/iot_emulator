<?php

namespace App\Application\CommandHandler\Thing;


use App\Application\Command\Thing\CreateThingCommand;
use App\Domain\Entity\Action;
use App\Domain\Entity\Thing;
use App\Domain\Repository\ThingRepository;
//use Doctrine\ORM\EntityManager;

class CreateThingHandler
{
    private $postRepository;

    public function __construct(ThingRepository $thingRepository)
    {
        $this->thingRepository = $thingRepository;
    }

//    public function handle():Thing
    public function handle(CreateThingCommand $command):Thing
    {
        $thing = new Thing();


        $thing->setBrand(date('H:i:s')); // mocking brand name (it is only a date, I know)

//
//        foreach ($command->getActions() as $action) {
//            $action1 = new Action();
//            $action1->setName($action);
//
//        }
//        $thing->addAction($action1);

        $action2 = new Action();
        $action2->setName("hardcodedAction2");
        $thing->addAction($action2);


        //
        $this->thingRepository->save($thing);
//        $entityManager = $this->getDoctrine()->getManager();
//        $entityManager = new EntityManager();


//        $entityManager->persist($thing);

//        $entityManager->persist($action1);
//        $entityManager->persist($action2);
//        $entityManager->flush();
        return $thing;

//        $thing = Thing::create($command->title(), $command->body());
//        $thing = new Thing();
//        var_dump($command->getJson());
//        $actions = [new Action('action1'),new Action('action2')];




//        $action = $command->getActions();
//        $thing->setActions(json_decode($command->getJson());
//        $thing->setActions(new Action('action1'));
//        $action = new Action();
//        $action->setAction('ActionHardCoded');
//        $thing->setActions(['HCasArray']);
//        $thing->setBrand(date('H:i:s')); // mocking brand name (it is only a date, I know)
//        $this->thingRepository->save($thing);
//        return $thing;
    }
}