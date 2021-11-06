<?php


use App\Models\DeactivateUser;
use App\Models\PromotedUser;
use App\Models\Setting;
use App\User;

function null_string($item)
{
    return blank($item) ? '' : $item;
}

  function uploadImg($request, $img_name,$foldername)
{

    $path = \Storage::disk('public')->putFile('uploads/'.$foldername, $request->file($img_name));
    return $path;
}


function deleteImg($img_name)
{
    \Storage::disk('public')->delete('uploads', $img_name);
    return True;
}

  function getImgPath($img)
{
    if (is_null($img)) {
        return '';
    }
    return url('/') . '/storage/'. $img;
}

function getSetting($key)
{
	return \App\Models\Setting::where('setting_key',$key)->value('setting_value');
}

function searchFor($query, $col,$word)
{
	$query->where($col, 'LIKE', '%'.$word.'%');
	return $query;
}


function PromotedTime(){
    $user =PromotedUser::where('user_id',auth()->id())->first();


    $end_date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $user->end_date);
    return  $end_date->diffInDays(\Carbon\Carbon::now(), false);

}


function checkProductsNo(){
    $user=User::find(auth()->id());
    $product_no=Setting::where('key','product_no')->first()->value;

    $products=count($user->products);


    if($products<$product_no)
        //dd('jj');
        return true;
            else
              return false;

}

function chekProductsPerMonth(){
    $user = \Illuminate\Support\Facades\Auth::user();
    //get user subscription day
    $subscription_day = $user->created_at->day;
    $crrent_day = date('d');
    $crrent_month = date('m');
    $stat_month = date('m');
    $current_year = date('y');
    $end_month = $stat_month+1;
    if($crrent_day<$subscription_day){
        $stat_month-=1;
        $end_month = $stat_month+1;

    }
    $start_date =  strtotime("$stat_month/$subscription_day/$current_year");
    $start_date =  date('Y-m-d',$start_date);
    $end_date =  strtotime("$end_month/$subscription_day/$current_year");
    $end_date =  date('Y-m-d',$end_date);

    $product_no=\App\Models\Setting::where('key','product_no')->first()->value;
    $user_products=\App\Models\Product::where('user_id',$user->id)->where('user_promoted',0)->whereBetween('created_at',[$start_date,$end_date])->get();

    $products=count($user_products);
    if ($products>$product_no  && $user->is_promoted==0){
        return false;
    }else{
        return true;
    }




}//end chekProductsPerMonth function
function countProductsPerMonth(){
    $user = \Illuminate\Support\Facades\Auth::user();
    //get user subscription day
    $subscription_day = $user->created_at->day;
    $crrent_day = date('d');
    $crrent_month = date('m');
    $stat_month = date('m');
    $current_year = date('y');
    $end_month = $stat_month+1;
    if($crrent_day<$subscription_day){
        $stat_month-=1;
        $end_month = $stat_month+1;

    }
    $start_date =  strtotime("$stat_month/$subscription_day/$current_year");
    $start_date =  date('Y-m-d',$start_date);
    $end_date =  strtotime("$end_month/$subscription_day/$current_year");
    $end_date =  date('Y-m-d',$end_date);

    $product_no=\App\Models\Setting::where('key','product_no')->first()->value;
    $user_products=\App\Models\Product::where('user_id',$user->id)->where('user_promoted',0)->whereBetween('created_at',[$start_date,$end_date])->get();

    $products=count($user_products);
    if ($products>$product_no  && $user->is_promoted==0){
        return false;
    }else{
        return $product_no-$products;
    }




}//end countProductsPerMonth


function format_number($number){
//check update 
    if (strlen($number) == 10 && starts_with($number, '05')){
        return preg_replace('/^0/', '+966', $number);
    }
    elseif (strlen($number) == 9 && starts_with($number, '5')){
        return preg_replace('/^5/', '+96605', $number);
    }
    
    elseif (starts_with($number, '06')){
        return preg_replace('/^06/', '+966', $number);
    }
    elseif (starts_with($number, '00')){
        return preg_replace('/^00/', '+', $number);
    }
   elseif (starts_with($number, '+')){
        return preg_replace('/[+]/', '', $number);
    }

    return $number;
}


//  function setPhone($phone,$key){
//         if(is_array($phone)){
//             return implode(";", $this->phoneFormat($phone ,$key));
//         }else{
//             return $key . ltrim($phone, '0');
//         }
//     }

//     function phoneFormat($phones) {
//         return array_map(function($val) { return '966' . ltrim($val, '0') ; }, $phones);
//     }



function block($body,$data,$type){


    if($user=DeactivateUser::where('user_id',$body->user->id)->where('type',$type)->first())
        $user->update(['period'=>$data['period']]);
    else
        DeactivateUser::create(['user_id'=>$body->user->id,'type'=>$type,'period'=>$data['period']]);




}





function sendSMS($numbers, $msg, $timeSend=0, $dateSend=0, $deleteKey=0, $viewResult=1)
{

		$client = new \GuzzleHttp\Client();
		$url = "http://api.yamamah.com/SendSMSV2?Username=966505754748&Password=S!c7q6@xNjuC&Tagname=haraj-plus&RecepientNumber=$numbers&Message=$msg&SendDateTime=0&EnableDR=true&SentMessageID=true";

		$request = $client->get($url ,[
		'form_params' => [
				'_token' => csrf_field()
		]
		]);


}







function payrequest($cost ,$type) {

    $entity = $type == 'بطاقة مدى'
?'8ac9a4ca7203c399017227bd00f87815' :'8ac9a4ce7203c396017227ae31cd6525';
    $url = "https://oppwa.com/v1/checkouts";
	$data = "entityId=$entity" .
                "&amount=$cost" .
                "&merchantTransactionId=" . md5(time()) .
                "&currency=SAR" .
                "&paymentType=DB";

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                   'Authorization:Bearer OGFjOWE0Y2U3MjAzYzM5NjAxNzIyN2FkNGRkMjY1MTJ8OGtQN1FnRFJnQQ=='));
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);// this should be set to true in production
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$responseData = curl_exec($ch);
	if(curl_errno($ch)) {
		return curl_error($ch);
	}
    curl_close($ch);
    
	return $responseData;
}