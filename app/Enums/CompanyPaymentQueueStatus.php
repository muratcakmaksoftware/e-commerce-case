<?php

namespace App\Enums;

enum CompanyPaymentQueueStatus: int
{
    case WAITING = 0;
    case PROCESSING = 1;
    case SUCCESSFULL = 2;
    case UNSUCCESSFUL = 3;
    case TRIAL_LIMIT_EXCEEDED = 4;
}
