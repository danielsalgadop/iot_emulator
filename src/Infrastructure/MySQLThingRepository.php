<?php


namespace App\Infrastructure;

use App\Domain\Entity\Thing;
use App\Domain\Repository\ThingRepository;
use Doctrine\ORM\EntityManagerInterface;

class MySQLThingRepository implements ThingRepository
{
    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    public function save(Thing $thing)
    {
        try {
            $this->em->persist($thing);
            $this->em->flush();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public function searchThingByIdOrException(int $id): ?Thing
    {
//        $things = $this->em
//            ->getRepository(Thing::class)
//            ->findBy(['id' => $id]);

        $thing = $this->em->find(Thing::class, $id);
        if($thing === null){
            throw new \Exception("Non-existing THING id");
        }
        return $thing;
//        return $things->getId();

//        if (count($things) === 0) {
//            throw new \Exception("Uknknown id");
////            throw UnknownPostException::withPostId($postId);
//        }
//        return $things[0];
    }
}