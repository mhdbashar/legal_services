<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Sms_clickatell extends App_sms
{
    private $api_key;

    private $requestURL = 'https://platform.clickatell.com/messages/http/send';

    public function __construct()
    {
        parent::__construct();

        $this->api_key = $this->get_option('clickatell', 'api_key');

        $this->add_gateway('clickatell', [
            'info'    => _l("sms_clickatell_sms_integration_is_one_way_messaging"),
            'name'    => 'Clickatell',
            'options' => [
                [
                    'name'  => 'api_key',
                    'label' => _l('sms_api_key_trans'),
                ],
            ],
        ]);
    }

    public function send($number, $message)
    {
        try {
            $response = $this->client->request('GET', $this->requestURL, [
                'headers' => [
                    'X-Version' => '1',
                ],
                'query' => [
                    'apiKey'  => $this->api_key,
                    'to'      => $number,
                    'content' => $message,
                ],
            ]);

            $result = json_decode($response->getBody());
            $error  = false;

            if ($result) {
                if (isset($result->messages[0]->accepted) && $result->messages[0]->accepted == true) {
                    $this->logSuccess($number, $message);

                    return true;
                } elseif (isset($result->messages) && isset($result->error)) {
                    $error = $result->error;
                } elseif (isset($result->messages[0]->error) && $result->messages[0]->error != null) {
                    $error = $result->messages[0]->error;
                }
            }
        } catch (\Exception $e) {
            $response = json_decode($e->getResponse()->getBody()->getContents(), true);
            $error    = $response['message'];
        }

        if ($error !== false && $error !== null) {
            $this->set_error($error);
        }

        return false;
    }
}
