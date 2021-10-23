<?php

namespace App\Http\Controllers\Website;

use App\Classes\FileOperations;
use App\Http\Requests\PaymentRequest;
use App\Models\BankAccount;
use App\Models\Pakage;
use App\Models\Payment;
use App\Models\PromotedUser;
use App\Notifications\orderActionNotification;
use App\Notifications\OrderNotification;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Notification;
use Illuminate\Routing\Route;
use Illuminate\Support\Str;
use App\Notifications\MailNotification;

use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{

    public function create($package_type){
       
  $package = Pakage::where('type',$package_type)->first();
  $banks = BankAccount::all()->pluck('name','id')->toArray();

  return view('website.payment',compact('package','banks'));

    }


    public function  store(PaymentRequest $request)
    {

        $requestData= $request->all();
        $requestData['transfer_date']=date('Y-m-d H:i:s', strtotime($requestData['transfer_date']));

        if(strtotime($request->transfer_date)-time()>0)
        {
            session()->flash('failed','يجب ادخال تاريخ صالح');
            return back();
        }
      
        $requestData['image']=FileOperations::StoreFileAs('public/storage/website/payments',$request->image,Str::random(7));
        $requestData['type']=1;
        $requestData['user_id']=auth()->id();
        $requestData['paymentMethod']=1;
        $admin=User::where('type',1)->first();
        $payment= Payment::create($requestData);
        if (User::find(auth()->id())->is_promoted != 1){
            User::find(auth()->id())->update(['is_promoted'=>2]);
        }
        session()->flash('success','تم الدفع بنجاح');

        $details=['user_name'=>auth()->user()->name,
            'message'=>' قام '.auth()->user()->name.' بارسال طلب ترقيه الحساب   ',
            'actionUrl'=>Url(\route('payments.show',$payment->id)),
            'image'=>auth()->user()->image,
            'type'=>'payment'


        ];
        $notification=new OrderNotification($details);

         Notification::send($admin, $notification);

        Notification::send($admin,new MailNotification(['line'=>'بإرسال طلب ترقية الحساب  '.auth()->user()->name.'  قام ' ,'url'=>$details['actionUrl'],'url_text'=>'مشاهدة طريقة الدفع ']));

        session()->flash('success','تم ارسال طلب الترقيه بنجاح :)');

        return response()->json(['success'=>' تم إرسال طلب الترقية بنجاح ']);
    }


    public function markAsUnread()
    {
      foreach(auth()->user()->unReadNotifications as $notification)
      {
          $notification->markAsRead();
      }

       return response()->json(['success'=>'true']);
    }


    public function paymentAccept($id,$status){
      
            $payment=Payment::find($id);
            $payment->update(['is_accepted'=>$status]);
            $user=User::find($payment->user_id);
            $user->update(['is_promoted'=>$status]);
            $time=$payment->pakage->duration;

          if($promoted=PromotedUser::where('user_id',$user->id)->first())
          {
              if ($promoted->end_date > \Carbon\Carbon::now()->format('Y-m-d')){
                  //still active

                  //get days to add

                 $days_to_add =  \Carbon\Carbon::parse($promoted->end_date)->diffInDays(\Carbon\Carbon::now());

                  $promoted->update([
                      'pakage_id'=>$payment->pakage_id,
                      'start_date'=>\Carbon\Carbon::now()->format('Y-m-d'),
                      'end_date'=>\Carbon\Carbon::now()->addDays($time+$days_to_add)->format('y-m-d')]);
              }else{
                  $promoted->update([
                      'pakage_id'=>$payment->pakage_id,
                      'start_date'=>\Carbon\Carbon::now()->format('Y-m-d'),
                      'end_date'=>\Carbon\Carbon::now()->addDays($time)->format('y-m-d')]);
              }



          }
else
{

    $r=PromotedUser::create(['user_id'=>$user->id,'pakage_id'=>$payment->pakage_id,'start_date'=>\Carbon\Carbon::now()->format('Y-m-d'),'link'=>Str::random(6),'end_date'=>\Carbon\Carbon::now()->addDays($time)->format('y-m-d')]);


}

        $details=[
        'type'=>'payment','message'=>$payment->is_accepted==0?'تم رفض طلب الترقيه الخاص بك':'تم قبول طلب الترقيه الخاص بك'];
    
        Notification::send($user, new orderActionNotification($details));
        Notification::send($user,new MailNotification(['line'=> $details['message'],'url'=>`{{env("MAIN_URL")}}/`,'url_text'=>' الذهاب للموقع']));

         return back();


    }

public function show($id)
{
    $payment=Payment::find($id);
    $bankAccount=BankAccount::find($payment->bankAccount_id);

    return view('admin.payments.details',compact('payment','bankAccount'));

}

public function index()
{
    $payments= Payment::where('type',1)->where('is_accepted',1)->orwhere('is_accepted',2)->orderBy('created_at','desc')->get();
    return view('admin.payments.index',compact('payments'));


}

    public function pay(Request $request)
    {
        $cost = $request->price;
        $type = $request->type;
        $package = $request->package;

       $order =  Order::create([
            'package_id'=>$package, 
            'payment_type'=>$type ,
            'user_id'=>Auth::id()
        ]);
        return view('website.pay',compact('cost','type','package'));
    }

public function payresult()
    {
            $id = $_GET['id'];
            $url = "https://oppwa.com/v1/checkouts/$id/payment";
            $url .= "?entityId=8ac9a4ca7203c399017227bd00f87815";
        
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                           'Authorization:Bearer OGFjOWE0Y2U3MjAzYzM5NjAxNzIyN2FkNGRkMjY1MTJ8OGtQN1FnRFJnQQ=='));
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);// this should be set to true in production
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $responseData = curl_exec($ch);
            if(curl_errno($ch)) {
                return curl_error($ch);
            }
            curl_close($ch);
           
        $respone = json_decode($responseData, TRUE);
        
        if (in_array(json_decode($responseData)->result->code, $this->success) || in_array(json_decode($responseData)->result->code, $this->pending)) {
       
            if($this->AcceptPay()){
              return \redirect()->route('thanks');
            }
            


        }
       
        else{

                if($this->rejectPay())
                {
                return \redirect()->route('home'); 
                }
        }

    }



    public function payresult2()
    {
            $id = $_GET['id'];
            $url = "https://oppwa.com/v1/checkouts/$id/payment";
            $url .= "?entityId=8ac9a4ce7203c396017227ae31cd6525";
        
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                           'Authorization:Bearer OGFjOWE0Y2U3MjAzYzM5NjAxNzIyN2FkNGRkMjY1MTJ8OGtQN1FnRFJnQQ=='));
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);// this should be set to true in production
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $responseData = curl_exec($ch);
            if(curl_errno($ch)) {
                return curl_error($ch);
            }
            curl_close($ch);
           
        $respone = json_decode($responseData, TRUE);
        
        if (in_array(json_decode($responseData)->result->code, $this->success) || in_array(json_decode($responseData)->result->code, $this->pending)) {
       
            if($this->AcceptPay()){
              return \redirect()->route('thanks');
            }
            


        }
       
        else{

                if($this->rejectPay())
                {
                return \redirect()->route('home'); 
                }
        }

    }

    


    public function AcceptPay()
    {
        
        $order = Order::where('user_id',Auth::id())->first();
        $user_package = Pakage::where('id',$order->package_id)->first();
      
        $time=$user_package->duration;
        if ($promoted=PromotedUser::where('user_id', Auth::id())->first()) {
            if ($promoted->end_date > \Carbon\Carbon::now()->format('Y-m-d')) {
                $days_to_add =  \Carbon\Carbon::parse($promoted->end_date)->diffInDays(\Carbon\Carbon::now());
                $promoted->update([
                    'pakage_id'=>$user_package->id,
                    'start_date'=>\Carbon\Carbon::now()->format('Y-m-d'),
                    'end_date'=>\Carbon\Carbon::now()->addDays($time+$days_to_add)->format('y-m-d')]);
                    $user = Auth::user();
                    $user->update(['is_promoted'=>'1']);
            } else {
                $promoted->update([
                    'pakage_id'=>$user_package->id,
                    'start_date'=>\Carbon\Carbon::now()->format('Y-m-d'),
                    'end_date'=>\Carbon\Carbon::now()->addDays($time)->format('y-m-d')]);
            }
        } else {
            $r=PromotedUser::create(
                ['user_id'=>Auth::id(),
                'pakage_id'=>$user_package->id,
                'start_date'=>\Carbon\Carbon::now()->format('Y-m-d'),
                'link'=>Str::random(6),'end_date'=>\Carbon\Carbon::now()->addDays($time)->format('y-m-d')]);
                $user = Auth::user();
                $user->update(['is_promoted'=>'1']);
        }
        $order->delete();
        $details=[
            'type'=>'payment','message'=>'تم قبول طلب الترقيه الخاص بك'];
    
            Notification::send(Auth::user(), new orderActionNotification($details));
            Notification::send(Auth::user(),new MailNotification(['line'=> $details['message'],'url'=>`{{env("MAIN_URL")}}/`,'url_text'=>' الذهاب للموقع']));

             return true;
    
    }



    public function rejectPay()
    {
        
        $order = Order::where('user_id',Auth::id())->first();
       
        $order->delete();
        $details=[
            'type'=>'payment','message'=>'تم رفض  طلب الترقيه الخاص بك'];
    
            Notification::send(Auth::user(), new orderActionNotification($details));
         Notification::send(Auth::user(),new MailNotification(['line'=> $details['message'],'url'=>`{{env("MAIN_URL")}}/`,'url_text'=>' الذهاب للموقع']));

             return true;
    
    }

public function thanks()
{
    return view('website.thanks');
}
    
    public $success = [
        '000.000.000',
        '000.000.100',
        '000.100.110',
        '000.100.111',
        '000.100.112',
        '000.300.000',
        '000.300.100',
        '000.300.101',
        '000.300.102',
        '000.310.100',
        '000.310.101',
        '000.310.110',
        '000.600.000',
    ];
    public $waiting_for_review = [
        '000.400.000',
        '000.400.010',
        '000.400.020',
        '000.400.040',
        '000.400.050',
        '000.400.060',
        '000.400.070',
        '000.400.080',
        '000.400.081',
        '000.400.082',
        '000.400.090',
        '000.400.100',
    ];

    public $pending = [
        '000.200.000',
        '000.200.001',
        '000.200.100',
        '000.200.101',
        '000.200.102',
        '000.200.103',
        '000.200.200',
        '100.400.500',
        '800.400.500',
        '800.400.501',
        '800.400.502',
    ];

}
