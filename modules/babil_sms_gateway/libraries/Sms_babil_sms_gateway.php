<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Sms_babil_sms_gateway extends App_sms
{
    public function __construct()
    {
        parent::__construct();

        $this->babil_sms_gateway_key = $this->get_option("babil_sms_gateway", "babil_sms_gateway_key");
        $this->babil_sms_gateway_sim = $this->get_option("babil_sms_gateway", "babil_sms_gateway_sim");
        $this->babil_sms_gateway_priority = $this->get_option("babil_sms_gateway", "babil_sms_gateway_priority");

        $this->add_gateway("babil_sms_gateway", [
            "name" => "BabilSMS",
            "options" => [
                [
                    "name" => "babil_sms_gateway_key",
                    "label" => "API Key (<a href=\"https://sms.babiltec.com/dashboard/tools\" target=\"_blank\">Create API Key</a>)",
                    "info" => "
                    <p>Your API key, please make sure that everything is correct and required permissions are granted.</p>
                    <hr class=\"hr-10\" />"
                ],               
                [
                    "name" => "babil_sms_gateway_sim",
                    "field_type" => "radio",
                    "default_value" => 1,
                    "label" => "SIM Slot",
                    "options" => [
                        ["label" => "SIM 1", "value" => 1],
                        ["label" => "SIM 2", "value" => 2]
                    ],
                    "info" => "
                    <p>Select the sim slot you want to use for sending the messages.</p>
                    <hr class=\"hr-10\" />"
                ],
                [
                    "name" => "babil_sms_gateway_priority",
                    "field_type" => "radio",
                    "default_value" => 1,
                    "label" => "Priority Send",
                    "options" => [
                        ["label" => "Yes", "value" => 1],
                        ["label" => "No", "value" => 2]
                    ],
                    "info" => "
                    <p>Send messages as priority, these messages will be sent before anything else.</p>
                    <hr class=\"hr-10\" />"
                ]
            ],
        ]);
    }

    public function send($number, $message)
    {
        $sim_path = empty($this->babil_sms_gateway_sim) || $this->babil_sms_gateway_sim < 2 ? "&sim=1" : "&sim=2";
        $priority_path = empty($this->babil_sms_gateway_priority) || $this->babil_sms_gateway_priority < 2 ? "&priority=1" : false;

        try {
            $client = new GuzzleHttp\Client();

            $send = json_decode($client->get("https://sms.babiltec.com/api/send?key={$this->babil_sms_gateway_key}&phone={$number}&message={$message}{$sim_path}{$priority_path}", [
                "allow_redirects" => true,
                "http_errors" => false
            ])->getBody()->getContents(), true);

            if($send["status"] == 200):
                log_activity("SMS sent via BabilSMS to {$number} with message: {$message}");

                return 1;
            else:
            
                $this->set_error("Message was not sent!<br>Message: {$send["message"]}");

                return false;
            endif;
        } catch(Exception $e){
            $this->set_error("Message was not sent!<br>Error: {$e->getMessage()}");
            return false;
            
        }
    }

}