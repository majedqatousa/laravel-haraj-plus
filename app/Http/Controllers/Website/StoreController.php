<?php

namespace App\Http\Controllers\Website;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use SebastianBergmann\Environment\Console;
use App\Models\PromotedUser;
use Illuminate\Support\Str;
use App\User;


class StoreController extends Controller
{
    //

    public function index(){
        return view('website.create_store');
    }
    public function create(){
        $user = auth()->id();

        if($promoted=PromotedUser::where('user_id',$user)->first()){
            $promoted->update([
                'pakage_id'=>2,
                'start_date'=>\Carbon\Carbon::now()->format('Y-m-d'),
                'end_date'=>\Carbon\Carbon::now()->addDays(360)->format('y-m-d')]);

                $promotedUser = User::where("id", $user)->first();
                if($promotedUser){
                    $promotedUser->is_promoted = 1;
                    $promotedUser->save();
                }
        }else{
            PromotedUser::create(['user_id'=>$user,'pakage_id'=>2,'start_date'=>\Carbon\Carbon::now()->format('Y-m-d'),'link'=>Str::random(6),'end_date'=>\Carbon\Carbon::now()->addDays(360)->format('y-m-d')]);
            $promotedUser = User::where("id", $user)->first();
            if($promotedUser){
                $promotedUser->is_promoted = 1;
                $promotedUser->save();
            }
        }
        return redirect()->route('business-profile', $user);
    }
}
