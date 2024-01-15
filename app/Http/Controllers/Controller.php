<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Company\companies; //Companyモデルを使うための宣言
use App\Models\Product\products; //Productモデルを使うための宣言

class Controller extends BaseController
{
    public function preView(){
        $model = new Product();
        $products = $model->products();
        dd($products);
    }
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
