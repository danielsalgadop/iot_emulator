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
    public function searchThingById(int $id)
    {
//        $things = $this->em
//            ->getRepository(Thing::class)
//            ->findBy(['id' => $id]);

        return $this->em->find(Thing::class, 1);
//        return $things->getId();

//        if (count($things) === 0) {
//            throw new \Exception("Uknknown id");
////            throw UnknownPostException::withPostId($postId);
//        }
//        return $things[0];
    }
}