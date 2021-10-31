<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DeactivateUser;
use App\Models\Report;
use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class reportController extends Controller{
    
     public function store(Request $request)
    {
        
      
        $roles = [
            'body' => 'required',

        ];
        $validator = Validator::make($request->all(), $roles);

        if (!$validator->fails()) {
            $productReport = new Report();
            $productReport->body = $request->get('body');
            $productReport->product_id = $request->get('product_id');
            $productReport->user_id = Auth::user()->id;
            $isUpdated = $productReport->save();
            if ($isUpdated) {
                return ControllersService::generateProcessResponse(true, 'CREATE_SUCCESS');
            } else {
                return ControllersService::generateProcessResponse(false, 'CREATE_FAILED');
            }
        } else {
            return ControllersService::generateValidationErrorMessage($validator->getMessageBag()->first());
        }
    }

    
}
