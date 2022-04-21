<?php

namespace App\Http\Requests\Companies\CompanyPackage;

use App\Http\Requests\BaseRequest;

class CheckCompanyPackageRequest extends BaseRequest
{
    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'company_id' => 'exists:companies,id'
        ];
    }
}
