<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\UserNotificationController;
use App\Models\Favorite;
use App\Models\Product;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\StopNotification;

class favoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showAllFavorits()
    {
        $favorite=[];
          $favorites = Favorite::where('user_id', Auth('user_api')->user()->id)->with('getProductsAttribute')->get();
      
     foreach ($favorites as $key => $value) {
    $favorite[$key]['id']     =  $value['getProductsAttribute'][0]['id'];
    $favorite[$key]['name']     =  $value['getProductsAttribute'][0]['name'];
    $favorite[$key]['image']     =  $value['getProductsAttribute'][0]['product_image'];

     }  
        
        
        $resonseData['favorite'] = $favorite;
        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $favorite
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
        // $roles=[
        //     'product_id' => 'required|string|unique:favorites,product_id,Null,product_id,user_id,' . Auth::user('user_api')->id,
        // ];
        // $validator = Validator::make($request->all(), $roles);
        // if (!$validator->fails()) {  
            
       
        $favort = Favorite::where('product_id',$request->product_id)->where('user_id',Auth::user()->id)->first();
         if(!empty($favort)){
             $favoriteDelete = Favorite::destroy($favort->id);
               if ($favoriteDelete) {
            return ControllersService::generateProcessResponse(true, 'DELETE_SUCCESS');
        } else {
            return ControllersService::generateProcessResponse(true, 'DELETE_FAILED');
        }
             
         }
           $product = Product::find($request->product_id);
        if(empty($product)){
        return ControllersService::generateProcessResponse(false, 'NOT_FOUND',404);
        }
        $id = $product->user_id;
        $product = Product::FindOrFAil(Auth::user()->id);
        $fcm_token = $product->fcm_token;
        $productRate = new Favorite();
        $productRate->product_id = $request->get('product_id');
        $productRate->user_id = Auth::user()->id;
            $IsSave = $productRate->save();
            
            $name =Auth::user()->name ;
            
         if($name =! null){
            $product = Auth::user()->name ;
            }else{
            $product = 'user';

            }
         
               $notficationStatus = StopNotification::where('sender',Auth::user()->id)->where('receiver',$id)->first();
              if (empty($notficationStatus) || $notficationStatus->status == 'Active') {
                $userNotificationController = new UserNotificationController();
                $userNotificationController->sendNotification('لقد تم متابعه اعلانك', $product, 'متابعه', $fcm_token, $id);
                return ControllersService::generateProcessResponse($IsSave, $IsSave ? 'CREATE_SUCCESS' : 'CREATE_FAILED');
            } else {
                return ControllersService::generateProcessResponse($IsSave, $IsSave ? 'CREATE_SUCCESS' : 'CREATE_FAILED');
            }
        // } 
        // else {
        //     return ControllersService::generateValidationErrorMessage($validator->getMessageBag()->first());
        // }
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
      $favort = Favorite::where('product_id',$id)->where('user_id',Auth::user()->id)->first();
         
         $favoriteDelete =  Favorite::destroy($favort->id);
        if ($favoriteDelete) {
            return ControllersService::generateProcessResponse(true, 'DELETE_SUCCESS');
        } else {
            return ControllersService::generateProcessResponse(true, 'DELETE_FAILED');
        }
    }
}
