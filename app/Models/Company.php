<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Http\Controllers\CompaniesController;

class Companies extends Model
{
    use HasFactory;
    protected $table = 'companies';

    public function products ()
{
    return $this->hasMany(Product::class,'company_id','id');
}
}
