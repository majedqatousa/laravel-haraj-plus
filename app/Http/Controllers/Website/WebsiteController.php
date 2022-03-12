<?php

namespace App\Http\Controllers\Website;

use App\Http\Requests\ProductRequest;
use App\Http\Services\ProductService;
use App\Http\Services\UserService;
use App\Models\Ad;
use App\Models\City;
use App\Models\DeactivateUser;
use App\User;
use Notification;
use App\Models\Category;
use App\Models\Country;
use App\Models\Favorite;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\Rating;
use App\Models\Pakage;
use App\Models\Report;
use App\Notifications\rateNotification;
use App\Notifications\adminMessageNotification;
use App\PromotedUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tech;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Constraint\Count;
use Carbon\Carbon;
use Auth;
use SebastianBergmann\Environment\Console;
use App\Notifications\MailNotification;  

class WebsiteController extends Controller
{

    public function __construct(ProductService $product)
    {
        $this->productService = $product;
    }
    public function haraj_specials(){
        return view('website.haraj_specials');
    }//end haraj_specials

    //products

    public function Index()
    {

        $countries = Country::all()->pluck('name', 'id');

        $latestproducts = Product::where('is_valid', 1)->latest()->get();
        return view("website.index", compact('countries', 'latestproducts'));


    }

    public function create()
    {
        //allow user to create only 7 products per month
        $product_per_month = Product::where('user_id', auth()->user()->id)->whereMonth('created_at', date('m'))->get();
        if(count($product_per_month) == 7  && auth()->user()->is_promoted == 0){
            session()->flash('failed', 'لقد تخطيت الحد المسموح به لهذا الشهر');
            return redirect('/profile-products');
        }

        if ((auth()->user()->is_promoted == 0 && chekProductsPerMonth()) || auth()->user()->is_promoted == 1 || auth()->user()->is_promoted == 2 && chekProductsPerMonth()) {
            $countries = Country::all()->pluck('name', 'id')->toArray();
            $cities = City::all()->pluck('name', 'id')->toArray();
            $categories = Category::where('parent_id', null)->orderBy('order','ASC')->get()->pluck('name', 'id');
            return view('website.add_product', compact("cities", 'categories'));
        } else
            session()->flash('expired', 'لقد تخطيت الحد المسموح به للمنتجات');
        return redirect()->route('showProfile');
    }

    public function store(ProductRequest $request)
    {
            $requestData = $request->all();
            if(strpos($requestData['name'], "/") !== false)
            {
               $requestData['name'] =  str_replace("/","%",$request->name);
            } 
            $this->productService->storeproduct($request);
            session()->flash('success', 'تم اضافه المنتج بنجاح وفي انتظار قبول الادارة');
           return response()->json(['route'=>'/profile-products']);
    }

    public function edit($id)
    {
        $product = $this->productService->getproduct($id);
        if ($product->user_id == auth()->id()) {
            $countries = Country::all()->pluck('name', 'id')->toArray();
            $categories = Category::where('parent_id', null)->orderBy('order','ASC')->get()->pluck('name', 'id');
            $images = $product->images->get();
           return view('website.edit_product', compact("product", 'countries', 'categories', 'images'));
        } else
            return abort('403');

    }

    public function update(ProductRequest $request, $id)
    {
        $this->productService->updateproduct($id, $request);
        session()->flash('success', 'تم تعديل المنتج بنجاح');
        return redirect('/profile-products');

    }

    public function productDetails($string)
    {
        if(strpos($string, "/") !== false){
            $new_string =  str_replace("/","%",$string);
            $id = explode('-', $new_string)[0];
        } else{
            
             $id = explode('-', $string)[0];
        }
       
        $product = Product::with('user')->findOrFail($id);
        $images = $product->images->get()->pluck('path')->toArray();
        $favouriteProducts = Favorite::where('user_id', auth()->id())->pluck('product_id')->toarray();
        $product['rate'] = $product->rates->avg('degree');

        $rates = Rating::where('product_id', $product->id)->latest()->take(5)->get();
        $rate = Rating::where('product_id', $product->id)->where('user_id', auth()->id())->first();
        if($product->is_valid != 1   || $product->user->is_active == 0){
          session()->flash('failed', 'لم يتم قبول التعديل الي الان!');
            return back() ;
        }


        return view("website.product_details", compact('product', 'images', 'rates', 'rate','favouriteProducts'));


    }

    public function getAdd()
    {
        $ad = Ad::where('position', 'top')->first();

        $output = view('website.main_ad', compact('ad'))->render();

        return response()->json(['output' => $output]);
    }

    public function getCountries()
    {
        $countries = Country::all();

        return json_encode($countries);


    }

    public function reportProduct(Request $request, $id)
    {

        if ($deactivated = DeactivateUser::where('user_id', auth()->id())->where('type', 0)->first()) {
            if (User::find($deactivated->user_id)->created_at->diffInDays() > $deactivated->period)
                return response()->json(['msg' => 'انت محظور من الابلاغ ):']);
        }
                $validator = Validator::make($request->all(), ['body' => 'required']);
                $product = Product::find($id);
                $requestData = $request->all();

                if ($validator->fails())
                    $msg = "<div class='alert-danger'> ادخل نص البلاغ</div>";
                else {
                    $report = Report::where([
                        ['user_id' , auth()->id()],['product_id' , $id]
                    ])->get();
                    if (!count($report)){
                        $report = Report::create(['user_id' => auth()->id(), 'body' => $requestData['body'], 'product_id' => $id]);
                        $msg = "<div class='alert-success'>تم ارسال بلاغك وناسف لتسببك ف الازعاج وسيتم اخد الاجراء المناسب من قبل الاداره ف اقرب وقت</div>";
                        $details = ['type' => 'report', 'image' => $product->image, 'actionUrl' => route('product-details', $product->id . '-' . $product->name), 'message' => 'لقد قمت  بالابلاغ عن هذا المنتج '];
                        Notification::send(auth()->user(), new rateNotification($details));
                        Notification::send($product->user,new MailNotification(['line'=>   'بالابلاغ عن منتجك'. auth()->user()->name . ' قام ','url'=>$details['actionUrl'],'url_text'=>'مشاهدة المنتج']));


                    }else{
                        $msg = "<div class='alert-success'>تم ارسال بلاغك مسبقا</div>";
                    }


                }
                return response()->json(['msg' => $msg]);

            }







    public function reportComment($comment, $product)
    {

        if ($deactivated = DeactivateUser::where('user_id', auth()->id())->where('type', 0)->first())  
        {
            if (User::find($deactivated->user_id)->created_at->diffInDays() > $deactivated->period) {
                session()->flash('failed', 'انت محظور من الابلاغ ):');

                return back();
            }
        }
        $comment = Rating::find($comment);
        $product = Product::find($product);
        $report = Report::where([
            ['product_id',$product->id],['rate_id' , $comment->id],['user_id' , auth()->id()]
        ])->get();

        if (!count($report)){
            $report = Report::create(['user_id' => auth()->id(), 'product_id' => $product->id, 'rate_id' => $comment->id, 'body' => $comment->comment]);
            session()->flash('success', 'تم ارسال بلاغك وناسف لتسببك ف الازعاج وسيتم اخد الاجراء المناسب من قبل الاداره ف اقرب وقت:)');
        }else{

            session()->flash('success', 'تم الابلاغ مسبقا');
        }


         return back();

    }





    public function rateProduct(Request $request, $id)
    {
        if ($deactivated = DeactivateUser::where('user_id', auth()->id())->where('type', 1)->first()) {
            if (User::find($deactivated->user_id)->created_at->diffInDays() > $deactivated->period)

                return response()->json(['msg' => 'انت محظور من التعليق  ):']);

        }
        $validator = Validator::make($request->all(), [
            'degree' => 'required',
            'comment' => 'required',
        ]);
        $product = Product::find($id);
        $rate = Rating::where('product_id', $product->id)->where('user_id', auth()->id())->first();
        $requestData = $request->all();
        if ($validator->fails()) {
            $msg = '<div  class="alert-danger"> يجب ادخال التقييم والتعليق </div>';
            return response()->json(['msg' => $msg, 'success' => 0]);
        } else {
            if ($rate)
                $rate->update($requestData);
            else {
                $rate = Rating::create(['user_id' => auth()->id(), 'comment' => $requestData['comment'], 'product_id' => $id, 'degree' => $requestData['degree']]);
                $details = ['type' => 'rate', 'image' => $product->user->image, 'actionUrl' => url(route('product-details', $product->id)), 'message' => 'لقد قام' . $rate->user->name . ' باضافه تقييم للمنتج الخاص بك'];
                Notification::send($product->user, new rateNotification($details));
                
            Notification::send($product->user,new MailNotification(['line'=>'   بإضافة تقييم للمنتج الخاص بك  '.auth()->user()->name.'  قام ' ,'url'=>$details['actionUrl'],'url_text'=>'مشاهدة المنتج  ']));

            }
            $msg = '<div  class="alert-success">  تم التقييم بنجاح  </div>';
            return response()->json(['msg' => $msg, 'success' => 1]);

        }

    }

    public function deactivate($id)
    {
        $this->productService->deactivate($id);
        return back();


    }

    public function categoryProducts($string)
    {

        $id = explode('-', $string)[0];
        $favouriteProducts = Favorite::where('user_id', auth()->id())->pluck('product_id')->toarray();
        $products_pro = (Product::where('is_valid', 1)->where('category_id', $id)->wherehas('user', function ($q) {
            $q->where('is_promoted', 1)->where('is_active', 1);
        }));

        $products = (Product::where('is_valid', 1)->where('category_id', $id)->wherehas('user', function ($q) {
            $q->where('is_promoted', 0)->where('is_active', 1);
        }));
         $category = Category::where('id',$id)->first();

        $allProducts = $products_pro->union($products)->OrderBy('id','DESC')->get();
        $count = $allProducts->count();
        return view('website.products', compact('allProducts', 'count', 'favouriteProducts','category'));

    }

////end products section////

    public function destroy($id)
    {
        $this->productService->deleteProduct($id);
        return response()->json('success', 200);
    }


    public function paymentMethods($package_id)
    {

        $paymentMethods = PaymentMethod::all();
        $package = Pakage::where('id',$package_id)->first();
        return view('website.paymentMethods', compact('paymentMethods','package'));
    }

    public function paymentWays()
    {

        $paymentMethods = PaymentMethod::all();
        return view('website.paymentMethods', compact('paymentMethods'));
    }

    public function productsUser($type)
    {
        if ($type == 1)
            $allProducts = (Product::where('is_valid', 1)->wherehas('user', function ($q) {

                $q->where('is_promoted', 1);
            })->orderBy('id','DESC')->get());

        if ($type == 0)
            $allProducts = (Product::where('is_valid', 1)->wherehas('user', function ($q) {

                $q->where('is_promoted', 0);
            })->orderBy('id','DESC')->get());

        $count = $allProducts->count();
        $favouriteProducts = Favorite::where('user_id', auth()->id())->pluck('product_id')->toarray();
        return view('website.productsUsers', compact('allProducts', 'favouriteProducts', 'count'));

    }


    public function update_phone($user_id,Request $request){
        
     $validator = Validator::make($request->all(), [

            'phone' => array('phone' => 'required', 'regex:/^(05|5)(5|0|3|6|4|9|1|8|7)([0-9]{7})$/'),
          
        ]);

        if($validator->fails()){

             session()->flash('failed','صيغة الهاتف خاطئة');

	     return back();
		}else{
            $user = \App\User::findOrFail($user_id);
            $user->update(['phone'=>$request->phone]);
            $user->update(['code'=> rand ( 1000 , 9999 )]);
            $message = "  كود التفعيل الخاص بك فى موقع حراج بلص هو  ".$user->code;
            sendSMS(format_number($request->phone),  $message );
            $token=$user->code;
            $new_phone = $user->phone;
            $id = $user->id;
            return view('auth.verify',compact('token','id','new_phone'));

    }
    }//end update_phone



    public function verify(Request $request){
        $user = User::find($request->user);
        $token = $user->code;
        $id = $user->id;
        $array = $request->code;
        $code = $array[0];

        if($request->has('token'))
        {
            if ($token == $code ) {
                $new = User::where('code', $code)->first();
                $new->update(['is_active'=>1]);
                Auth::login(User::where('code', $code)->first());
                if (isset($request->new_phone)){
                    $user->phone = $request->new_phone;
                    $user->save();
                }
                session()->flash('success', 'تم التفعيل بنجاح');
                return redirect()->to('/');
            }else{
                session()->flash('failed', 'هذا الكود غير صالح');
                $output = $this->verifyNumber($token ,$id);
                return $output;
            }

        }else{
            return redirect()->route('signUp');
        }
    }
    public function verify2(Request $request){
      

       $user = User::where('phone',$request->phone)->first();
       if(isset($user)){
           $user->is_connected = 1 ; 
           $user->save();
        Auth::login(User::where('phone', $request->phone)->first());
        session()->flash('success', 'تم التفعيل بنجاح');
        // return redirect()->to('/');
       }else{
        error_log('Some message here.3');

        session()->flash('success', ' 2 تم التفعيل بنجاح');
       }
    //    return redirect()->to('/');

    }
    

        public function verifyNumber($token ,$id)
        {
            return view('auth.verify',compact('token','id'))->render();
        }



        public function sendTech(Request $request)
        {

           $old_techs =  Tech::where('email',$request['email'])->get();
           $user = User::where('email',$request['email'])->first();
           $admin = User::where('id',1)->first();
           if (isset($user)) {
               Tech::create([
                   'user_id'=>$user->id,
                   'parent_id'=>null,
                   'name'=>$user->name?$user->name:$request['name'],
                   'email'=>$user->email,
                   'subject'=>$request['subject'],
                   'message'=>$request['message']
                   ]);
                   
                $details = ['type' => 'tech', 'actionUrl' => url(route('tech')), 'message' => ' لقد قام' . $user->name . ' بإرسال رسالة '];
                Notification::send($admin, new adminMessageNotification($details));
                

               }
                else{
                    return response()->json(['fail'=>'عفوا انت غير مشترك في الموقع']); 
                }
            return response()->json(['success'=>'true']);

        }
        
        
        
        public function sendTechContact(Request $request)
        {

            $admin = User::where('id',1)->first();
            $user = Tech::create([
                   'parent_id'=>null,
                   'name'=>$request['name'],
                   'email'=>$request['email'],
                   'subject'=>$request['subject'],
                   'message'=>$request['message']
                   ]);
                   
                $details = ['type' => 'tech', 'actionUrl' => url(route('tech')), 'message' => ' لقد قام' . $user->name . ' بإرسال رسالة '];
                Notification::send($admin, new adminMessageNotification($details));
                
                return response()->json(['success'=>'true']);

        }        
        
        


        public function techPage()
        {
             
           if(Auth::user())
           {
               $techs = Tech::with('replay')->Where('user_id',Auth::id())->OrderBy('id','DESC')->take(2)->get();
               return view('website.tech',compact('techs'));
           }
           else{
               return view('website.tech');
           }
        }

        public function Replay($id ,Request $request)
        {
            
           $old = Tech::with('replay')->where('id',$id)->first();
                      $admin = User::where('id',1)->first();

           if(isset($old) && isset($old->replay)){
            $replay = Tech::with('replay')->where('id',$old->replay->id)->first();
               if (isset($old) && !isset($replay->replay)) {
                   $user = User::where('id', $request['user_id'])->first();
                       Tech::create([
                            'user_id'=>$user->id,
                            'parent_id'=>$old->replay->id,
                            'name'=>$user->name?$user->name:$request['name'],
                            'email'=>$user->email,
                            'subject'=>$old->replay->subject,
                            'message'=>$request['message']
                            ]);
                            
                $details = ['type' => 'tech', 'actionUrl' => url(route('tech')), 'message' => '  لقد قام' . $user->name . ' بإرسال رسالة '];
                Notification::send($admin, new adminMessageNotification($details));
                

                    return response()->json(['success'=>' تم إرسال الرد بنجاح']);
                }
                else{
                 return response()->json(['fail'=>'تم الرد مسبقا']);
                }
            
            }
            else{
                return response()->json(['norelpay'=>'لم تستقبل رد الي الان']);
            }
            
        }   
         
    
    

}
