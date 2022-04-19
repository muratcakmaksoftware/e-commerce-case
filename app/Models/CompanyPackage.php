<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyPackage extends Model
{
    use HasFactory;

    //Paket bilgisi
    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    //Şirket bilgisi
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    //Ödeme yöntemi bilgisi
    public function companyPayment()
    {
        return $this->belongsTo(CompanyPayment::class);
    }

    //Pakete ait ödeme periyotları
    public function companyPaymentPeriods()
    {
        return $this->hasMany(CompanyPaymentPeriod::class);
    }
}
