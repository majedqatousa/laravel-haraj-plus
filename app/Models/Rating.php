<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
class Rating extends Model
{

    protected $table = 'ratings';
    public $timestamps = true;
    protected $fillable = array('degree', 'comment', 'product_id', 'user_id');

        protected $appends = ['is_reported','Name','image'];
    public function getIsReportedAttribute()
    {
        $is_reported = false;
        if (Auth::guard('user_api')->check()) {
            $is_reported = $this->userReport()->where('user_id', Auth('user_api')->user()->id)->count() > 0;
        }
        return $is_reported;
    }
     public function getReportedAttribute()
    {
        $is_reported = false;
        if (Auth::guard('user_api')->check()) {
        $is_reported = $this->rates()->where('user_id', Auth('user_api')->user()->id)->count() > 0;
        }
        return $is_reported;
    }
    public function getNameAttribute()
    {
        if (!empty($this->user->name))
        return $this->user->name;
        else
            return null;

    }
      public function getImageAttribute()
    {
        if (!empty($this->user->image))
        return url($this->user->image);
        else
        return url('vendor/download.png');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function rates()
    {
        return $this->hasMany(Report::class,'rate_id');
    }
    public function userReport()
    {
        return $this->belongsToMany(User::class, Report::class, 'rate_id', 'user_id');
    }

}
