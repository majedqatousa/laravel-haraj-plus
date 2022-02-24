<?php

namespace App\Http\Controllers\API;

use App\Helpers\Messages;
use App\Http\Controllers\API\ControllersService;
use App\User;
use App\Models\Tech;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\PseudoTypes\True_;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\API\UserNotificationController;
use Symfony\Component\HttpFoundation\Response;
use App\Models\PromotedUser;
use App\Models\Product;
class UserApiAuthController extends AuthBaseController
{

    //
    //php artisan passport:client --personal
    public function login(Request $request)
    {
        $roles = [
            'phone' => 'required|numeric',
        ];
        $validator = Validator::make($request->all(), $roles);
        if (!$validator->fails()) {
            $user = User::where("phone", $request->get('phone'))->first();
            if ($user) {
                $user = user::find($user->id);
              //  $user->code = SmsController::sendSmsCodeMessage($request->get('phone'), 3);
                $isSaved = $user->save();
                if ($isSaved) {
                    // return ControllersService::generateObjectSuccessResponseSMS($user->code, Messages::getMessage('AUTH_CODE_SENT'), $request->get('phone'));
                    // return $this->generateToken($user, 'LOGGED_IN_SUCCESSFULLY');
                     return response()->json(array(
            'status' => true), 200 );
                    
                }
            } elseif (!$user) {
                $user = new User();
                $user->phone = $request->get('phone');
             //   $user->code = SmsController::sendSmsCodeMessage($request->get('phone'), 3);
                $user->is_active = 0;
                $isSaved = $user->save();
                if ($isSaved) {
                    // return ControllersService::generateObjectSuccessResponseSMS($user->code, Messages::getMessage('AUTH_CODE_SENT'), $request->get('phone'));
                  //   return $this->generateToken($user, 'LOGGED_IN_SUCCESSFULLY');
                     return response()->json(array(
            'status' => true), 200 );
                }
            }
        } else {
            return ControllersService::generateValidationErrorMessage($validator->getMessageBag()->first());
        }
    }


    public function submitCode(Request $request)
    {
         $user = User::where("phone", $request->get('phone'))->first();
         if($user){
               $user->is_active = 1 ; 
            //    if($user->name == null){
            //         $user->memberCase = 'signup';
            //    }else{
            //          $user->memberCase = 'login';
            //    }
            //   $user->name = "name!" ; 
            //   $user->email = "email!" ; 
            //   $user->city_id = 1 ;
            //   $user->address = "adderss!" ;
            //   $user->uid = "1" ; 
               
               
               
               
         $user->save();
         return $this->generateToken($user, 'LOGGED_IN_SUCCESSFULLY');
         }
       
        // ارسال توكن
        // $roles = [
        //     'code' => 'required|numeric|digits:4',
        // ];
       // $validator = Validator::make($request->all(), $roles);
        // if (!$validator->fails()) {
            // $user = User::where("phone", $request->get('phone'))->first();
            // $name = $user->name;
         //   if ($name == null) {
                // if ($request->code == $user->code) {
                    // $user->is_active = 0;
                    // $user->memberCase = 'signup';
                    // $user->save();
                    // return $this->generateToken($user, 'LOGGED_IN_SUCCESSFULLY');
                    // return ControllersService::generateProcessResponse($user->id, 'Enter_USERNAME');
                // } else {
                //     return ControllersService::generateProcessResponse(false, 'ERROR_CREDENTIALS');
                // }
            // } else {
            //     if ($request->code == $user->code) {
            //         $user->is_active = 1;
            //         $user->memberCase = 'login';
            //         $user->save();
            //         $this->revokePreviousTokens($user->id);
            //         return $this->generateToken($user, 'LOGGED_IN_SUCCESSFULLY');
            //     } else {
            //         return ControllersService::generateProcessResponse(false, 'ERROR_CREDENTIALS');
            //     }
          //  }
        // } else {
        //     return ControllersService::generateValidationErrorMessage($validator->getMessageBag()->first());
        // }
    }
    public function changeName(Request $request)
    {

        $validator = Validator($request->all(), [
            'name' => 'required|string|unique:users,name',
        ], [
            'name.unique' => 'الإسم المدخل مستخدم مسبقا'
        ]);
        if (!$validator->fails()) {
            $user = User::find($request->user('user_api')->id);
            $user->name = $request->get('name');
            $user->memberCase = 'login';
            $user->is_active = 1;
            if ($user) {
                $isSaved = $user->save();
                if ($isSaved) {
                    return ControllersService::generateProcessResponse(true, 'CREATE_SUCCESS');
                } else {
                    return ControllersService::generateProcessResponse(false, 'ERROR_CREDENTIALS');
                }
            }
        } else {
            return response()->json([
                'message' => $validator->getMessageBag()->first(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }
    public function update(Request $request)
    {
        $userId = $request->user('user_api')->id;
        $roles = [
            'name' => 'required|string|min:3',
        ];
        $validator = Validator::make($request->all(), $roles);

        if (!$validator->fails()) {

            $user = User::find($request->user('user_api')->id);

            $user->name = $request->get('name');

            if(!empty($request->get('city_id'))){
                $user->city_id = $request->get('city_id');

            }
            if(!empty($request->get('address'))){
                $user->address = $request->get('address');

            }
            if(!empty($request->get('image'))){
                  $user->image = $request->get('image');
            }
          
            
            if ($user->is_promoted == 1) {
                // $user->about = $request->get('about');
            }
            if ($request->hasFile('photo')) {

                $path = Storage::disk('local')->put($request->file('photo')->getClientOriginalName(), $request->file('photo')->get());
                $path = $request->file('photo')->store('/website/users');

                $user->image = $path;
            }
            $isUpdated = $user->save();
            if ($isUpdated) {
                return ControllersService::generateObjectSuccessResponse($user, Messages::getMessage('USER_UPDATED_SUCCESS'));
            } else {
                return ControllersService::generateObjectSuccessResponse($user, Messages::getMessage('USER_UPDATED_FAILED'));
            }
        } else {
            return ControllersService::generateValidationErrorMessage($validator->getMessageBag()->first());
        }
    }
    public function uploadImage(Request $request)
        {
        
          
            
        //  $validator = Validator::make($request->all(), [
        //     'image' => 'required|image:jpeg,png,jpg,gif,svg'
        //  ]);
        //  if ($validator->fails()) {
        //     return response()->json([
        //         'error' => 'error',
        //         'user' => $msg ,
        //         'image' => $request->file('image')
        //         ]);
        //  }
          
         $uploadFolder = 'Users';
         $image = $request->file('image');
         $image_uploaded_path = $image->store($uploadFolder, 'public');
         $uploadedImageResponse = array(
            "image_name" => basename($image_uploaded_path),
            "image_url" => Storage::disk('public')->url($image_uploaded_path),
            "mime" => $image->getClientMimeType()
         );
          $user = User::find($request->user('user_api')->id);
            if($user){
                $msg = "user found ! "; 
                // $user->image = $image_uploaded_path; 
                // $user->save();
            }else{
                $msg = "user Not found ! "; 
            }
          
        return response()->json([
            'status' => true,
            'message' => 'Success',
            'image' => $image_uploaded_path,
            'user' => $msg 
          
        ]);
        }

    public function requestPasswordReset(Request $request)
    {
        $roles = [
            'mobile' => 'required|numeric|digits:9|exists:users,mobile',
        ];
        $validator = Validator::make($request->all(), $roles);

        if (!$validator->fails()) {
            $user = User::where("mobile", $request->get('mobile'))->first();
            if (!$user->password_reset_code) {
                $user->password_reset_code = Hash::make(1234);
                $isSaved = $user->save();
                return ControllersService::generateProcessResponse(true, $isSaved ? 'FORGET_PASSWORD_SUCCESS' : 'FORGET_PASSWORD_FAILED');
            } else {
                return ControllersService::generateProcessResponse(false, 'PASS_RESET_CODE_SENT_BEFORE');
            }
        } else {
            return ControllersService::generateValidationErrorMessage($validator->getMessageBag()->first());
        }
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string|password:user_api',
            'new_password' => 'required|string',
            'new_password_confirmation' => 'required|string|same:new_password'
        ], ['current_password.password' => 'Your current password is not correct']);
        $user = User::find($request->user('user_api')->id);
        $user->password = Hash::make($request->get('new_password'));
        $isSaved = $user->save();
        if ($isSaved) {
            return ControllersService::generateProcessResponse(true, 'CREATE_SUCCESS');
        } else {
            return ControllersService::generateProcessResponse(false, 'CREATE_FAILED');
        }
    }


    public function changephone(Request $request)
    {
        $userId = $request->user('user_api')->id;

        $request->validate([
            'phone' => 'required|numeric|unique:users,phone,' . $userId,
        ]);

        $user = User::find($request->user('user_api')->id);
        $user->phone = $request->get('phone');
        //$user->code = SmsController::sendSmsCodeMessage($request->get('phone'), 3);
        $user->is_active = 0;
        $isSaved = $user->save();
        if ($isSaved) {
            return ControllersService::generateObjectSuccessResponseSMS($user->code, Messages::getMessage('AUTH_CODE_SENT'), $request->get('phone'));
        } else {
            return ControllersService::generateProcessResponse(false, 'ERROR_CREDENTIALS');
        }
    }
    public function email(Request $request)
    {
        $userId = $request->user('user_api')->id;

        $request->validate([
            'email' => 'required|email|unique:users,email,' . $userId,
        ]);

        $user = User::find($request->user('user_api')->id);
        $user->email = $request->get('email');

        $isSaved = $user->save();
        if ($isSaved) {
            return ControllersService::generateProcessResponse(true, 'CREATE_SUCCESS');
        } else {
            return ControllersService::generateProcessResponse(false, 'CREATE_FAILED');
        }
    }

    public function test(Request $request)
    {
        $userId = $request->user('user_api')->id;
        $user = User::find($request->user('user_api')->id);
        $user->email = $request->get('email');
        $fcm_token = $user->fcm_token;
        $userNotificationController = new UserNotificationController();
        $userNotificationController->sendNotification('اهلا وسهلا بك في تطبيق حراج', 'text', 'متابعه', $fcm_token, $request->user('user_api')->id);
        return 'ok';
    }
    //     public function updateEmail(Request $request)
    // {
    //     $userId = $request->user('user_api')->id;

    //     $request->validate([
    //     'email' => 'required|email|unique:users,email,' . $userId,
    //      ]);

    //     $user = User::find($request->user('user_api')->id);
    //     $user->email = $request->get('email');

    //     $isSaved = $user->save();
    //  if ($isSaved) {
    //         return ControllersService::generateProcessResponse(true, 'CREATE_SUCCESS');
    //     } else {
    //         return ControllersService::generateProcessResponse(false, 'CREATE_FAILED');
    //     }


    // }
    public function userPromitProfile(Request $request)
    {
        $businessProduct = User::where('id', $request->get('id'))->with('promotedUser')->with('products')->get();
        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $businessProduct
        ]);
    }
    public function info(Request $request)
    {
        $userId = $request->user('user_api')->id;


        $user = User::find($request->user('user_api')->id);

        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $user
        ]);
    }
    public function userData($id)
    {
        $userId = $id;


        $user = User::find($userId);

        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $user
        ]);
    }
        public function fcmToken($id)
    {
       
        $user = User::find($id);
        
        return response()->json([
            'fcm_token' => $user->fcm_token
        ]);
    }
    
    private function generateToken($user, $message)
    {
        $tokenResult = $user->createToken('News-User');
        $token = $tokenResult->accessToken;
        $user->setAttribute('token', $token);
        return response()->json([
            'status' => true,
            'message' => Messages::getMessage($message),
            'object' => $user,
        ]);
    }
        public function CompletionRate(Request $request)
    {
        $userId = $request->user('user_api')->id;


        $user = User::find($request->user('user_api')->id);
        $rate =20 ; 
        if(!empty($user->name)){
            $rate+=20;
        }
          if(!empty($user->email)){
            $rate+=20;
        }
          if(!empty($user->image)){
            $rate+=20;
        }
          if(!empty($user->address)){
            $rate+=10;
        }
          if(!empty($user->city_id)){
            $rate+=10;
        }
        
        
        
        
        
        return response()->json([
             'rate' => $rate
          
        ]);
    }
    public function sendTech(Request $request){
        $user = User::find($request->user('user_api')->id);
        
                $roles = [
            'name' => 'required|string|min:3',
            'email' => 'required|string|min:3',
            'subject' => 'required|string',
            'message' => 'required|string|min:5',
            
           
        ];
                $validator = Validator::make($request->all(), $roles);

        if (!$validator->fails()) {
                    if(isset($user)){
             Tech::create([
                   'user_id'=>$user->id,
                   'parent_id'=>null,
                   'name'=>$request->get('name'),
                   'email'=>$request->get('email'),
                   'subject'=>$request->get('subject'),
                   'message'=>$request->get('message'),
                   ]);
                    return ControllersService::generateProcessResponse(true, 'CREATE_SUCCESS');
        }
        }
        else{
             return ControllersService::generateValidationErrorMessage($validator->getMessageBag()->first());
        }

       
    }
    
    public function chatImage(Request $request){
            
         $validator = Validator::make($request->all(), [
            // 'image' => 'required|image:jpeg,png,jpg,gif,svg'
         ]);
         if ($validator->fails()) {
            return response()->json([
                'error' => 'error',
                'user' => $msg ,
                'image' => $request->file('image')
                ]);
         }
          
         $uploadFolder = 'chat';
         $image = $request->file('image');
         $image_uploaded_path = $image->store($uploadFolder, 'public');
         $uploadedImageResponse = array(
            "image_name" => basename($image_uploaded_path),
            "image_url" => Storage::disk('public')->url($image_uploaded_path),
            "mime" => $image->getClientMimeType()
         );
          $user = User::find($request->user('user_api')->id);
            if($user){
                $msg = "user found ! "; 
                // $user->image = $image_uploaded_path; 
                // $user->save();
            }else{
                $msg = "user Not found ! "; 
            }
          
        return response()->json([
            'status' => true,
            'message' => 'Success',
            'image' => $image_uploaded_path,
            'user' => $msg 
          
        ]);
    }
    public function getStore(Request $request){
        $user = User::find($request->user('user_api')->id);
        $store = PromotedUser::where('user_id', $user->id)->first();
            return response()->json([
                'status' => true , 
                'message' => 'message here ', 
                'data'=> $store
                ]);
    }
    public function coverImage(Request $request){
    
            $validator = Validator::make($request->all(), [
            // 'image' => 'required|image:jpeg,png,jpg,gif,svg'
         ]);
         if ($validator->fails()) {
            return response()->json([
                'error' => 'error',
                'user' => $msg ,
                'image' => $request->file('image')
                ]);
         }
        $uploadFolder = 'website/users/covers';
        $image = $request->file('image');
        $image_uploaded_path = $image->store($uploadFolder, 'public');
        $uploadedImageResponse = array(
            "image_name" => basename($image_uploaded_path),
            "image_url" => Storage::disk('public')->url($image_uploaded_path),
            "mime" => $image->getClientMimeType()
         );
        $user = User::find($request->user('user_api')->id);
        $store = PromotedUser::where('user_id', $user->id)->first();
        $store->cover_image = $image_uploaded_path;
        $isSave = $store->save();
        if($isSave){
             return ControllersService::generateProcessResponse(true, 'CREATE_SUCCESS');
        }else{
             return ControllersService::generateProcessResponse(false, 'CREATE_FAILED');
        }
    }
    public function getProducts(Request $request){
         $user = User::find($request->user('user_api')->id);
         $products = Product::where('is_valid', 1)->where('user_id', $user->id)->orderBy('id','DESC')->get();
          return response()->json([
                'status' => true , 
                'message' => 'message here', 
                'data'=> $products
                ]);
         
    }
    public function saveFCMToken(Request $request){
         $user = User::find($request->user('user_api')->id);
         $user->fcm_token = $request->get('token');
         $saveUser = $user->save();
         if($saveUser){
             return ControllersService::generateProcessResponse(true, 'CREATE_SUCCESS');
        } else {
            return ControllersService::generateProcessResponse(false, 'CREATE_FAILED');
         }
        
    }
    
    public function demoGetStore(){
          $store = PromotedUser::where('user_id', 1496)->first();
        
        
            return response()->json([
                'status' => true , 
                'message' => 'message here ', 
                'data'=> $store
                ]);
        
        
    }
}
