<?php

namespace App\Http\Requests\Companies\CompanyPackage;

use App\Http\Requests\BaseRequest;

class StoreCompanyPackageRequest extends BaseRequest
{
    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'package_id' => 'required|integer|exists:packages,id',
            'company_id' => 'required|integer|exists:companies,id',
            'company_payment_id' => 'required|integer|exists:company_payments,id',
            'period_type' => 'required|integer',
            'auto_pay' => 'required|boolean',
            'repeat' => 'required|boolean',
        ];
    }
}
