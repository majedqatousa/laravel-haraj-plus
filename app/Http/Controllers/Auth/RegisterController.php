<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\UserRequest;
use App\Http\Services\UserService;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Nexmo;
use App\Models\user_sms;
use App\Models\City;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */


    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */

    public function __construct(UserService $service){
        $this->service=$service;
        $this->middleware('guest');

    }


    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    public function getRegister(){
         $cities = City::where('country_id',1)->get();
        return view('website.register',compact('cities'));
    }

   public function register(UserRequest $request){

      $user= $this->service->storeUser($request);
        if(isset($user)){
            $token=$user->code;
            $id=$user->id;
            $phone = $user->phone;
           if(session('failed')!=null)
               return back();
           return view('auth.verify',compact('token','id', 'phone'));
        }else{

            session()->flash('success', '   رقم الهتاتف مستخدم بالفعل    ');
            return back();
           
        }
      
   

   }

    public function resend(Request $request){
        
        $id=$request['id'];
        $user=User::find($id);
       
        $user->code = rand ( 1000 , 9999 );
        $user->save();
        $token=$user->code;
        $message = "  كود التفعيل الخاص بك فى موقع حراج بلص هو ".$user->code;
        sendSMS(format_number($user->phone),  $message );
        $token=$user->code;
        $new_phone = $user->phone;
        $id = $user->id;
        session()->flash('success', 'تم الارسال بنجاح');
        // return view('auth.verify',compact('token','id','new_phone'));
      
    }

    public function user_sms(Request $request){
        if($request->ajax()){
            $user = User::find($request->user_id);
            $user_sms = new user_sms;
            $user_sms->user_id = $user->id;
            $user_sms->sms = $user->code;
            $user_sms->expired_at = $user->updated_at->addHours(1);
            $user_sms->save();
        }
    }


}
