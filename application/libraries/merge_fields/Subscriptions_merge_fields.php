<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Subscriptions_merge_fields extends App_merge_fields
{
    public function build()
    {
        return  [
                [
                    'name'      => _l('subscription_id'),
                    'key'       => '{subscription_id}',
                    'available' => [
                        'subscriptions',
                    ],
                ],
                [
                    'name'      => _l('subscription_name'),
                    'key'       => '{subscription_name}',
                    'available' => [
                        'subscriptions',
                    ],
                ],
                [
                    'name'      => _l('subscription_description'),
                    'key'       => '{subscription_description}',
                    'available' => [
                        'subscriptions',
                    ],
                ],
                [
                    'name'      => _l('subscription_subscribe_link'),
                    'key'       => '{subscription_link}',
                    'available' => [
                        'subscriptions',
                    ],
                ],
                [
                    'name'      => _l('subscription_authorization_link'),
                    'key'       => '{subscription_authorize_payment_link}',
                    'available' => [
                    ],
                    'templates' => ['subscription-payment-requires-action'],
                ],
            ];
    }

    /**
     * Subscription merge fields merge fields
     * @param  mixed id
     * @return array
     */
    public function format($id, $confirmation_link = '')
    {
        if (!class_exists('subscriptions_model')) {
            $this->ci->load->model('subscriptions_model');
        }
        $fields       = [];
        $subscription = $this->ci->subscriptions_model->get_by_id($id);

        if (!$subscription) {
            return $fields;
        }

        $fields['{subscription_authorize_payment_link}'] = '';

        if ($confirmation_link) {
            $fields['{subscription_authorize_payment_link}'] = $confirmation_link;
        }

        $fields['{subscription_link}']        = site_url('subscription/' . $subscription->hash);
        $fields['{subscription_id}']          = $subscription->id;
        $fields['{subscription_name}']        = $subscription->name;
        $fields['{subscription_description}'] = $subscription->description;

        return hooks()->apply_filters('subscription_merge_fields', $fields, [
        'id'           => $id,
        'subscription' => $subscription,
     ]);
    }
}
