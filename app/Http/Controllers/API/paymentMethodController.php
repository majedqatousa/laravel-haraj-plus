<?php

namespace App\Http\Controllers\API;

use App\Classes\FileOperations;
use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use App\Models\Order;
use App\Models\Pakage;
use App\Models\Payment;
use App\Models\PromotedUser;
use App\User;
use Facade\Ignition\Support\Packagist\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class paymentMethodController extends Controller
{

    public function store(Request $request)
    {
        $roles = [
            'money_amount' => 'required|min:1',
            'transfer_date' => 'required|date',
            'transferee_name' => 'required',
            // 'image' => 'required|image',
            'bank_no' => 'required|int',
        ];
        $validator = Validator::make($request->all(), $roles);
        if (!$validator->fails()) {

            $requestData = $request->all();
            $requestData['transfer_date'] = date('Y-m-d H:i:s', strtotime($requestData['transfer_date']));

            if (strtotime($request->transfer_date) - time() > 0) {
                session()->flash('failed', 'يجب ادخال تاريخ صالح');
                return back();
            }

            $requestData['image'] = FileOperations::StoreFileAs('website/payments', $request->image, Str::random(7));
            $requestData['type'] = 1;
            $requestData['user_id'] = auth()->id();
            $requestData['paymentMethod'] = 1;
            $admin = User::where('type', 1)->first();
            $payment = Payment::create($requestData);
            if (User::find(auth()->id())->is_promoted != 1) {
                User::find(auth()->id())->update(['is_promoted' => 2]);

                return ControllersService::generateProcessResponse(true, 'CREATE_SUCCESS');
            } else {
                return ControllersService::generateProcessResponse(true, 'CREATE_FAILED');
            }
        } else {
            return ControllersService::generateValidationErrorMessage($validator->getMessageBag()->first());
        }
    }
    public function packge()
    {
         $packge = Pakage::all();
        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $packge
        ]);
    }
    public function checkOutId(Request $request)
    {
        $url = "https://test.oppwa.com/v1/checkouts";
        $data = "entityId=8a8294174d0595bb014d05d829cb01cd" .
            "&amount=" . $request->get('amount') .
            "&currency=SAR" .
            "&paymentType=" . $request->get('type') .
            // "&notificationUrl=http://www.example.com/notify";

            $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:Bearer OGE4Mjk0MTc0ZDA1OTViYjAxNGQwNWQ4MjllNzAxZDF8OVRuSlBjMm45aA=='
        ));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt(
            $ch,
            CURLOPT_SSL_VERIFYPEER,
            false
        ); // this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        $response = json_decode($responseData);
        //  $code= $response['result']['code'];
        if (in_array($response->result->code, $this->pending)) {
            return response()->json([
                'status' => true,
                'checkout_id' => $response->id
            ]);
        } else {
            return response()->json([
                'status' => false,
            ]);
        }
    }

    public function getPaymentStatus(Request $request)
    {
        $id = $request->get('id');
        $url = "https://test.oppwa.com/v1/checkouts/$id/payment";
        $url .= "?entityId=8a8294174d0595bb014d05d829cb01cd";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:Bearer OGE4Mjk0MTc0ZDA1OTViYjAxNGQwNWQ4MjllNzAxZDF8OVRuSlBjMm45aA=='
        ));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        $response = json_decode($responseData, true);
        $code = $response['result']['code'];
        if (in_array($code, $this->pending)) {
            return $response;
        } elseif ($code == '000.000.000') {
            $amount = $request->amount;
            $paymentType = $request->type;
            if ($paymentType == 'DB') {
                $type = 'بطاقة فيزا';
            } elseif ($paymentType == 'PA') {
                $type = 'بطاقة ماستركارد او مدى';
            }
            $package = $request->package;
            $order = new Order();
            $order->package_id = $package;
            $order->payment_type = $type;
            $order->user_id = Auth::user('user_api')->id;
            $order->save();


            $this->AcceptPay($package, $order);
            return response()->json([
                'status' => true,
                'message' => 'تمت العمليه بنجاح',
            ]);
        } else {
            return response()->json([
                'status' => false,
            ]);
        }
    }
    
    public function AcceptPay($package)
    {

        $order = Order::where('user_id', Auth::id())->first();
        $user_package = Pakage::where('id', $package)->first();

        $time = $user_package->duration;
        if ($promoted = PromotedUser::where('user_id', Auth::id())->first()) {
            if ($promoted->end_date > \Carbon\Carbon::now()->format('Y-m-d')) {
                $days_to_add =  \Carbon\Carbon::parse($promoted->end_date)->diffInDays(\Carbon\Carbon::now());
                $promoted->update([
                    'pakage_id' => $user_package->id,
                    'start_date' => \Carbon\Carbon::now()->format('Y-m-d'),
                    'end_date' => \Carbon\Carbon::now()->addDays($time + $days_to_add)->format('y-m-d')
                ]);
                $user = Auth::user();
                $user->Update(['is_promoted' => '1']);
            } else {
                $promoted->update([
                    'pakage_id' => $user_package->id,
                    'start_date' => \Carbon\Carbon::now()->format('Y-m-d'),
                    'end_date' => \Carbon\Carbon::now()->addDays($time)->format('y-m-d')
                ]);
            }
        } else {
            $r = PromotedUser::create(
                [
                    'user_id' => Auth::id(),
                    'pakage_id' => $user_package->id,
                    'start_date' => \Carbon\Carbon::now()->format('Y-m-d'),
                    'link' => Str::random(6), 'end_date' => \Carbon\Carbon::now()->addDays($time)->format('y-m-d')
                ]
            );
            $user = Auth::user();
            $user->update(['is_promoted' => '1']);
        }
        $order->delete();


        return true;
    }



    public function rejectPay()
    {

        $order = Order::where('user_id', Auth::id())->first();

        $order->delete();

        return true;
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
