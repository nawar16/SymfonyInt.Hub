<?php

namespace App\Core\Service;

use App\Domain\Entity\SyncLog;
use Doctrine\ORM\EntityManagerInterface;

class SyncLogger
{
    public function __construct(private EntityManagerInterface $em) 
    {}

    public function log(string $integration, string $status, ?string $message = null): void
    {
        $log = new SyncLog();
        $log->setIntegration($integration);
        $log->setStatus($status);
        $log->setMessage($message);
        $this->em->persist($log);
        $this->em->flush();
    }
}