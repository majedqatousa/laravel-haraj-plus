<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;


class UserFcmTokenController extends Controller
{
    /**
     * Functionality to send notification.
     *
     */
    // public function sendNotification(Request $request, $body, $title, $subTitle)
    // {
        
    //     $responseData = [];

    //     define('FCM_SERVER_KEY', 'AAAA287mePc:APA91bEJGib5PcrdI2pfSR8uz24kZ0QkEgzXo6EwBClrU9yU-ZowTrVfhlrNWpmcsLzokcSNn6tNjL1MXixqwSqeX_bomV_5ZLaXX73SnzJka27ny43xB49-nBunVx2aZSNyZssMdr7i');
    //     $msg = array
    //     (
    //         'body' => $body,
    //         'title' => $title,
    //         'subtitle' => $subTitle,
    //         "sound" => 'Default',
    //         "android_channel_id"=> "Haraj_plus_notification_channel"
    //     );
    //     $android = array(
    //         "notification" => array(
    //             "color" => '#ff0000',
    //             "sound" => 'Default',
    //             "channel_id" => 'Haraj_plus_notification_channel'
    //         )
    //     );
    //     $fields = array
    //     (
    //         'registration_ids' => $request->get('token'),
    //         'notification' => $msg,
    //         'android' => $android,
    //     );
    //     $headers = array
    //     (
    //         'Authorization: key=' . FCM_SERVER_KEY,
    //         'Content-Type: application/json'
    //     );
    //     $ch = curl_init();
      
    //     curl_setopt($ch, CURLOPT_URL, $url);
    //     curl_setopt($ch, CURLOPT_POST, true);
    //     curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    //     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    //      $result = curl_exec($ch);
    //     if ($result === FALSE) {
    //         curl_close($ch);
    //         return 'Oops! FCM Send Error: ' . curl_error($ch);
    //     } else {
    //         curl_close($ch);
    //         return $result;
    //     }
      //  return true;

        // for IOS
 // if ($FCMTokenData = $this->fcmToken->whereIn('user_id', $users)->where('apns_id', '!=', null)->select('apns_id')->get()) {
        //     foreach ($FCMTokenData as $key => $value) {
        //         $apns_ids[] = $value->apns_id;
        //     }
        //     $url = "https://fcm.googleapis.com/fcm/send";
        //     $serverKey = 'FCM_SERVER_KEY';
        //     $title = "Thsi is title";
        //     $body = 'This is body';
        //     $notification = array(
        //         'title' => $title,
        //         'text' => $body,
        //         'sound' => 'default',
        //         'badge' => '1'
        //     );
        //     $arrayToSend =
        //         array(
        //             'registration_ids' => $apns_ids,
        //             'notification' => $notification,
        //             'priority' => 'high'
        //         );
        //     $json = json_encode($arrayToSend);
        //     $headers = array();
        //     $headers[] = 'Content-Type: application/json';
        //     $headers[] = 'Authorization: key=' . $serverKey;
        //     $ch = curl_init();
        //     curl_setopt($ch, CURLOPT_URL, $url);
        //     curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        //     curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        //     curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        //     //Send the request
        //     $result = curl_exec($ch);
        //     if ($result === FALSE) {
        //         die('FCM Send Error: ' . curl_error($ch));
        //     }
        //     $result = json_decode($result, true);
        //     $responseData['ios'] = [
        //         "result" => $result
        //     ];

        //     //Close request
        //     curl_close($ch);
        // }
       
    // }
    
        public function sendTestNotification($tokens)
    {
       $token = $tokens;
        $title = "Test";
        $body= "Test";


        $server_key = 'AAAA287mePc:APA91bEJGib5PcrdI2pfSR8uz24kZ0QkEgzXo6EwBClrU9yU-ZowTrVfhlrNWpmcsLzokcSNn6tNjL1MXixqwSqeX_bomV_5ZLaXX73SnzJka27ny43xB49-nBunVx2aZSNyZssMdr7i';

        $json_data = [
            "to" => $token,
            "priority"=>"high",
            "notification" => [
                "title" => $title,
                "body" => $body,
            ],
            /*  "data" => [
                  'key'=>'value'
              ]*/
        ];
        $data = json_encode($json_data);

        $url = 'https://fcm.googleapis.com/fcm/send';
        $headers = array(
            'Content-Type:application/json',
            'Authorization:key=' . $server_key
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($ch);
        if ($result === FALSE) {
            curl_close($ch);
            return 'Oops! FCM Send Error: ' . curl_error($ch);
        } else {
            curl_close($ch);
            return $result;
        }
    }
     public static function sendFCMNotification($token, $title, $body)
    {
       $token = $token;
       

        $server_key = 'AAAA287mePc:APA91bEJGib5PcrdI2pfSR8uz24kZ0QkEgzXo6EwBClrU9yU-ZowTrVfhlrNWpmcsLzokcSNn6tNjL1MXixqwSqeX_bomV_5ZLaXX73SnzJka27ny43xB49-nBunVx2aZSNyZssMdr7i';

        $json_data = [
            "to" => $token,
            "priority"=>"high",
            "notification" => [
                "title" => $title,
                "body" => $body,
            ],
            /*  "data" => [
                  'key'=>'value'
              ]*/
        ];
        $data = json_encode($json_data);

        $url = 'https://fcm.googleapis.com/fcm/send';
        $headers = array(
            'Content-Type:application/json',
            'Authorization:key=' . $server_key
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($ch);
        if ($result === FALSE) {
            curl_close($ch);
            return 'Oops! FCM Send Error: ' . curl_error($ch);
        } else {
            curl_close($ch);
            return $result;
        }
    }
    public function sendToAll($title , $body){
        $users = User::whereNotNull('fcm_token')->get();
        foreach ($users as $user) {
            self::sendFCMNotification($user->fcm_token  ,  $title ,  $body);
        }
        
    }
}
