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
        $product = Product::all();
        $controller = new CompaniesController();
        return $product = $controller->preView();
    }

    public function companies ()
    {
        return $this->hasMany(companies::class,'App\Models\Company');
    }

    public function sales ()
    {
        return $this->belongsTo(sales::class,'App\Models\Sale');
    }
}