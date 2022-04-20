<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyPaymentLog extends Model
{
    use HasFactory;

    protected $guarded = [];

    //Bu hata hangi ödeme periyodu işleminde gerçekleşti
    public function companyPaymentPeriods()
    {
        return $this->belongsTo(CompanyPaymentPeriod::class);
    }
}
