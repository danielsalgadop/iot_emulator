<?php


namespace App\Infrastructure;

use App\Domain\Repository\ThingRepository;
use App\Domain\Entity\Thing;
use Doctrine\ORM\EntityManagerInterface;
use \Exception;

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
        } catch (Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
    public function remove(Thing $thing)
    {
        try {
            $this->em->remove($thing);
        } catch (Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
    public function searchThingByIdOrException(int $id): ?Thing
    {
        $thing = $this->em->find(Thing::class, $id);
        if ($thing === null) {
            throw new Exception("Non-existing THING with endpoint [".$id."]");
        }
        return $thing;
    }

    public function flush()
    {
        try {
            $this->em->flush();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
    public function getAllIdOThings(): array
    {
        $result = $this->em->createQuery("SELECT T.id FROM App:Thing T")->getArrayResult();
        return array_map('current', $result);
    }

    // TODO: creo que está obsoleto, cambiar por searchThingByIdOrException
    public function findThingById($id): Thing
    {
        return $this->em->find(Thing::class, $id);
    }
}
