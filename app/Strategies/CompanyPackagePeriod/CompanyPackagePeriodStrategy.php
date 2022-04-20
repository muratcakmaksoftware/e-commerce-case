<?php

namespace App\Strategies\CompanyPackagePeriod;

use App\Interfaces\Strategies\CompanyPackagePeriod\CompanyPackagePeriodStrategyInterface;

class CompanyPackagePeriodStrategy
{
    private CompanyPackagePeriodStrategyInterface $strategy;

    public function setStrategy(CompanyPackagePeriodStrategyInterface $strategy)
    {
        $this->strategy = $strategy;
    }

    public function createPeriods($attributes)
    {
        return $this->strategy->createPeriods($attributes);
    }
}
