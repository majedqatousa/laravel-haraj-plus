<?php

namespace App\Http\Controllers\API;

use GuzzleHttp\Client;

class SmsController
{
    public static $ACTIVATION_CODE = 1;
    public static $PASSWORD_RESET_CODE = 2;
    public static $LOGIN_CODE = 3;
    public static $BRANCH_ACCEPTED = 4;
    public static $MOBILE_NUMBER_CHANGED = 5;
    public static $CUSTOMER_WELCOME_MESSAGE = 6;
    public static $NEW_ORDER_MESSAGE = 7;
    public static $GENERATE_PASSWORD = 8;

    public static function sendSmsCodeMessage($mobile_number, $messageType, $userType = "user", $email = "")
    {
        $generatedData = "";
        if ($messageType == self::$GENERATE_PASSWORD) {
            $generatedData = self::generateRandomPassword();
        } else {
            $generatedData = self::generateRandomNumber();
        }
        $MESSAGE = self::generateMessage($messageType, $userType, $email, $generatedData);

        $resp = self::sendSmsMessage($mobile_number, $MESSAGE);

        if (substr($resp, 0, 1) == 0) {
            return $generatedData;
        } else {
            return false;
        }
    }

    public static function sendSmsMessages($mobile_number, $messageType)
    {
        $MESSAGE = self::generateMessage($messageType);
        $resp = self::sendSmsMessage($mobile_number, $MESSAGE);
        if (substr($resp, 0, 1) == 0) {
            return true;
        } else {
            return false;
        }
    }

    private static function generateRandomNumber()
    {
        $number = mt_rand(1000, 9999);
        return "" . $number;
    }

    private static function generateRandomPassword()
    {
        $password = str_random(6);
        return "" . $password;
    }

    /**
     * @param $messageType
     * @param $userType
     * @param $email
     * @param $code
     * @return string
     */
    public static function generateMessage($messageType, $userType = 'Customer', $email = '', $code = ''): string
    {
        $MESSAGE = "";
        switch ($messageType) {
            case self::$LOGIN_CODE:
                $MESSAGE = "أهلا و سهلا بك في تطبيق حراج بلس, رمز تسجيل الدخول الخاص بك هو: " . $code;
                break;

            case self::$GENERATE_PASSWORD:
                $MESSAGE = "أهلا و سهلا بك في تطبيق حراج بلس, كلمة المرور الخاصة بحسابك هي: " . $code . "  ترسل هذه الرسالة لمرة واحدة و سيتم اعتماد كلمة المرور, يمكنك تغيرها من خلال التطبيق.";
                break;

            case self::$ACTIVATION_CODE:
                $MESSAGE = "أهلا و سهلا بك في نظام حراج بلس, رمز تفعيل الحساب الخاص بك هو: " . $code;
                break;

            case self::$PASSWORD_RESET_CODE:
                $MESSAGE = "أهلا و سهلا بك في نظام حراج بلس, رمز تعديل كلمة المرور الخاصة بك هو: " . $code;
                break;

            case self::$BRANCH_ACCEPTED:
                $MESSAGE = "أهلا و سهلا بك في نظام حراج بلس, تم قبول طلبكم بإضافة الفرع الجديد الى نظام المتجر الخاص بك." . $code;
                break;

            case self::$MOBILE_NUMBER_CHANGED:
                $MESSAGE = "أهلا و سهلا بك في نظام حراج بلس, رمز تفعيل رقم الجوال الجديد هو: " . $code;
                break;

            case self::$CUSTOMER_WELCOME_MESSAGE:
                $MESSAGE = "تهانينا, لقد تم تفعيل حسابكم بنجاح, حراج بلس سعيد بانضمامكم.";
                break;

            case self::$NEW_ORDER_MESSAGE:
                $MESSAGE = "أهلا و سهلا بك في نظام حراج بلس, رمز تأكيد الطلب الخاص بك هو:  " . $code;
                break;
        }
        return $MESSAGE;
    }

    /**
     * @param $mobile_number
     * @param $message
     * @return mixed
     */
    private static function sendSMSMessage($mobile_number, $message)
    {
        $USER_NAME = "966505754748";
        $PASSWORD = "S!c7q6@xNjuC";
        $SENDER = "Haraj_plus";
        $MESSAGE = $message;
        $NUMBER = "9665" . $mobile_number;

        $URL = "http://api.yamamah.com/SendSMS=" . $USER_NAME . "&Password=" . $PASSWORD . "&Tagname=" . $SENDER . "&RecepientNumber=" . $NUMBER . "&Message=" . $MESSAGE . "&EnableDR=False";
         $content = 'Send Msg Mobile';
        $statusCode = 200;
        return response()->json(['status' => $statusCode, 'content' => $content]);
        // $client = new Client();
        //  $response = $client->request('GET', $URL);
        // $statusCode = $response->getStatusCode();
        // $content = $response->getBody();

        // return response()->json(['status' => $statusCode, 'content' => $content]);

//        return response()->json(['status' => $resp]);
    }


    // public static function getSmsBalance(){
    //     $USER_NAME = "---";
    //     $PASSWORD = "---";

    //     $URL = "http://api.mtcsms.com/balance.aspx?username=" . $USER_NAME . "&password=" . $PASSWORD;

    //     $client = new Client();
    //     $response = $client->request('GET', $URL);
    //     $statusCode = $response->getStatusCode();
    //     $content = $response->getBody();

    //     $balance = explode('@', $content);

    //     return "".$balance[1];
    // }
}
