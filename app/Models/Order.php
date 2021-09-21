<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table  = 'orders';
    protected $fillable = ['name_customer','phone','email','address','total_product','price','total_price'];

    public function products()
    {
        return $this->belongsToMany('App\Models\Product');
    }
}
