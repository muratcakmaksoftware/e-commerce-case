<?php

namespace App\Enums;

enum CompanyPaymentLogType: int
{
    case UNSUCCESSFUL = 0;
    case TIMEOUT = 1;
    case UNKNOWN_ERROR = 2;
}
