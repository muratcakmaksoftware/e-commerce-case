<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyPayment extends Model
{
    use HasFactory;

    //Ödeme yönteme hangi şirkete ait
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
