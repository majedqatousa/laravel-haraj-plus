<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\City;
use App\Models\DeactivateUser;
use App\Models\Image;
use App\Models\Product;
use App\Models\Rating;
use App\Models\Report;
use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PromotedUser;

// use App\Models\Image;
class productController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Product::where('user_id', Auth('user_api')->user()->id)->get();
        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $product
        ]);
    }
    public function myAds()
    {
        $products = Product::where('user_id', Auth('user_api')->user()->id)->get();
        $product = [];
        foreach ($products as $key => $value) {
            $product[$key]['id']    =   $value->id;
            $product[$key]['name']    =   $value->name;
            $product[$key]['main_image']    =   url("storage/{$value->main_image}");
            $product[$key]['status']    =   $value->status == 1 ? 'active' : 'deactive';
            $product[$key]['created_at']   = $value->created_at;
            $product[$key]['price']   = $value->price;
            $product[$key]['description']   = $value->description;
            $product[$key]['city_id']   = $value->city_id;
            $product[$key]['status']   = $value->status;
            
            $product[$key]['discount_ratio']   = $value->discount_ratio;
            $product[$key]['is_valid']   = $value->is_valid;
            
               

            
            
            // $favorite[$key]['is_favorite']   = $value->is_joined;
        }
        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $product
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

        $promoted = User::where('id',  Auth('user_api')->user()->id)->first();
        $value = $promoted->is_promoted;
        $product_per_month = Product::where('user_id',  Auth('user_api')->user()->id)->whereMonth('created_at', date('m'))->get();
        if(is_null($promoted)){
            return ControllersService::generateProcessResponse(false, 'user error');
        }else{

        $roles = [
            'name' => 'required',
            'status' => 'required',
            'price' => 'required|max:11',
            'city_id' => 'required',
            'category_id' => 'required',
            "main_image" => 'required',
            'is_checked' => 'required',
            'description' => 'required|max:15000',
        ];

        $validator = Validator::make($request->all(), $roles);
        if (!$validator->fails()) {

            $product = new Product();
            $product->name = $request->get('name');
            $product->price = $request->get('price');
            $product->category_id = $request->get('category_id');
            $product->description = $request->get('description');
            $product->main_image = $request->get('main_image');
            $product->city_id = $request->get('city_id');
            $product->discount_ratio = $request->get('discount_ratio');
            $product->status = $request->get('status');
            $product->user_id =  Auth('user_api')->user()->id;
            $product->user_promoted = $value;
            $product->is_valid = 3;
            $product->video = $request->get('video');
            $product->is_checked = $request->get('is_checked');
            $isSaved = $product->save();
            if ($isSaved) {
                return response()->json([
                    'code' => 200,
                    'product_id' => $product->id
                    ]);
                    
                   
            }
            else{
                     
                return ControllersService::generateProcessResponse(false, 'CREATE_FAILED');
            }
                
            
            // if (count($product_per_month) == 7 && $value == 0) {
            //     return ControllersService::generateProcessResponse(false, 'Faild_store');
            // } else {
            //     $isSaved = $product->save();
            //     if ($isSaved) {

            //       //  $isImagesSaved = $this->saveStoreImages($product, $request);

            //         if ($isImagesSaved) {
            //             return ControllersService::generateProcessResponse(true, 'CREATE_SUCCESS');
            //         } else {
            //             // delete product if images  not saved
            //             //$product->delete();
            //             return ControllersService::generateProcessResponse(false, 'CREATE_FAILED');
            //         }
            //     }
            // }
        } else {
            return ControllersService::generateValidationErrorMessage($validator->getMessageBag()->first());
        }
        }
    }
    public function demoStore(Request $request){
         $promoted = User::where('id', $request->get('user_id') )->first();
        $value = $promoted->is_promoted;
        $product_per_month = Product::where('user_id', $request->get('user_id'))->whereMonth('created_at', date('m'))->get();
           $roles = [
            'name' => 'required',
            'status' => 'required',
            'price' => 'required|max:11',
            'city_id' => 'required',
            //'category_id' => 'required',
            "main_image" => 'required',
            'is_checked' => 'required',
            'description' => 'required|max:15000',
        ];
        $validator = Validator::make($request->all(), $roles);
        
         if (!$validator->fails()) {

            $product = new Product();
            $product->name = $request->get('name');
            $product->price = $request->get('price');
            $product->category_id = 52;
            $product->description = $request->get('description');
            $product->main_image = $request->get('main_image');
            $product->city_id = $request->get('city_id');
            //$product->discount_ratio = $request->get('discount_ratio');
            $product->status = $request->get('status');
            $product->user_id =   $request->get('user_id');
            $product->discount_ratio = $request->get('discount');
            $product->user_promoted = $value;
            $product->is_valid = 3;
            $product->video = $request->get('video');
            $product->is_checked = $request->get('is_checked');
            $isSaved = $product->save();
            if ($isSaved) {
                return ControllersService::generateProcessResponse(true, 'CREATE_SUCCESS');
            }
            else{
                     
                return ControllersService::generateProcessResponse(false, 'CREATE_FAILED');
            }
                
            
            // if (count($product_per_month) == 7 && $value == 0) {
            //     return ControllersService::generateProcessResponse(false, 'Faild_store');
            // } else {
            //     $isSaved = $product->save();
            //     if ($isSaved) {

            //       //  $isImagesSaved = $this->saveStoreImages($product, $request);

            //         if ($isImagesSaved) {
            //             return ControllersService::generateProcessResponse(true, 'CREATE_SUCCESS');
            //         } else {
            //             // delete product if images  not saved
            //             //$product->delete();
            //             return ControllersService::generateProcessResponse(false, 'CREATE_FAILED');
            //         }
            //     }
            // }
        } else {
            return ControllersService::generateValidationErrorMessage($validator->getMessageBag()->first());
        }
        
        
        
    }
    public function CreateValidat()
    {
        $promoted = User::where('id', Auth::user()->id)->first();
        $value = $promoted->is_promoted;
        $product_per_month = Product::where('user_id', auth()->user()->id)->whereMonth('created_at', date('m'))->get();
        if (count($product_per_month) == 7 && $value == 0) {
            return ControllersService::generateProcessResponse(true, 'Faild_store');
        } else {
            return ControllersService::generateProcessResponse(true, 'SUCCESS_store');
        }
    }
    private function saveStoreImages(Product $product, Request $request)
    {
        $storeImage = new Image();
        $storeImage = [];
      //  if ($request->hasFile('product_image')) {
            foreach ($request->get('product_image') as $image) {
                // $imageName = $file->getClientOriginalName();
                // $imageName = 'public' . '_' . time() . '.' . $imageName;
                // $file->move('images/product', $imageName);

                $storeImage[] = ['path' =>  $image, 'product_id' => $product->id];
            }
       // }
        return  Image::query()->insert($storeImage);
    }
    public function storeProductImages(Request $request){
        $image = new Image(); 
        $image->path = $request->get('image');
        $image->product_id = $request->get('product_id');
        $save = $image->save();
        if($save){
         return ControllersService::generateProcessResponse(true, 'CREATE_SUCCESS');
                    } else {
                       
                        return ControllersService::generateProcessResponse(false, 'CREATE_FAILED');
                    }
        
        
    }

    public function showProduct($id)
    {
        $product = Product::where('id', $id)->with('city')->first();
        $user_id = $product->user_id;
        $user =     user::find($user_id);
        $city_name = City::find($product->city_id)->name;

        if ($user->name == null) {
            return ControllersService::generateProcessResponse(false, 'NOT_FOUND', 404);
        }
        $resonseData['product_id']   = $product->id;
        $resonseData['product_name'] = $product->name;
        $resonseData['product_price'] = $product->price;
        $resonseData['product_status'] = $product->status;
        $resonseData['product_description'] = $product->description;
        $resonseData['city'] =  $city_name;
        $resonseData['city_id'] = $product->city_id;
        $resonseData['phone'] = $product->user->phone;
        $resonseData['userfavorit'] = $product->userfavorit->count();
        $resonseData['discount_ratio'] = $product->discount_ratio;
       
            $resonseData['video'] = $product->video;
        

        if ($product->main_image != null) {
            $resonseData['product_image']   = url('storage/' . $product->main_image);
        }
        $productImages = Image::where('product_id', $id)->get();
        foreach ($productImages->pluck('path') as $key => $image) {
            $resonseData['product_images'][$key] = url('storage/' . $image);
        }
        
            $resonseData['company_name'] = $product->company_name;
        
        $resonseData['is_favorite']   = $product->is_joined;

        $rate = Rating::where('product_id', $id)->with('user')->get();
        if (count($rate) == 0) {
            $resonseData['rate'] = [];
        } else {
            foreach ($rate as $key => $value) {
                $resonseData['rate'][$key]['id']     =      $value->id;
                $resonseData['rate'][$key]['degree']     = $value->degree;
                $resonseData['rate'][$key]['comment']     = $value->comment;
                $resonseData['rate'][$key]['Name']     = $value->user->name;
                $resonseData['rate'][$key]['userImage']     =url('storage/'. $value->user->image);
                $resonseData['rate'][$key]['created_at']     = $value->created_at;
                $resonseData['rate'][$key]['updated_at']     = $value->updated_at;
                $resonseData['rate'][$key]['is_reported']     = $value->is_reported;
            }
        }

        $sub_category = $product->category_id;


        $ads = Product::where('category_id', $sub_category)->where('is_valid',1)->orderBy('created_at', 'DESC')->paginate(10);
        foreach ($ads as $key => $value) {
            $resonseData['ads'][$key]['product_id']   = $value->id;
            $resonseData['ads'][$key]['sub_category']   = $sub_category;
            $resonseData['ads'][$key]['product_name'] = $value->name;
            $resonseData['ads'][$key]['product_price'] = $value->price;
            $resonseData['ads'][$key]['product_description'] = $value->description;
            $resonseData['ads'][$key]['product_image']   = url('storage/'.$value->main_image);
            $resonseData['ads'][$key]['is_favorite']   = $value->is_joined;
            $resonseData['ads'][$key]['company_name']   = $value->company_name;
            
        }
        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $resonseData
        ]);
    }

    public function productStatusActive($id, $type = '1')
    {
        $product = Product::findOrFail($id);
        //حالة المنتج مفعل
        $product->is_valid = $type;
        $isUpdated = $product->save();
        if ($isUpdated) {
            return ControllersService::generateProcessResponse(true, 'UPDATE_SUCCESS');
        } else {
            return ControllersService::generateProcessResponse(true, 'UPDATE_FAILED');
        }
    }
        public function productStatusDeActive($id, $type = '0')
    {
        $product = Product::findOrFail($id);
        //حالة المنتج مفعل
        $product->is_valid = $type;
        $isUpdated = $product->save();
        if ($isUpdated) {
            return ControllersService::generateProcessResponse(true, 'UPDATE_SUCCESS');
        } else {
            return ControllersService::generateProcessResponse(true, 'UPDATE_FAILED');
        }
    }

    public function reportProduct(Request $request, $id)
    {
        if ($deactivated = User::where('id', auth()->id())->where('type', 1)->first()) {

            return response()->json(['msg' => 'انت محظور من الابلاغ  ):']);
        }

        $roles = [
            'body' => 'required',

        ];
        $validator = Validator::make($request->all(), $roles);

        if (!$validator->fails()) {
            $productRate = new Report();
            $productRate->body = $request->get('body');
            $productRate->product_id = $id;
            $productRate->user_id = Auth::user()->id;
            $isUpdated = $productRate->save();
            if ($isUpdated) {
                return ControllersService::generateProcessResponse(true, 'CREATE_SUCCESS');
            } else {
                return ControllersService::generateProcessResponse(true, 'CREATE_FAILED');
            }
        } else {
            return ControllersService::generateValidationErrorMessage($validator->getMessageBag()->first());
        }
    }
    public function reportComment(Request $request, $id)
    {
        if ($deactivated = User::where('id', auth()->id())->where('type', 1)->first()) {

            return response()->json(['msg' => 'انت محظور من الابلاغ  ):']);
        }

        $roles = [
            'body' => 'required',

        ];
        $validator = Validator::make($request->all(), $roles);

        if (!$validator->fails()) {
            $productRate = new Report();
            $productRate->body = $request->get('body');
            $productRate->rate_id = $id;
            $productRate->user_id = Auth::user()->id;
            $isUpdated = $productRate->save();
            if ($isUpdated) {
                return ControllersService::generateProcessResponse(true, 'CREATE_SUCCESS');
            } else {
                return ControllersService::generateProcessResponse(true, 'CREATE_FAILED');
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
        $product = Product::where('id', $id)->where('is_valid', 1)->get();
        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $product
        ]);
    }
    public function cityIndex()
    {
        $city = City::all();
        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $city
        ]);
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
        $promoted = User::where('id', Auth::user()->id)->first();
        $value = $promoted->is_promoted;
        $roles = [
            'name' => 'required',
          //  'status' => 'required',
            'price' => 'required|max:11',
            'description' => 'required|max:15000',
            'city_id' => 'required',
          //  'discount_ratio' => 'required'
            
        ];
        $validator = Validator::make($request->all(), $roles);

        if (!$validator->fails()) {
            $productEdit = product::findOrFAil($id);
            $productEdit->name = $request->get('name');
            $productEdit->price = $request->get('price');
          //  $productEdit->category_id = $request->get('category_id');
            $productEdit->description = $request->get('description');
            if(!empty($request->get('mainImage'))){
                 $productEdit->main_image = $request->get('mainImage');
            }
            $productEdit->city_id = $request->get('city_id');
             if(!empty( $request->get('discount_ratio'))){
                 $productEdit->discount_ratio = $request->get('discount_ratio');
             }
           if(!empty( $request->get('status'))){
                $productEdit->status = $request->get('status');
           }
           
          
            // $productEdit->user_promoted = $value;
            // is_valid == حالة المنتج مفعل ام معطل
            // $productEdit->is_valid = 3;
            // $productEdit->video = $request->get('video');
            // $productEdit->is_checked = $request->get('is_checked');
            $isUpdated = $productEdit->save();
            if ($isUpdated) {
               // $isImagesSaved = $this->saveStoreImages($productEdit, $request);
                return ControllersService::generateProcessResponse(true, 'UPDATE_SUCCESS');
            } else {
                return ControllersService::generateProcessResponse(true, 'UPDATE_FAILED');
            }
        } else {
            return ControllersService::generateValidationErrorMessage($validator->getMessageBag()->first());
        }
    }
    public function uploadMainImage(Request $request){
        //  $validator = Validator::make($request->all(), [
        //     'image' => 'required|image:jpeg,png,jpg,gif,svg'
        //  ]);
        //  if ($validator->fails()) {
        //     return response()->json([
        //         'error' => 'error',
        //        // 'user' => $msg ,
        //         'image' => $request->file('image')
        //         ]);
        //  }
          
         $uploadFolder = 'products';
         $image = $request->file('image');
         $image_uploaded_path = $image->store($uploadFolder, 'public');
        //  $uploadedImageResponse = array(
        //     "image_name" => basename($image_uploaded_path),
        //     "image_url" => Storage::disk('public')->url($image_uploaded_path),
        //     "mime" => $image->getClientMimeType()
        //  );
         $user = User::find($request->user('user_api')->id);
        //   $user = User::find(1866);
            if($user){
                $msg = "user found ! "; 
                // $user->image = $image_uploaded_path; 
                // $user->save();
            }else{
                $msg = "user Not found ! "; 
            }
        // return response()->json([
        //     'status' => true,
        //     'message' => 'Success',
        //     'image' => "sdf",
        //     'user' => "sdfs" 
          
        // ]);
          
        return response()->json([
            'status' => true,
            'message' => 'Success',
            'image' => $image_uploaded_path,
            'user' => $msg 
          
        ]);
    }
    public function showImage($id)
    {
        $Image = Image::where('product_id', $id)->get();
        foreach ($Image as $key => $value) {
            $images[$key]['id'] = $value->id;
            $images[$key]['image'] = $value->image;
        }
        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $images
        ]);
    }
    public function destroyImage($id)
    {
        $productDelete =  Image::destroy($id);
        if ($productDelete) {
            return ControllersService::generateProcessResponse(true, 'DELETE_SUCCESS');
        } else {
            return ControllersService::generateProcessResponse(true, 'DELETE_FAILED');
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
        $productDelete =  product::destroy($id);
        if ($productDelete) {
            return ControllersService::generateProcessResponse(true, 'DELETE_SUCCESS');
        } else {
            return ControllersService::generateProcessResponse(true, 'DELETE_FAILED');
        }
    }
    public function demoShowProduct($id)
    {
        $product = Product::where('id', $id)->with('city')->first();
        $user_id = $product->user_id;
        $user =     user::find($user_id);

        if ($user->name == null) {
            return ControllersService::generateProcessResponse(false, 'NOT_FOUND', 404);
        }
        $resonseData['product_id']   = $product->id;
        $resonseData['product_name'] = $product->name;
        $resonseData['product_price'] = $product->price;
        $resonseData['product_description'] = $product->description;
        $resonseData['city'] = !is_null($product->city) ? $product->city->name : "غير محدد";
        $resonseData['city_id'] = $product->city_id;
        $resonseData['phone'] = $product->user->phone;
        $resonseData['userfavorit'] = $product->userfavorit->count();
        $resonseData['discount_ratio'] = $product->discount_ratio;
        

        if ($product->main_image != null) {
            $resonseData['product_image']   = url('storage/' . $product->main_image);
        }
        $productImages = Image::where('product_id', $id)->get();
        foreach ($productImages->pluck('path') as $key => $image) {
            $resonseData['product_images'][$key] = url('storage/' . $image);
          //  $resonseData['product_images'][$key]['id'] =$key-. ;
            
        }
        if ($product->company_name != null) {
            $resonseData['company_name'] = $product->company_name;
        }
        $resonseData['is_favorite']   = $product->is_joined;

        $rate = Rating::where('product_id', $id)->get();
        if (count($rate) == 0) {
            $resonseData['rate'] = [];
        } else {
            foreach ($rate as $key => $value) {
                $resonseData['rate'][$key]['id']     =      $value->id;
                $resonseData['rate'][$key]['degree']     = $value->degree;
                $resonseData['rate'][$key]['comment']     = $value->comment;
                $resonseData['rate'][$key]['Name']     = $value->Name;
                $resonseData['rate'][$key]['userImage']     = $value->image;
                $resonseData['rate'][$key]['created_at']     = $value->created_at;
                $resonseData['rate'][$key]['updated_at']     = $value->updated_at;
                $resonseData['rate'][$key]['is_reported']     = $value->is_reported;
            }
        }

        $sub_category = $product->category_id;


        $ads = Product::where('category_id', $sub_category)->orderBy('created_at', 'DESC')->paginate(10);
        foreach ($ads as $key => $value) {
            $resonseData['ads'][$key]['product_id']   = $value->id;
            $resonseData['ads'][$key]['sub_category']   = $sub_category;
            $resonseData['ads'][$key]['product_name'] = $value->name;
            $resonseData['ads'][$key]['product_price'] = $value->price;
            $resonseData['ads'][$key]['product_description'] = $value->description;
            $resonseData['ads'][$key]['product_image']   = url($value->image);
            $resonseData['ads'][$key]['is_favorite']   = $product->is_joined;
        }
        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $resonseData
        ]);
    }
    
        public function destroyImageByPath(Request $request)
    {
        $productDelete =  Image::where('path', $request->get('path'))->first();
        $delete = Image::destroy($productDelete->id);
        if ($delete) {
            return ControllersService::generateProcessResponse(true, 'DELETE_SUCCESS');
        } else {
            return ControllersService::generateProcessResponse(true, 'DELETE_FAILED');
        }
    }
    
        public function getStore($id){
        $user = User::find($id);
        $store = PromotedUser::where('user_id', $user->id)->first();
            return response()->json([
                'status' => true , 
                'message' => 'message here ', 
                'data'=> $store
                ]);
    }
        public function getProducts($id){
         $user = User::find($id);
         $products = Product::where('is_valid', 1)->where('user_id', $user->id)->orderBy('id','DESC')->get();
          return response()->json([
                'status' => true , 
                'message' => 'message here', 
                'data'=> $products
                ]);
         
    }
    

}
