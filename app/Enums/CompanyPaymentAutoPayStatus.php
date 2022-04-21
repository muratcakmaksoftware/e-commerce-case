<?php

namespace App\Enums;

enum CompanyPaymentAutoPayStatus: int
{
    case ACTIVE = 1;
    case PASSIVE = 0;
}
