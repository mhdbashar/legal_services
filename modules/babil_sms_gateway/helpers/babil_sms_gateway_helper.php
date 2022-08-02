<?php

function _get_messages()
{

    $received_url = get_option('new_gateway') ? 'https://gateway.babiltec.com/api/get/sms.received?secret='.get_option('receive_sms_token').'&limit=100' : 'https://sms.babiltec.com/api/get/received?key='.get_option('receive_sms_token').'&limit=100';
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => $received_url,
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
        if($result->status != 200)
        {
            return $result->message;
        }
        else {
            return $result->data;
        }
    }
    return 'Something went wrong';

}


function _get_sms($id)
{
    $received_url = get_option('new_gateway') ? 'https://gateway.babiltec.com/api/get/sms.received?secret='.get_option('receive_sms_token').'&limit=100' : 'https://sms.babiltec.com/api/get/received?key='.get_option('receive_sms_token').'&limit=100';

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => $received_url,
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
        if($result->status != 200)
        {
            return $result->message;
        }
        if(isset($result->data)){

            foreach($result->data as $key => $message)
            {
                if($message->id == $id)
                {
                    return $message;
                }
            }

        }
    }
    return 'Something went wrong';

}


function _get_whatsapp_messages()
{

    $received_url = 'https://gateway.babiltec.com/api/get/wa.received?secret='.get_option('receive_sms_token').'&limit=100';
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => $received_url,
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
        if($result->status != 200)
        {
            return $result->message;
        }
        else {
            return $result->data;
        }
    }
    return 'Something went wrong';

}


function _get_whatsapp_sms($id)
{
    $received_url = 'https://gateway.babiltec.com/api/get/wa.received?secret='.get_option('receive_sms_token').'&limit=100';

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => $received_url,
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
        if($result->status != 200)
        {
            return $result->message;
        }
        if(isset($result->data)){

            foreach($result->data as $key => $message)
            {
                if($message->id == $id)
                {
                    return $message;
                }
            }

        }
    }
    return 'Something went wrong';

}