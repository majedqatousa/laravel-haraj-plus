<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\SocialAccount;
use App\User;


use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;
use function GuzzleHttp\Psr7\str;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = 'admin/index';
    protected $var=0;

    protected $maxAttempts = 3; // Default is 5
    protected $decayMinutes = 2; // Default is 1
    protected $count=0;

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('guest')->except('logout');

    }





    public function showLoginForm()
    {
        return view('admin.login');
    }

      public function login(Request $request){
          $this -> validateLogin($request);


     if( Auth::attempt(['email' =>$request->email, 'password'=>$request->password,'type'=>1,'is_active'=>1] ))
     {
         User::where('email',$request->email)->update(['connected'=>1]);

             return redirect()->route('main');

    }

   else
   {


       return $this->sendFailedLoginResponse($request);
   }


      }


      public function loginUser(Request $request){

      $validator=Validator::make($request->all(),['email'=>'required|string|email',
          'password' => 'required|string']);
          $remember_me = $request->has('remember') ? true : false;
        if($validator->fails())
        {  
          return response()->json(['msg'=>'البريد الالكترونى غير صالح','success'=>0]);}
          if (Auth::attempt(['email' =>$request->email, 'password' => $request->password,'is_active'=>1],$remember_me )) {
              User::where('email', $request->email)->update(['connected' => 1]);
              $msg=' تم تسجيل دخولك بنجاح .. جار التحميل بنجاح :)';

              return response()->json(['msg'=>$msg,'success'=>1]);
          }

          else {
          if($user=User::where('email',$request->email)->where('is_active',0)->first()  )
          { $msg='تم حظر هذا الحساب';
          return response()->json(['msg'=>$msg,'success'=>0]);

          }

          else {

              session()->flash('out',session('out')+1);
            if(session('out')>=6){
                dd("session('out')>=6");
                return response()->json(['msg'=>2,'success'=>0]);
            }

            else
             return response()->json(['msg' => 'البريد الالكترونى وكلمه السر لا يتطابقان', 'success' => 0]);
          }
          }


      }




    /**
     * Handle Social login request
     *
     * @return response
     */

    public function redirectToProvider($provider)
    {

        return Socialite::driver($provider)->redirect();
    }


    public function socialLogin(Request $request)
    {
        // return  response()->json(['output'=>Socialite::driver($request->social)->stateless()->redirect()]);
        
        $url = Socialite::with($request->social)->stateless()->redirect()->getTargetUrl();
        
        return \response()->json([
            'url' => $url
        ], 200);
    }

    // public function handleProviderCallback($provider)
    // {
        
    //     if($provider != "twitter")
    //     {
    //     $user = Socialite::driver($provider)->stateless()->user();
    //     }
    //     else{
    //       $user = Socialite::with($provider)->user();
    //     }
        
    //     $loggin_user = $this->createOrGetUser($user, $provider);

    //     if ($loggin_user->first == 'first' || $loggin_user->phone == ''){
    //         $token=$loggin_user->code;
    //         $id=$loggin_user->id;

    //         // return redirect()->route('add_phone',[
    //         //     'token'=> $token,
    //         //     'id'=> $id,
    //         // ]);
    //         $output = view('auth.add_phone',compact('token','id'))->render();
    //       return response()->json(['success'=>true,'output'=>$output]);


    //     }else{

    //         Auth::login($loggin_user);
    //         return redirect()->to('/');

    //     }


// 
    // }

    public function createOrGetUser(Request $request)
    {
        
        // dd($request->all());
        //check if exist or not
        $account = SocialAccount::where('provider_user_id', $request->uid)->first();
        //if exists login
        //else create
        if ($account){
            //Return account if found
            $user = User::where('id',$account->user_id)->first();
            if($user && $user->phone != null && $user->is_active == 1 )
            {
                
            $user->update(['is_active'=>1,'uid'=>$request->uid]);
            //auth using id
            $status = 'old';
            Auth::login($user);
            return response()->json(['success'=>true,'user'=>$user , 'stat' => $status]);
            }else{
                  
                $status = 'add_phone';
                $token = $user->code;
                $id = $user->id;
    
                $url = `{{env("MAIN_URL")}}/add_phone/ `. $token . '/' . $id;
                //Auth::login($user);
                return response()->json(['success'=>true,'user'=>$user , 'url' => $url , 'token' => $token , 'id' =>$id , 'stat' => $status]);
            }
        }else{
            //Check if user with same email address exist

            // if($request->social != "twitter")
            // {
            //  $providerUser = Socialite::driver($request->social)->stateless()->user();
            // }
            // else{
            //   $providerUser = Socialite::with($request->social)->user();
            // }
            // dd($providerUser);
            $user = User::where('uid', $request->uid)->first();
            //Create user if dont'exist
            $code = rand ( 1000 , 9999 );
            if (!$user) {
                
                $user = User::create([
                    'email' => $request->email==null?null:$request->email, 
                    'name' => $request->name == null ?'' :$request->name,
                    'uid' =>$request->uid,
                    'code' =>$code,
                    'image' =>$request->image,
                
                ]);

            }

            //Create social account
            $social_account = new SocialAccount();
            $social_account->provider_user_id = $request->uid;
            $social_account->provider = $request->social;
            $social_account->user_id = $user->id;
            $social_account->save();
            // $user->first = 'first';
            $user->update(['uid'=>$request->uid]);
            
            $status = 'new';
            $token = $code;
            $id = $user->id;

            $url = 'add_phone/' . $token . '/' . $id;
            //Auth::login($user);
            return response()->json(['success'=>true,'user'=>$user , 'url' => $url , 'token' => $token , 'id' =>$id , 'stat' => $status]);
        }
    }

}
