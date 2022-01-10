<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PromotedUser;
use Illuminate\Support\Str;
use App\User;
class StoreController extends Controller
{
    //
    public function create(){
        if($promoted=PromotedUser::where('user_id',Auth('user_api')->user()->id)->first()){
            $promoted->update([
                'pakage_id'=>2,
                'start_date'=>\Carbon\Carbon::now()->format('Y-m-d'),
                'end_date'=>\Carbon\Carbon::now()->addDays(360)->format('y-m-d')]);

                $promotedUser = User::where("id", Auth('user_api')->user()->id)->first();
                if($promotedUser){
                    $promotedUser->is_promoted = 1;
                    $promotedUser->save();
                }
        }else{
            PromotedUser::create(['user_id'=>Auth('user_api')->user()->id,'pakage_id'=>2,'start_date'=>\Carbon\Carbon::now()->format('Y-m-d'),'link'=>Str::random(6),'end_date'=>\Carbon\Carbon::now()->addDays(360)->format('y-m-d')]);
            $promotedUser = User::where("id", Auth('user_api')->user()->id)->first();
            if($promotedUser){
                $promotedUser->is_promoted = 1;
                $promotedUser->save();
            }
        }
        return ControllersService::generateProcessResponse(true, 'CREATE_STORE');

    }
}
