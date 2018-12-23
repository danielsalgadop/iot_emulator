<?php


namespace App\Infrastructure;

use App\Domain\Entity\Action;
use App\Domain\Repository\ActionRepository;
use Doctrine\ORM\EntityManagerInterface;

class MySQLActionRepository implements ActionRepository
{
    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    public function save(Action $action)
    {
        try {
            $this->em->persist($action);
            $this->em->flush();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}