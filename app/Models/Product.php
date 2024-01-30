<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Company; //Companyモデルを使うための宣言
use App\Http\Controllers\CompaniesController;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';


    public function products ()
    {
        $product = Self::all();
        return $product;

    }

    public function company ()
    {
        return $this->belongsTo(Company::class,'company_id','id');
    }

    public function sale ()
    {
        return $this->belongsTo(Sale::class,'App\Models\Sale');
    }
}