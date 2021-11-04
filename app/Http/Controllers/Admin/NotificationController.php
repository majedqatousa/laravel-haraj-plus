<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    //
    public function index(){
        return view('admin.notifications.index');
    }
    public function send(){
        return "done "; 
    }
}
