<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class products extends Model
{
    use HasFactory;
    protected $table = 'products';

    public function companies ()
{
    return $this->hasMany(companies::class,'App\Models\Company');
}

    public function sales ()
{
    return $this->hasMany(sales::class,'App\Models\Sale');
}
}