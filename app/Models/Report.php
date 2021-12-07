<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Rating;

class Report extends Model
{

    protected $table = 'reports';
    public $timestamps = true;
    protected $fillable = array('body', 'user_id', 'product_id','rate_id');

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function product()
    {
            return $this->belongsTo(Product::class);

    }
    public function getIsReportedAttribute()
    {
        $is_reported = false;
        if (Auth::guard('user_api')->check()) {
            $is_reported = $this->reports()->where('user_id', Auth('user_api')->user()->id)->count() > 0;
        }
        return $is_reported;
    }
    public function rate()
    {

            return $this->belongsTo(Rating::class,'rate_id');
    }
}
