<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyPaymentPeriod extends Model
{
    use HasFactory;

    protected $guarded = [];

    //Bu period hangi şirkete ait
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    //Bu period hangi satın alınmış pakete ait
    public function companyPackage()
    {
        return $this->belongsTo(CompanyPackage::class);
    }
}
