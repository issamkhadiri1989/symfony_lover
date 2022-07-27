<?php

namespace App\Repository;

use App\Entity\Interview;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class InterviewRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Interview::class);
    }

    /**
     * Gets all today's interviews.
     *
     * @return ?Interview[] list of interviews ordered by the closest meeting to the farther
     */
    public function listDailyInterviews(): ?array
    {
        $queryBuilder = $this->createQueryBuilder('i');

        return $queryBuilder->select()
            ->where('date(i.meetingDate) = date(:q)')
            ->setParameter('q', (new \DateTime('now')))
            ->orderBy('i.meetingDate', 'asc')
            ->getQuery()
            ->getResult();
    }

    /**
     * Gets all interviews of the current year.
     *
     * @return ?Interview[] list of interviews ordered by the closest meeting to the farther
     */
    public function interviewsOfTheYear()
    {
        $queryBuilder = $this->createQueryBuilder('i');

        return $queryBuilder->select()
            ->where('year(i.meetingDate) = year(:q)')
            ->setParameter('q', (new \DateTime('now')))
            ->orderBy('i.meetingDate', 'asc')
            ->getQuery()
            ->getResult();
    }
}
