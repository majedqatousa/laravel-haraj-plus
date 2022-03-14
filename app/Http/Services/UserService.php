<?php

namespace App\Http\Services;
use App\User;
use App\Http\Repositories\MainReopsitory;

use App\Classes\FileOperations;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserService {
    private $imageDirectory = 'Users';

    public function __construct(User $user){


        $this->repo = new MainReopsitory($user);
    }

    public function storeUser(Request $request){
//        dd($request->all());
        $requestData = $request->all();
        $user = User::where('phone',format_number($requestData['phone']))->count();
        if($user >0){
            return null;
        }else{
            $code = rand ( 1000 , 9999 );
            $requestData['code'] = $code;
            $requestData['password'] = bcrypt($request->password);
            if($request->hasFile('image')){
                $pathAfterUpload = FileOperations::StoreFileAs($this->imageDirectory, $request->image, str::random(8));
                $requestData['image'] = $pathAfterUpload;
            }
            $requestData['phone']=format_number($requestData['phone']);
            $userInfo= $this->repo->store($requestData);
            // $message = "كود التفعيل الخاص بك فى موقع حراج بلص هو".$code;
            return $userInfo;
        }
      
        // sendSMS($user->phone, $message);



//    try{

//  $basic  = new \Nexmo\Client\Credentials\Basic('f33391ef', 'RsZTg3zZqnOv1ZV1');
//         $client = new \Nexmo\Client($basic);

//         $message = $client->message()->send([
//                 'to' => $user->phone,
//                 'from' => 'haraj plus',
//                 'type' => 'unicode',
//                 'text' => "كود التفعيل الخاص بك فى موقع حراج بلص هو ".$user->code,

//             ]
//         );

        // }catch (\Exception $e){
        //    session()->flash('failed','رقم الهاتف غير صالح يرجى التاكد منه');
        // }

      

    }//end store user




    public function getUsers(){
        return $this->repo->getall();
    }
    public function getUser($id){
        return $this->repo->get($id);
    }

    public function updateUser($id, Request $request){
        $user = $this->repo->get($id);
        $requestData = $request->all();
        if($request->hasFile('image')){
            Storage::delete($user->image);
            $pathAfterUpload = FileOperations::StoreFileAs($this->imageDirectory, $request->image, str::random(8));
            $requestData['image'] = $pathAfterUpload;
        }
        if($request->password == null )
            $requestData['password']=$user->password;

          else
            $requestData['password'] = bcrypt($request->password);



        $this->repo->update($id, $requestData);

    }










    public function deleteUser($id){
        $User = $this->repo->get($id);
        $User->promotedUser->delete();
        $User->products->delete();
        if($User->image!=null)
        Storage::delete($User->image);

        $this->repo->delete($id);

    }


}
