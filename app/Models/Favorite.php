<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{

    protected $table = 'favorites';
    public $timestamps = true;
    protected $fillable = array('user_id', 'product_id');

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public function getProductsAttribute()
    // {
    //     return $this->hasMany(Product::class);
    // }
    public function getProductsAttribute()
    {
        return $this->hasMany(Product::class,'id','product_id');
    }
  
}
