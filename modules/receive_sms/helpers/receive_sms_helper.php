<?php

function get_messages()
{
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://semysms.net/api/3/inbox_sms.php?token='.get_option('receive_sms_token').'&device=' . get_option('receive_sms_device'),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    $result = json_decode($response);
    if(is_object($result))
    {
        if(isset($result->error))
        {
            return $result->error;
        }
        if(isset($result->data)){
            return $result->data;
        }
    }
    return 'Something went wrong';

}