<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    use HasFactory;

    protected $guarded = [];

    //Bu domain hangi şirkete ait
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
