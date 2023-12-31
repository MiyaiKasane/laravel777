<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class products extends Model
{
    use HasFactory;
    protected $table = 'products';

    public function companies ()
{
    return $this->HasMany(companies::class,'App\Models\Company');
}

    public function sales ()
{
    return $this->HasMany(sales::class,'App\Models\Sale');
}
}