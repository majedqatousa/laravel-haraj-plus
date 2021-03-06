<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\UserFcmTokenController;


class NotificationController extends Controller
{
    //
    public function index(){
        return view('admin.notifications.index');
    }
    public function send(Request $request){
        $fcmNotification = new UserFcmTokenController();
        $fcmNotification->sendToAll($request->get('title') , $request->get('body'));
        session()->flash('notification-status', ' تم إرسال الإشعار بنجاح');
        return redirect()->back();
    }
}
