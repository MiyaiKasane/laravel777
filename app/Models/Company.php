<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class companies extends Model
{
    use HasFactory;
    protected $table = 'companies';

    public function products ()
{
    return $this->belongsTo(products::class,'App\Models\Product');
}
}
