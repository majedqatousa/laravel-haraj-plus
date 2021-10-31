<?php

namespace App\Http\Controllers\API;
 
 use App\Http\Controllers\API\UserFcmTokenController;
use App\Http\Controllers\Controller;
use App\User;
use App\UserNotification ;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
class UserNotificationController extends Controller
{
    //
    private $fcmController;

    function __construct()
    {
        $this->fcmController = new UserFcmTokenController();
    }
       public function notification(){
          
        $notfiy = UserNotification::where('user_id', Auth::user()->id)->get();
        
        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $notfiy
        ]);
    }   
    public function delete($id)
    {
         
        $notfiyDelete = UserNotification::destroy($id);
        if ($notfiyDelete) {
            return ControllersService::generateProcessResponse(true, 'DELETE_SUCCESS');
        } else {
            return ControllersService::generateProcessResponse(true, 'DELETE_FAILED');
        }
    } 
    public function sendNotificationForAdmins($body, $title, $sub_title)
    {
        $User = User::whereNotNull('fcm_token')->get(['id', 'fcm_token']);

        $tokens = array();
        $userNotifications = array();
        foreach ($User as $user) {
            $tokens[] = $user->fcm_token;

            $sentNotification = [
                'user_id' => $user->id,
                'body' => $body,
                'title' => $title,
                'sub_title' => $sub_title,
                'type' => "General",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
            array_push($userNotifications, $sentNotification);
        }

        $result = $this->fcmController->sendNotification(
            $tokens,
            $body,
            $title,
            $sub_title
        );

        if ($result) {
           return UserNotification::insert($userNotifications);
        } else {
          return false;
        }
    }

    public function sendNotification($body, $title, $sub_title, $id)
    {
          $sentNotification = [
            'user_id' => $id,
            'body' => $body,
            'title' => $title,
            'sub_title' => $sub_title,
            'type' => "Direct",
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
        
       $userNotification = new UserNotification();
      $userNotification->user_id = $id; 
      $userNotification->body = $body; 
      $userNotification->title = $title; 
      $userNotification->sub_title = $sub_title; 
      $userNotification->type = 'Direct'; 
      $userNotification->created_at = Carbon::now();
      $userNotification->updated_at = Carbon::now();
       
            
       
      return  $userNotification->save();
       

     
    }
}
