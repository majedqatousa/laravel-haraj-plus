<?php

namespace App;

use App\Models\Ad;
use App\Models\City;
use App\Models\Favorite;

use App\Models\Message;
use App\Models\Product;
use App\Models\PromotedUser;
use App\Models\Rating;
use App\Models\Report;
use App\Models\Tech;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\HasApiTokens;
use App\Models\follower;
class User extends Authenticatable
{

    protected $table = 'users';
    public $timestamps = true;
    protected $appends = ['is_followed'];
    use HasApiTokens, Notifiable;


    protected $fillable = array('name','address', 'email', 'phone', 'connected','city_id', 'password', 'type', 'is_active','image', 'is_promoted','code','uid');
       public function getIsFollowedAttribute()
    {
        $is_followed = false;
        if (Auth::guard('user_api')->check()) {
            $is_followed = $this->userfolllow()->where('user_id', Auth('user_api')->user()->id)->count() > 0;
        }
        return $is_followed;
    }
     public function userfolllow()
    {
        return $this->belongsToMany(User::class, follower::class, 'user_followed', 'user_id');
    }
    public function reports()
    {
        return $this->hasMany(Report::class);
    }
    
    // public function getImageAttribute()
    // {
         
    //     if(!empty($this->image)){
            
    //         return url($this->image);
    //     }else{
    //       return url('vendor/download.png');  
            
    //     }
    // }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function ads()
    {
        return $this->hasMany(Ad::class);
    }


    public function social_accounts(){

        $this->hasMany(SocialAccount::class);

    }


    public function favorite()
    {
        return $this->hasone(Favorite::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class,'user_id');
    }

    public function promotedUser()
    {
        return $this->hasOne(PromotedUser::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function getMsgReceives($user)
    {



        return  Message::whereIn('id', function($query) use ($user){
           $query->selectRaw('max(`id`)')
               ->from('messages')
               ->where('reciever_id',Auth::id())

               ->groupBy('reciever_id','sender_id');
       })->select('*')
    ->orderBy('created_at', 'desc')->with('getSender','getReceiver')
    ->get();
    }

    public function getCountMsgReceivers()
    {


        return  Message::whereIn('id', function($query) {
           $query->selectRaw('max(`id`)')
               ->from('messages')
               ->where('reciever_id',Auth::id())->where('seen',0)
               ->groupBy('sender_id');})->select('*')->orderBy('created_at', 'desc')->with('getSender','getReceiver')
    ->count();
    }

    public function getMsgReceivers()
    {


        return  Message::whereIn('id', function($query) {
           $query->selectRaw('max(`id`)')
               ->from('messages')
               ->where('reciever_id',Auth::id())
               ->groupBy('sender_id');
       })->select('*')
    ->orderBy('created_at', 'desc')->with('getSender','getReceiver')
    ->take(6)->get();
    }

public function getDateAttribute($date){
   return     $this->promotedUser->date;

}

    public function getMessages($user,$product)
    {
        if (isset($product)){
            return Message::where('product_id',$product->id)->where([['sender_id',Auth::id()],['reciever_id',$user->id]])->orwhere([['sender_id',$product->user_id],['reciever_id',Auth::id()]])->with('getSender','getReceiver')->get();;

        }else{
            return Message::where([['sender_id',Auth::id()],['reciever_id',$user->id]])->orwhere([['sender_id',$user->id],['reciever_id',Auth::id()]])->with('getSender','getReceiver')->get();;

        }

    }

    public function techs()
    {
        return $this->hasMany(Tech::class,'user_id');
    }

}
