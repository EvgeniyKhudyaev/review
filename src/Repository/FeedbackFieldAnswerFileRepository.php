<?php

namespace App\Repository;

use App\Entity\Feedback\FeedbackFieldAnswerFile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class FeedbackFieldAnswerFileRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FeedbackFieldAnswerFile::class);
    }
}