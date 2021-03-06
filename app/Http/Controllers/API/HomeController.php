<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\follower;
use App\Models\Product;
use App\Models\PromotedUser;
use App\Models\Slider;
use App\User;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Contact;

use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function businessProduct()
    {
        $category = Category::orderBy('order', 'asc')->limit(7)->get();
        $Slider = Slider::all();

        $businessProducts = Product::where('user_promoted', 1)->where('is_valid', 1)->orderBy('created_at', 'DESC')->limit(7)->get();
        $product = null;
        foreach ($businessProducts as $i => $products) {
            $product[$i]['id']    = $products->id;
            $product[$i]['name']    = $products->name;
            $product[$i]['price']   = $products->price;
            $product[$i]['description']   = $products->description;
            $product[$i]['main_image']   = url('storage/' . $products->main_image);
            $product[$i]['company_name']   = $products->company_name;
            $product[$i]['is_favorite']   = $products->is_joined;
            $product[$i]['user_id']   = $products->user_id;
            
        }

        $businessProducts = $product;

        $userProduct = Product::where('user_promoted', 0)->where('is_valid', 1)->orderBy('created_at', 'DESC')->limit(7)->get();
        $products = null;
        foreach ($userProduct as $i => $product) {
            $products[$i]['id']    = $product->id;
            $products[$i]['name']    = $product->name;
            $products[$i]['price']   = $product->price;
            $products[$i]['description']   = $product->description;
            $products[$i]['main_image']   = url('storage/' . $product->main_image);
            $products[$i]['company_name']   = $product->company_name;
            $products[$i]['is_favorite']   = $product->is_joined;
            $products[$i]['user_id']   = $product->user_id;
        }

        $userProduct = $products;
        $businessStores = user::where('is_promoted', 1)->orderBy('created_at', 'DESC')->limit(7)->get();
        $users = null;
        if (!is_null($businessStores)) {
            foreach ($businessStores as $key => $user) {
                $users[$key]['user_id']    = $user->id;
                $users[$key]['name']    = $user->name;
                $users[$key]['phone']   = $user->phone;
              
              //  $users[$key]['bio']   = !is_null ($user->promotedUser->about) ? $user->promotedUser->about : '????';

                $users[$key]['image']   = $user->image;
            }
        }
        $businessStore = $users;
        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => [
                'slider' => $Slider,  'categories' => $category, 'business_products' => $businessProducts, 'business_stores' => $businessStore, 'user_products' => $userProduct,
            ]
        ]);
    }
    public function city()
    {
        // $city = City::paginate(10);
        // foreach ($city as $key => $item) {
        //     $cities[$key]['id']    = $item->id;
        //     $cities[$key]['name']    = $item->name;
        // }
        // $pagination['total'] = $city->total();
        // $pagination['count'] = $city->count();
        // $pagination['hasMorePages'] = $city->hasMorePages();
        // $pagination['currentPage'] = $city->currentPage();
        // $pagination['firstItem'] = $city->firstItem();
        // $pagination['last_page_id'] = $city->lastPage();
        // $pagination['per_page'] = $city->perPage();
        // $pagination['nextPageUrl'] = $city->nextPageUrl();
        // $pagination['onFirstPage'] = $city->onFirstPage();
        // $pagination['previousPageUrl'] = $city->previousPageUrl();
        // $resonseData['paginate'] = $pagination;
        // $response = [];
        // $response['data'] = $cities;
        // $response['paginate'] = $pagination;

        // return response()->json([
        //     'status' => true,
        //     'message' => 'Success',
        //     'data' => $response
        // ]);
        $city = City::all();
            
          
           
        return response()->json(
             $city
            );
    }
    public function cityName($id){
        $city = City::find($id);
        return response()->json([
            'name' => $city->name
            ]);
    }
    public function productUserPromit()
    {
        $businessProducts = Product::where('user_promoted', 1)
            ->where('is_valid', 1)
            ->orderBy('created_at', 'DESC')
            ->select('id', 'name', 'price', 'description', 'main_image', 'user_id')
            ->paginate(10);

        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $businessProducts
        ]);
    }
    public function productUser()
    {
        $businessProducts = Product::where('user_promoted', 0)->where('is_valid', 1)->orderBy('created_at', 'DESC')
            ->select('id', 'name', 'price', 'description', 'main_image', 'user_id')->paginate(10);

        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $businessProducts
        ]);
    }
    public function userPromit()
    {
        $businessStores = PromotedUser::select('id', 'user_id', 'about')
            
            ->paginate(10);

        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $businessStores
        ]);
    }

    public function productCreated()
    {
        $productCreated = Product::orderBy('created_at', 'desc')->paginate(10);
        // $product = null;
        foreach ($productCreated as $i => $products) {
            $product[$i]['id']    = $products->id;
            $product[$i]['user_id']    = $products->user_id;
            $product[$i]['name']    = $products->name;
            $product[$i]['price']   = $products->price;
            // $product[$i]['description']   = $products->description;
            $product[$i]['main_image']   = url('storage/' . $products->main_image);
            $product[$i]['company_name']   = $products->company_name;
            $product[$i]['city']   = $products->city;
            $product[$i]['city_id']   = $products->city_id;

            $product[$i]['created_at']   = $products->created_at;

            $product[$i]['is_joined']   = $products->is_joined;
        }
        $pagination['total'] = $productCreated->total();
        $pagination['count'] = $productCreated->count();
        $pagination['hasMorePages'] = $productCreated->hasMorePages();
        $pagination['currentPage'] = $productCreated->currentPage();
        $pagination['firstItem'] = $productCreated->firstItem();
        $pagination['last_page_id'] = $productCreated->lastPage();
        $pagination['per_page'] = $productCreated->perPage();
        $pagination['nextPageUrl'] = $productCreated->nextPageUrl();
        $pagination['onFirstPage'] = $productCreated->onFirstPage();
        $pagination['previousPageUrl'] = $productCreated->previousPageUrl();

        $productCreated = $product;
        $paginate = $pagination;

        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $productCreated, 'paginate' => $paginate
        ]);
    }
    public function productPriceDesc($type = 'ASC')
    {
        if ($type == 'ASC') {
            $productCreated = Product::orderBy('price', 'ASC')->paginate(10);
        } elseif ($type == 'desc') {
            $productCreated = Product::orderBy('price', 'desc')->paginate(10);
        }
        $product = null;
        foreach ($productCreated as $i => $products) {
            $product[$i]['id']    = $products->id;
            $product[$i]['user_id']    = $products->user_id;
            $product[$i]['name']    = $products->name;
            $product[$i]['price']   = $products->price;
            // $product[$i]['description']   = $products->description;
            $product[$i]['main_image']   = url('storage/' . $products->main_image);
            $product[$i]['company_name']   = $products->company_name;
            $product[$i]['city']   = $products->city;
            $product[$i]['city_id']   = $products->city_id;

            $product[$i]['created_at']   = $products->created_at;

            $product[$i]['is_joined']   = $products->is_joined;
            // $product[$i]['pagi']   = $products->simplePaginate(10);

        }
        $pagination['total'] = $productCreated->total();
        $pagination['count'] = $productCreated->count();
        $pagination['hasMorePages'] = $productCreated->hasMorePages();
        $pagination['currentPage'] = $productCreated->currentPage();
        $pagination['firstItem'] = $productCreated->firstItem();
        $pagination['last_page_id'] = $productCreated->lastPage();
        $pagination['per_page'] = $productCreated->perPage();
        $pagination['nextPageUrl'] = $productCreated->nextPageUrl();
        $pagination['onFirstPage'] = $productCreated->onFirstPage();
        $pagination['previousPageUrl'] = $productCreated->previousPageUrl();
        $productCreated = $product;
        $paginate = $pagination;

        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $productCreated, 'paginate' => $paginate
        ]);
    }
    public function fillterData(Request $request)
    {
        $fromDate = $request->get('fromDate');
        $toDate = $request->get('toDate');
        $fromPrice = $request->get('fromPrice');
        $toPrice = $request->get('toPrice');
        $productCreated = Product::where('category_id', $request->get('category_id'))
            ->where('city_id', $request->get('city_id'))
            ->whereBetween('created_at', [$fromDate, $toDate])
            ->whereBetween('price', [$fromPrice, $toPrice])
            ->paginate(10);
        $product = null;
        foreach ($productCreated as $i => $products) {
            $product[$i]['id']    = $products->id;
            $product[$i]['user_id']    = $products->user_id;
            $product[$i]['name']    = $products->name;
            $product[$i]['price']   = $products->price;
            // $product[$i]['description']   = $products->description;
            $product[$i]['main_image']   = url('storage/' . $products->main_image);
            $product[$i]['company_name']   = $products->company_name;
            $product[$i]['city']   = $products->city;
            $product[$i]['city_id']   = $products->city_id;

            $product[$i]['created_at']   = $products->created_at;

            $product[$i]['is_favorite']   = $products->is_joined;
        }
        $pagination['total'] = $productCreated->total();
        $pagination['count'] = $productCreated->count();
        $pagination['hasMorePages'] = $productCreated->hasMorePages();
        $pagination['currentPage'] = $productCreated->currentPage();
        $pagination['firstItem'] = $productCreated->firstItem();
        $pagination['last_page_id'] = $productCreated->lastPage();
        $pagination['per_page'] = $productCreated->perPage();
        $pagination['nextPageUrl'] = $productCreated->nextPageUrl();
        $pagination['onFirstPage'] = $productCreated->onFirstPage();
        $pagination['previousPageUrl'] = $productCreated->previousPageUrl();
        $productCreated = $product;
        $paginate = $pagination;
        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $productCreated, 'paginate' => $paginate
        ]);
    }
    public function searchProduct(Request $request, $key){
        if(!is_null($key)){
               $product = Product::where('name','LIKE','%'.$key.'%')->where('is_valid', 1)->get();
        return response()->json(
           $product
            );
        
        }
     
    }
    public function mystore($id)
    {

        $user = user::find($id);
        $users = null;
        $users['user_id']    = $user->id;
        $users['name']    = $user->name;
        $users['phone']   = $user->phone;
        if ($user->is_promoted == 1) {
            $users['bio']   = $user->promotedUser->about;
        }
        $users['image']   =   $user->image;
        $users['is_followed']   = $user->is_followed;
        $resonseData['user'] =  $users;


        $myProducts = Product::where('user_id', $id)->orderBy('created_at', 'DESC')->get();
        $products = null;
        foreach ($myProducts as $key => $value) {
            $products[$key]['id']     =      $value->id;
            $products[$key]['name']     = $value->name;
            $products[$key]['price']     = $value->price;
            $products[$key]['description']     = $value->description;
            $products[$key]['main_image'] = url('storage/' . $value->main_image);
            $products[$key]['created_at']   = $value->created_at;
            $products[$key]['is_favorite']   = $value->is_joined;
        }
        $resonseData['product'] = $products;

        $follower = follower::where('user_id', $id)->get()->count();
        $resonseData['follower'] =  $follower;
        $following = follower::where('user_followed', $id)->get()->count();
        $resonseData['following'] =  $following;
        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $resonseData
        ]);
    }
    public function contact(Request $request)
    {
        $roles = [
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'body' => 'required',
        ];

        $validator = Validator::make($request->all(), $roles);
        if (!$validator->fails()) {
            $contact = new Contact();
            $contact->name = $request->get('name');
            $contact->email = $request->get('email');
            $contact->subject = $request->get('subject');
            $contact->body = $request->get('body');
            $isSaved = $contact->save();
            if ($isSaved) {
                return ControllersService::generateProcessResponse(true, 'CREATE_SUCCESS');
            } else {
                return ControllersService::generateProcessResponse(true, 'CREATE_FAILED');
            }
        } else {
            return ControllersService::generateValidationErrorMessage($validator->getMessageBag()->first());
        }
    }
}
