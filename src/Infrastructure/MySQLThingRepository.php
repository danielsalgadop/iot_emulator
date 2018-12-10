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
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}