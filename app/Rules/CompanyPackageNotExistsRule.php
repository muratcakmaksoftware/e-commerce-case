<?php

namespace App\Rules;

use App\Models\CompanyPackage;
use Illuminate\Contracts\Validation\Rule;

class CompanyPackageNotExistsRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return !CompanyPackage::where('company_id', $value)->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'You have already purchased a package.';
    }
}
