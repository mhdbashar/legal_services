<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Sms_twilio extends App_sms
{
    // Account SID from twilio.com/console
    private $sid;

    // Auth Token from twilio.com/console
    private $token;

    // Twilio Phone Number
    private $phone;

    public function __construct()
    {
        parent::__construct();

        $this->sid   = $this->get_option('twilio', 'account_sid');
        $this->token = $this->get_option('twilio', 'auth_token');
        $this->phone = $this->get_option('twilio', 'phone_number');

        $this->add_gateway('twilio', [
            'name'    => 'Twilio',
            'info'    => _l('sms_twilio_sms_integration_is_one_way_messaging',"https://www.twilio.com/docs/glossary/what-e164"),
            'options' => [
                [
                    'name'  => 'account_sid',
                    'label' => 'Account SID',
                ],
                [
                    'name'  => 'auth_token',
                    'label' => 'Auth Token',
                ],
                [
                    'name'  => 'phone_number',
                    'label' => 'Twilio Phone Number',
                ],
            ],
        ]);
    }

    public function send($number, $message)
    {
        try {
            $client = new Twilio\Rest\Client($this->sid, $this->token);
        } catch (Exception $e) {
            $this->set_error($e->getMessage(), false);

            return false;
        }

        try {
            $client->messages->create(
                // The number to send the SMS
                $number,
                [
                     // A Twilio phone number you purchased at twilio.com/console
                    'from' => $this->phone,
                    'body' => $message,
                ]
            );

            $this->logSuccess($number, $message);
        } catch (Exception $e) {
            $this->set_error($e->getMessage());

            return false;
        }

        return true;
    }
}
