<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\CompaniesController;

class Sales extends Model
{
    use HasFactory;
    protected $table = 'sales';

    public function products ()
    {
        return $this->hasMany(Product::class,'App\Models\Product');
    }
}
