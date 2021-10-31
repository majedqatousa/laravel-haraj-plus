<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class follower extends Model
{
  protected $table = 'followers';
  
    public function user()
  {
    return $this->belongsTo(User::class, 'user_followed');
  }
  public function userfollower()
  {
    return $this->belongsTo(User::class, 'user_id');
  }
}
