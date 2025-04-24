<?php

namespace App\Enums;

enum TransactionStatus: string
{
    case PROCESSING = 'Processing';
    case SENT = 'Sent';
    case DONE = 'Done';
    case CANCELLED = 'Cancelled';
}
