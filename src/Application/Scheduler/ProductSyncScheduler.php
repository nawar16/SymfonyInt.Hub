<?php

namespace App\Application\Scheduler;

use App\Application\Message\SyncProductsMessage;
use Symfony\Component\Scheduler\Attribute\AsSchedule;
use Symfony\Component\Scheduler\Schedule;
use Symfony\Component\Scheduler\RecurringMessage;
use Symfony\Component\Scheduler\ScheduleProviderInterface;

#[AsSchedule('default')]
class ProductSyncScheduler implements ScheduleProviderInterface
{
    // public function __invoke(): Schedule
    // {
    //     return (new Schedule())
    //     ->add(RecurringMessage::every('5 minutes', new SyncProductsMessage('mock')));
    // }
        
    public function getSchedule(): Schedule
    {
        return (new Schedule())
            ->add(RecurringMessage::every('1 minute', new SyncProductsMessage('mock')));
    }
}