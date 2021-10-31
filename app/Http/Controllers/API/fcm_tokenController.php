<?php

namespace App\Http\Controllers\API;

use App\admin;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\ControllersService;
use App\supplier;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\StopNotification;

class fcm_tokenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function updateFcm_token(Request $request)
    {
        $request->validate([
            'fcm_token' => 'required|string'
        ]);
        $user = null;
        if (Auth::guard('user_api')->check()) {
            // $user = User::find($request->user('user_api')->id);
         $user = $request->user('user_api');
         }
        $user->fcm_token = $request->get('fcm_token');
        $IsSave =  $user->save();
        return ControllersService::generateProcessResponse($IsSave, $IsSave ? 'CREATE_SUCCESS' : 'CREATE_FAILED');
    }
 public function stopNotification(Request $request)
    {
        $roles = [
            'receiver' => 'required',
            'status' => 'required',

        ];
        $validator = Validator::make($request->all(), $roles);
        if (!$validator->fails()) {
            $StopNotification = new StopNotification();
            $StopNotification->sender =  Auth::user()->id;;
            $StopNotification->receiver = $request->get('receiver');
            $StopNotification->status = $request->get('status');
            $IsSave = $StopNotification->save();
            return ControllersService::generateProcessResponse($IsSave, $IsSave ? 'CREATE_SUCCESS' : 'CREATE_FAILED');
        } else {
            return ControllersService::generateValidationErrorMessage($validator->getMessageBag()->first());
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
