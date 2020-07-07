<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Sms_mobily extends App_sms
{
    private $api_key;

    private $sender_id;

    private $requestURL = 'http://www.mobily.ws/api/msgSend.php';

    public function __construct()
    {
        parent::__construct();

        $this->sender_id = $this->get_option('mobily', 'sender_id');
        $this->api_key  = $this->get_option('mobily', 'api_key');

        $this->add_gateway('mobily', [
                'info'    => _l("sms_babil_sms_integration_is_one_way_messaging"),
                'name'    => 'Babil SMS',
                'options' => [
                    [
                        'name'  => 'sender_id',
                        'label' => _l('sms_sender_id_trans'),
                        // 'info'  => '<p><a href="https://help.mobily.com/article/40-what-is-a-sender-id-how-to-select-a-sender-id" target="_blank">https://help.mobily.com/article/40-what-is-a-sender-id-how-to-select-a-sender-id</a></p>',
                    ],
                     [
                        'name'  => 'api_key',
                        'label' => _l('sms_api_key_trans'),
                    ],
                ],
            ]);
    }

    public function send($number, $message)
    {
     
	   //الرسائل الناتجه من دالة الإرسال
        $arraySendMsg = array();
        $arraySendMsg[0] = "لم يتم الاتصال بالخادم";
        $arraySendMsg[1] = "تمت عملية الإرسال بنجاح";
        $arraySendMsg[2] = "رصيدك 0 , الرجاء إعادة التعبئة حتى تتمكن من إرسال الرسائل";
        $arraySendMsg[3] = "رصيدك غير كافي لإتمام عملية الإرسال";
        $arraySendMsg[4] = "رقم الجوال (إسم المستخدم) غير صحيح";
        $arraySendMsg[5] = "كلمة المرور الخاصة بالحساب غير صحيحة";
        $arraySendMsg[6] = "صفحة الانترنت غير فعالة , حاول الارسال من جديد";
        $arraySendMsg[7] = "نظام غير فعال";
        $arraySendMsg[8] = "تكرار رمز  لنفس المستخدم";
        $arraySendMsg[9] = "انتهاء الفترة التجريبية";
        $arraySendMsg[10] = "عدد الارقام لا يساوي عدد الرسائل";
        $arraySendMsg[11] = "اشتراكك لا يتيح لك ارسال رسائل لهذه. يجب عليك تفعيل الاشتراك لهذه";
        $arraySendMsg[12] = "إصدار البوابة غير صحيح";
        $arraySendMsg[13] = "الرقم المرسل به غير مفعل أو لا يوجد الرمز BS في نهاية الرسالة";
        $arraySendMsg[14] = "غير مصرح لك بالإرسال بإستخدام هذا المرسل";
        $arraySendMsg[15] = "الأرقام المرسل لها غير موجوده أو غير صحيحه";
        $arraySendMsg[16] = "إسم المرسل فارغ، أو غير صحيح";
        $arraySendMsg[17] = "نص الرسالة غير متوفر أو غير مشفر بشكل صحيح";
        $arraySendMsg[18] = "تم ايقاف الارسال من المزود";
        $arraySendMsg[19] = "لم يتم العثور على مفتاح نوع التطبيق";

        
        // is_numeric($this->set_two_factor_auth_code($userdata->staffid,2)) ? $code= $this->set_two_factor_auth_code($userdata->staffid,2) : "Unavailable";
        $numbers = $number;
        // $msg = 'Your verification code is: ' . $code;
        $msg = $message;
        $MsgID = time();//rand(1, 99999);
        $timeSend = 0;
        $dateSend = 0;
        $deleteKey = 0;
        $viewResult = 0;

        $url = "www.mobily.ws/api/msgSend.php";
        $applicationType = "68";
        $sender = urlencode($this->sender_id);
        $domainName = $_SERVER['SERVER_NAME'];
        // $stringToPost = "mobile=" . $userAccount . "&password=" . $passAccount . "&numbers=" . $numbers . "&sender=" . $sender . "&msg=" . $msg . "&timeSend=" . $timeSend . "&dateSend=" . $dateSend . "&applicationType=" . $applicationType . "&domainName=" . $domainName . "&msgId=" . $MsgID . "&deleteKey=" . $deleteKey . "&lang=3";

        $stringToPost = "apiKey=" . $this->api_key . "&numbers=" . $numbers . "&sender=" . $sender . "&msg=" . $msg . "&timeSend=" . $timeSend . "&dateSend=" . $dateSend . "&applicationType=" . $applicationType . "&domainName=" . $domainName . "&msgId=" . $MsgID . "&deleteKey=" . $deleteKey . "&lang=3";


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $stringToPost);
        // var_dump($stringToPost);
        // die();
        $result = curl_exec($ch);

        if ($viewResult)
            $result = $this->printStringResult(trim($result), $arraySendMsg);
        
       
        return $result;
    }

    public function printStringResult($apiResult, $arrayMsgs, $printType = 'Alpha')
    {
        global $undefinedResult;
        switch ($printType) {
            case 'Alpha': {
                if (array_key_exists($apiResult, $arrayMsgs))
                    return $arrayMsgs[$apiResult];
                else
                    return $arrayMsgs[0];
            }
                break;

            case 'Balance': {
                if (array_key_exists($apiResult, $arrayMsgs))
                    return $arrayMsgs[$apiResult];
                else {
                    list($originalAccount, $currentAccount) = explode("/", $apiResult);
                    if (!empty($originalAccount) && !empty($currentAccount)) {
                        return sprintf($arrayMsgs[3], $currentAccount, $originalAccount);
                    } else
                        return $arrayMsgs[0];
                }
            }
                break;

            case 'Senders': {
                $apiResult = str_replace('[pending]', '[pending]<br>', $apiResult);
                $apiResult = str_replace('[active]', '<br>[active]<br>', $apiResult);
                $apiResult = str_replace('[notActive]', '<br>[notActive]<br>', $apiResult);
                return $apiResult;
            }
                break;

            case 'Normal':
                if ($apiResult{0} != '#')
                    return $arrayMsgs[$apiResult];
                else
                    return $apiResult;
                break;
        }
    }

}
