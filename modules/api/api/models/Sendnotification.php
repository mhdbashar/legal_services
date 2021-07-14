<?php defined('BASEPATH') OR exit('No direct script access allowed');

Class Sendnotification extends CI_Model

{

    public function __construct() {

        parent::__construct();

     }


function send_fcm($message,$tokens,$Title,$Key)
          {

        $url = "https://fcm.googleapis.com/fcm/send";
        $token = $tokens;
        $serverKey=$Key;
        // $serverKey = 'AAAA7F0wBQ4:APA91bEXn8WUGHtaRqD3ku8VM5fH9SYxNSsNtiHEwDmpcCUO6ju0ZWpUVwX2I_8KMbGXUFNwiE12i7xkej-aFL41EZ4MQr0EGeMf2kClrF2MoTv2WDfKwpsGl1O0koEpagHXCoOODr0h';
        $title = $title;
        $body = $message;
        $notification = array('title' =>$title , 'text' => $body, 'sound' => 'default', 'badge' => '1');
        $arrayToSend = array('to' => $token, 'notification' => $notification,'priority'=>'high','data'=>array(
                'click_action'=>'FLUTTER_NOTIFICATION_CLICK',
                
              ));
    
        $json = json_encode($arrayToSend);
        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: key='. $serverKey;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
        //Send the request
        $response = curl_exec($ch);
        //Close request
        if ($response === FALSE) {
            die('FCM Send Error: ' . curl_error($ch));
        }
        curl_close($ch);
  }


   

}