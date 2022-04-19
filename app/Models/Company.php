<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    public $timestamps = true;

    //Şirkete ait domainler
    public function domains()
    {
        return $this->hasMany(Domain::class);
    }

    //Şirkete ait ödeme yöntemleri
    public function companyPayments()
    {
        return $this->hasMany(CompanyPayment::class);
    }
}
