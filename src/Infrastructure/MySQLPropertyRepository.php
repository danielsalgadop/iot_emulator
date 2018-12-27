<?php


namespace App\Infrastructure;

use App\Domain\Entity\Property;
use App\Domain\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;

class MySQLPropertyRepository implements PropertyRepository
{
    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    public function save(Property $property)
    {
        try {
            $this->em->persist($property);
            $this->em->flush();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}