<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class PromotedUser extends Model
{

    protected $table = 'promotedUsers';
    public $timestamps = true;
    protected $fillable = array('user_id', 'about', 'cover_image', 'link', 'pakage_id','is_active', 'start_date', 'end_date');
    
    public function userDetiles()
    {
        return $this->belongsTo(User::class, 'user_id')->select('id', 'name', 'image', 'phone');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function pakages()
    {
        return $this->hasMany(Product::class);
    }

}
