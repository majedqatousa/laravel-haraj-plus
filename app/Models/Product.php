<?php

namespace App\Models;
use App\Traits\Shareable;
use App\Models\Rating;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{

    // use Shareable;

    // protected $table = 'products';
    // public $timestamps = true;

    // protected $shareOptions = [
    //     'columns' => [
    //         'name' => 'name',
    //         'description' => 'description'
    //     ],
    //     'url' => null
    // ];


    // protected $fillable = array('name','user_promoted', "user_id",'is_valid', 'status', 'main_image','is_checked', 'discount_ratio', 'price','city_id' ,'category_id', 'description','video','average_rate');

    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }
    // public function getUrlAttribute()
    // {
    //     return route('product-details', $this->id);
    // }

    // public function getImagesAttribute()
    // {
    //     return $this->hasMany(Image::class);
    // }

    // public function category()
    // {
    //     return $this->belongsTo(Category::class);
    // }

    // public function favourite()
    // {
    //     return $this->belongsTo(Favorite::class);
    // }



    // public function getRatingsAttributes()
    // {
    //     return $this->hasMany(Rating::class);


    // }

    // public function bestRate()
    // {
    //     return $this->hasMany(Rating::class)->OrderBy('degree','DESC')->first();
    // }

    // public function WorsetRate()
    // {
    //     return $this->hasMany(Rating::class)->OrderBy('degree','ASC')->first();
    // }


    // public function rates(){

    //     return $this->hasMany(Rating::class);
    // }

    // public function avg()
    // {
    //     if ($this->rates()->count() != 0) {
    //         return $this->rates()->sum('degree') / $this->rates()->count();
    //     }
    //     return null;
    // }

    // public function reports(){

    //     return $this->hasMany(Report::class);
    // }
    // public function city(){
    //     return $this->belongsTo(City::class);
    // }

    use Shareable;

    protected $table = 'products';
    public $timestamps = true;
    // protected $appends = ['is_joined', 'company_name', 'image', 'Phone', 'product_image'];

    public function getIsJoinedAttribute()
    {
        $is_joined = false;
        if (Auth::guard('user_api')->check()) {
            $is_joined = $this->userfavorit()->where('user_id', Auth('user_api')->user()->id)->count() > 0;
        }
        return $is_joined;
    }

    public function getproductImageAttribute()
    {
        if (!empty($this->main_image))
            return url('storage/' . $this->main_image);
        else
            return null;
    }

    // public function getIsReportedAttribute()
    // {
    //     $is_joined = false;
    //     if (Auth::guard('user_api')->check()) {
    //         $is_reported = $this->reports()->where('user_id', Auth('user_api')->user()->id)->count() > 0;
    //     }
    //     return $is_joined;
    // }

    public function getCompanyNameAttribute()
    {
        if (!empty($this->user->name))
            return $this->user->name;
        else
            return null;
    }

    public function getPhoneAttribute()
    {
        if (!empty($this->user->phone))
            return $this->user->phone;
        else
            return null;
    }

    public function getCityAttribute()
    {
        if (empty($this->city->name)) {
            return $this->city->name;
        } else {
            return null;
        }
    }

    public function getImageAttribute()
    {
        if (!empty($this->user->image))
            return url($this->user->image);
        else
            return url('vendor/download.png');
    }

    protected $shareOptions = [
        'columns' => [
            'name' => 'name',
            'description' => 'description'
        ],
        'url' => null
    ];

    protected $fillable = array('name', 'user_promoted', "user_id", 'is_valid', 'status', 'main_image', 'is_checked', 'discount_ratio', 'price', 'city_id', 'category_id', 'description', 'video', 'average_rate');

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getUrlAttribute()
    {
        return route('product-details', $this->id);
    }

    public function getImagesAttribute()
    {
        return $this->hasMany(Image::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function favourite()
    {
        return $this->belongsTo(Favorite::class);
    }

    public function userfavorit()
    {
        return $this->belongsToMany(User::class, Favorite::class, 'product_id', 'user_id');
    }

    public function getRatingsAttributes()
    {
        return $this->hasMany(Rating::class);
    }

    public function bestRate()
    {
        return $this->hasMany(Rating::class)->OrderBy('degree', 'DESC')->first();
    }

    public function WorsetRate()
    {
        return $this->hasMany(Rating::class)->OrderBy('degree', 'ASC')->first();
    }

    public function rates()
    {

        return $this->hasMany(Rating::class);
    }

    public function avg()
    {
        if ($this->rates()->count() != 0) {
            return $this->rates()->sum('degree') / $this->rates()->count();
        }
        return null;
    }

    public function reports()
    {

        return $this->hasMany(Report::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }
}
