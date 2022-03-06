<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PromotedUser;
use App\User;
use App\Http\Controllers\API\UserNotificationController;
use App\Http\Controllers\API\UserFcmTokenController;
use App\Notifications\orderActionNotification;
use App\Notifications\MailNotification;

class StoreController extends Controller
{
    //
    public function index(){
        $stores = PromotedUser::wherehas('user', function ($q) {
            $q->where('is_active', 1)->where('is_promoted', 1);
        })->where("is_active", 0)->orderBy('created_at','desc')->get();
        $count = $stores->count();
        return view('admin.stores.index',compact('stores', 'count') );
    }

    public function updateAllStores(){
        $stores = PromotedUser::all();
        foreach($stores as $store){
            $store->is_active =0;
            $store->save();
        }

    }
     public function StoreActivate($id)
    {
        $store = PromotedUser::findOrFail($id);
        $store->is_active =1;
        $store->save();

        $user = User::findOrFail($store->user_id);

        $details=[
            'type'=>'store',
            'message'=>'تم الموافقة على المتجر الخاص بك',
            'image'=> 'settings/logo.png'
        ];
        $userNotificationController = new UserNotificationController();
        $fcmNotification =  new UserFcmTokenController();
       
        $notification_title = "قبول متجرك";
        $notification_subTitle = "المتجر";
        $notification_body = "تم الموافقة على المتجر الخاص بك";
        
        $userNotificationController->sendNotification($notification_body,  $notification_title, $notification_subTitle, $user->id);
        $token = $user->fcm_token;
        if(!is_null($token)){
            $fcmNotification->sendFCMNotification($token, $notification_title , $notification_body);
       }

        \Notification::send($user, new orderActionNotification($details));
        \Notification::send($user,new MailNotification(['line'=> $details['message'],'url'=>'https://haraj-plus.co','url_text'=>' الذهاب للموقع']));

        session()->flash('success', 'تم التفعيل بنجاح');
        return redirect()->back();

    }
    public function StoreDelete($id)
    {
        $store = PromotedUser::findOrFail($id);
        $store->delete();
        $user = User::findOrFail($store->user_id);


        $details=[
            'type'=>'payment','message'=>"يؤسفنا لا يمكن قبول متجرك $store->name  لتعارضه من سياسات حراج بلص",
            'image'=> 'settings/logo.png'
        ];
        $userNotificationController = new UserNotificationController();
        $fcmNotification =  new UserFcmTokenController();
       
        $notification_title = "رفض المتجر";
        $notification_subTitle = "المتجر";
        $notification_body = "يؤسفنا لا يمكن قبول متجرك";
        
        $userNotificationController->sendNotification($notification_body,  $notification_title, $notification_subTitle, $user->id);
        $token = $user->fcm_token;
        if(!is_null($token)){
            $fcmNotification->sendFCMNotification($token, $notification_title , $notification_body);
       }
        \Notification::send($user, new orderActionNotification($details));
        \Notification::send($user,new MailNotification(['line'=> $details['message'],'url'=>'https://haraj-plus.co','url_text'=>' الذهاب للموقع']));


       
        session()->flash('success', 'تم حذف المنتج بنجاح');


        return redirect()->back();
    }
}
