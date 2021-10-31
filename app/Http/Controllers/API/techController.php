<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DeactivateUser;
use App\Models\Tech;
use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class techController extends Controller{
    
    public function showTech($id){
        $tech = Tech::where('parent_id', $id)->first();
        
        if(is_null($tech)){
            return response()->json([
            'status' => false,
            'message' => 'No replay',
            'replay' => 'no replay'
        ]);
        }else{
            return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $tech
        ]);
       
    }
    }
    public function allTechs(Request $request){
        $techs = Tech::where('user_id' , $request->user('user_api')->id)->get();
        
        $userTechs = [] ;
           foreach ($techs as $key => $value) {
                 $userTechs[$key]['id'] = $value->id;
                 $userTechs[$key]['subject'] = $value->subject;
                 $userTechs[$key]['message'] = $value->message;
                 $userTechs[$key]['name'] = $value->name;
                 
           }
             return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $userTechs
        ]);
        
        
    }
    
}
