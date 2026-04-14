<?php

namespace App\Core\Enum;

enum SyncStatus: string
{
    case PENDING = 'pending';
    case SYNCED = 'synced';
    case FAILED = 'failed';
}