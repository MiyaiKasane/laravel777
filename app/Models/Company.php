<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\CompaniesController;

class companies extends Model
{
    use HasFactory;
    protected $table = 'companies';

    public function products ()
{
    return $this->belongsTo(products::class,'App\Models\Product');
}
}
