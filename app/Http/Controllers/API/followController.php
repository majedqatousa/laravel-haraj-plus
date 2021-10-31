<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\follower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\User;

class followController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }
    public function follower($id)
    {
           $follow = [];
           $follows  = follower::where('user_followed', $id)->with('userfollower')->get();
        
        // // $user = $follows->pluck('user');
        // if($follows->user =! null ){
        
            foreach ($follows->pluck('userfollower') as $key => $value) {
                $follow[$key]['name']    =   $value->name;
                $follow[$key]['image']    =   $value->image;
                $follow[$key]['is_followed']   = $value->is_followed;
                $follow[$key]['user_id']   = $value->id;
                
            }
        

        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $follow
        ]);
    }
    public function following($id)
    {
        $follow = [];
        $follows  = follower::where('user_id', $id)->with('user')->get();

        // // $user = $follows->pluck('user');
        // if($follows->user =! null ){

        foreach ($follows->pluck('user') as $key => $value) {
            $follow[$key]['name']    =   $value->name;
            $follow[$key]['image']    =   $value->image;
            $follow[$key]['is_followed']   = $value->is_followed;
            $follow[$key]['user_id']   = $value->id;
        }


        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $follow
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function store(Request $request)
    {

          $roles=[
             'user_id' => 'required|string|unique:followers,user_followed,Null,user_followed,user_id,' . Auth::user('user_api')->id,
          ] ;


        $validator = Validator::make($request->all(), $roles);
        if (!$validator->fails()) {   
        $follow = new follower();
        $follow->user_id = Auth::user()->id;
        $follow->user_followed = $request->get('user_id');
        $isSaved = $follow->save();

         
            $userNotificationController = new UserNotificationController();
            // $userNotificationController->sendNotification('لقد تم متابعه اعلانك', Auth::user()->name, 'متابعه', $fcm_token, $id);
            return ControllersService::generateProcessResponse($isSaved, $isSaved ? 'CREATE_SUCCESS' : 'CREATE_FAILED');
        } else {
            return ControllersService::generateValidationErrorMessage($validator->getMessageBag()->first());
    }
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
    public function unFollow($id){
        $follow = follower::where('user_id' , Auth('user_api')->user()->id)->where('user_followed', $id)->first();
        $is_deleted = follower::destroy($follow->id);
        
        if ($is_deleted) {
            return ControllersService::generateProcessResponse(true, 'DELETE_SUCCESS');
        } else {
            return ControllersService::generateProcessResponse(true, 'DELETE_FAILED');
        }
        
    }
    public function follow(Request $request){
        
          $roles=[
             'user_id' => 'required|string|unique:followers,user_followed,Null,user_followed,user_id,'
          ] ;


        $validator = Validator::make($request->all(), $roles);
        if (!$validator->fails()) {   
        $follow = new follower();
        $follow->user_id = Auth('user_api')->user()->id;
        $follow->user_followed = $request->get('user_id');
        $isSaved = $follow->save();

         
            $userNotificationController = new UserNotificationController();
            $fcmNotification =  new UserFcmTokenController();
            $user = User::find($request->get('user_id'));
            $token = $user->fcm_token;
            $user_name = Auth('user_api')->user()->name;
         
            $body = 'متابعة جديدة من '.$user_name;
            if(!is_null($token)){
                 $fcmNotification->sendFCMNotification($token, 'متابعة جديدة' , $body);
               

            }
            $userNotificationController->sendNotification('لقد تم متابعه اعلانك',  $user_name, 'متابعه', $request->get('user_id'));
           
            return ControllersService::generateProcessResponse($isSaved, $isSaved ? 'CREATE_SUCCESS' : 'CREATE_FAILED');
        } else {
            return ControllersService::generateValidationErrorMessage($validator->getMessageBag()->first());
    }
    }
    public function isFollowed($id){
        $follow = follower::where('user_id' , Auth('user_api')->user()->id)->where('user_followed', $id)->first();
        if(is_null($follow)){
            return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => [
                'is_follow'=>false
                ]
                ]);
        }else{
              return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => [
                'is_follow'=>true
                ]
                ]);
        }
            
    }
        public function demoIsFollowed($id){
        $follow = follower::where('user_id' , 1496)->where('user_followed', $id)->first();
        if(is_null($follow)){
            return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => [
                'is_follow'=>false
                ]
                ]);
        }else{
              return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => [
                'is_follow'=>true
                ]
                ]);
        }
            
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $follow = follower::destroy($id);
        if ($follow) {
            return ControllersService::generateProcessResponse(true, 'DELETE_SUCCESS');
        } else {
            return ControllersService::generateProcessResponse(true, 'DELETE_FAILED');
        }

    }
}
