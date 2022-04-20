<?php

namespace App\Http\Requests\Companies\CompanyPackage;

use App\Http\Requests\BaseRequest;
use App\Rules\CompanyPackageNotExistsRule;

class StoreCompanyPackageRequest extends BaseRequest
{
    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'package_id' => 'required|integer|exists:packages,id',
            'company_id' => ['required','integer','exists:companies,id', new CompanyPackageNotExistsRule],
            'company_payment_id' => 'required|integer|exists:company_payments,id',
            'period_type' => 'required|integer',
            'auto_pay' => 'required|boolean',
            'repeat' => 'required|boolean',
        ];
    }
}
