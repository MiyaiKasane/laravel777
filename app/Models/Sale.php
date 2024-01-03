<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class sales extends Model
{
    use HasFactory;
    protected $table = 'sales';

    public function products ()
{
    return $this->belongsTo(products::class,'App\Models\Product');
}
}
