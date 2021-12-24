<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductRequest;
use App\Http\Services\CityService;
use App\Http\Services\CountryService;
use App\Http\Services\ProductService;
use App\Notifications\orderActionNotification;
use App\Notifications\OrderNotification;
use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\Image;
use App\Models\Product;
use App\User;
use Illuminate\Http\Request;
use App\Notifications\MailNotification;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\UserNotificationController;
use App\Http\Controllers\API\UserFcmTokenController;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(ProductService $service, CountryService $country)
    {
        $this->country = $country;
        $this->service = $service;
        //$this->city = $city;
    }

    public function index()
    {

        if (isset($_GET['is_valid'])&&$_GET['is_valid']==3){
            $products = Product::where('is_valid',3)->orderBy('id','desc')->get();
            $count=$products->count();

        }else{
            $products = $this->service->getproducts();
            $count=$products->count();
        }

        //   return $products;

        return view("admin.products.index", compact("products",'count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = $this->service->getproduct($id);
        $images = $product->images;
        return view("website.product_details", compact("product", 'images'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = $this->service->getproduct($id);
        $cities=City::all()->pluck('name', 'id')->toArray();
        $countries = Country::all()->pluck('name', 'id')->toArray();
        $categories = Category::where('parent_id', null)->get()->pluck('name', 'id');

        $images = $product->images->get();

        // dd($product->images->pluck('path'));
        return view('admin.products.edit', compact("product", 'cities', 'countries', 'categories', 'images'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {
        $this->service->updateproduct($id, $request);
        return redirect()->route('products.index');

    }

    public function getSubCategories($id)
    {

        $subCategories = Category::where('parent_id', $id)->get();

        return json_encode($subCategories);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $this->service->deleteProduct($id);
        return response()->json(['success'=>'true']);

    }

    public function deleteProduct($id)
    {

        $product = Product::findOrFail($id);

        $user = User::findOrFail($product->user_id);


        $details=[
            'type'=>'payment','message'=>"يؤسفنا لا يمكن قبول إعلانك $product->name  لتعارضه من سياسات حراج بلص",
            'image'=> 'settings/logo.png'
        ];
        $userNotificationController = new UserNotificationController();
        $fcmNotification =  new UserFcmTokenController();
        $title = "رفض إعلان" ; 
        $userNotificationController->sendNotification('يؤسفنا لا يمكن قبول إعلانك',  $title, 'إعلان', $user->id);
        $token = $user->fcm_token;
        if(!is_null($token)){
            $fcmNotification->sendFCMNotification($token, 'تم رفض إعلانك' , 'يؤسفنا لا يمكن قبول إعلانك');
          

       }
        \Notification::send($user, new orderActionNotification($details));
        \Notification::send($user,new MailNotification(['line'=> $details['message'],'url'=>'https://staging.haraj-plus.co','url_text'=>' الذهاب للموقع']));


        $this->service->deleteProduct($id);
        session()->flash('success', 'تم حذف المنتج بنجاح');


        return redirect()->back();
    }
    public function deleteImage($id)
    {

        Image::find($id)->delete();
        return response()->json(['success' => 'true']);

    }
    public function product_activate($id){
        $product = Product::findOrFail($id);
        $product->is_valid =1;
        $product->save();

        $user = User::findOrFail($product->user_id);

        $details=[
            'type'=>'product',
            'actionUrl'=>route('product-details',$product->id.'-'.$product->name),
            'message'=>'تم الموافقة على المنتج الخاص بك',
            'image'=> 'settings/logo.png'
        ];

        \Notification::send($user, new orderActionNotification($details));
        \Notification::send($user,new MailNotification(['line'=> $details['message'],'url'=>$details['actionUrl'],'url_text'=>'مشاهدة المنتج']));

        session()->flash('success', 'تم التفعيل بنجاح');
        return redirect()->back();

    }//end product_activate

    public function getMore()
    {
        if (isset($_GET['is_valid'])&&$_GET['is_valid']==3){
            $products = Product::where('is_valid',3)->orderBy('id','desc')->paginate(12);

        }else{
            $products = Product::where('is_valid',1)->orderBy('id','desc')->paginate(12);

        }
        $next_url='';

        if($products->toArray()['next_page_url']!=null)
            $next_url=$products->toArray()['next_page_url'];

        $output = view('admin.products.read_more' ,compact('products'))->render();
        return response()->json(['output'=>$output,'next_url'=>$next_url]);

    }

    public function getStatus($id)
    {$this->service->deactivate($id);

        return redirect()->route('products.index');

    }

    public function search(Request $request){
        $products=Product::where('name', 'like', '%' . $request->name . '%')->get()     ;
       $count=$products->count();
        return view('admin.products.search',compact('products','count'));

}

}
