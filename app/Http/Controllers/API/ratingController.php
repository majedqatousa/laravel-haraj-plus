<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DeactivateUser;
use App\Models\Rating;
use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ratingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
     
    }
    public function indexRat($id)
    {
        $rate = Rating::where('product_id', $id)->get();
        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $rate
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
        
        if ($deactivated = User::where('id', auth()->id())->where('type', 1)->first()) {
         
                return response()->json(['msg' => 'انت محظور من التعليق  ):']);
        }

        $roles = [
            'degree' => 'required',
            'comment' => 'required',

        ];
        $validator = Validator::make($request->all(), $roles);

        if (!$validator->fails()) {
            $productRate = new Rating();
            $productRate->degree = $request->get('degree');
            $productRate->comment = $request->get('comment');
            $productRate->product_id = $request->get('product_id');
            $productRate->user_id = Auth::user()->id;
            $isUpdated = $productRate->save();
            if ($isUpdated) {
                return ControllersService::generateProcessResponse(true, 'CREATE_SUCCESS');
            } else {
                return ControllersService::generateProcessResponse(false, 'CREATE_FAILED');
            }
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
        $roles = [
            'degree' => 'required',
            'comment' => 'required',

        ];
        $validator = Validator::make($request->all(), $roles);

        if (!$validator->fails()) {
            $productRate =  Rating::findOrFail($id);
             $productRate->degree = $request->get('degree');
            $productRate->comment = $request->get('comment');
             $productRate->user_id = Auth::user()->id;
            $isUpdated = $productRate->save();
            if ($isUpdated) {
                return ControllersService::generateProcessResponse(true, 'UPDATE_SUCCESS');
            } else {
                return ControllersService::generateProcessResponse(true, 'UPDATE_FAILED');
            }
        } else {
            return ControllersService::generateValidationErrorMessage($validator->getMessageBag()->first());
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
         $rateDelete =  Rating::destroy($id);
        if ($rateDelete) {
            return ControllersService::generateProcessResponse(true, 'DELETE_SUCCESS');
        } else {
            return ControllersService::generateProcessResponse(true, 'DELETE_FAILED');
        }
    }
}
