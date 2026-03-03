<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Http\Controllers\CompaniesController;

class Company extends Model
{
    use HasFactory;
    protected $table = 'companies';

    public function products ()
{
    return $this->hasMany(Product::class,'company_id','id');  //companyテーブルへのリレーション　1(company)対多(product) 一つの会社に対して複数の製品がある
}

public function getList()
{
    $company = Self::all();
    return $company;
}

}
