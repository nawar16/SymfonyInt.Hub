<?php

namespace App\Application\Message;

class SyncProductsMessage
{
    public function __construct(public string $integrationName) 
    {}
}