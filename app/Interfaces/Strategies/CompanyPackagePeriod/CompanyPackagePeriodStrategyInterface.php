<?php

namespace App\Interfaces\Strategies\CompanyPackagePeriod;

interface CompanyPackagePeriodStrategyInterface
{
    /**
     * @param array $attributes
     * @return mixed
     */
    public function createPeriods(array $attributes): array;
}
