<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dispute_merge_fields extends App_merge_fields
{
    public function build()
    {
        return [
                [
                    'name'      => _l('invoice_link'),
                    'key'       => '{invoice_link}',
                    'available' => [
                        'invoice',
                        'dispute'
                    ],
                    'templates' => [
                        'subscription-payment-succeeded',
                    ],
                ],
                [
                    'name'      => _l('invoice_number'),
                    'key'       => '{invoice_number}',
                    'available' => [
                        'invoice',
                        'dispute'
                    ],
                    'templates' => [
                        'subscription-payment-succeeded',
                    ],
                ],
                [
                    'name'      => _l('invoice_duedate'),
                    'key'       => '{invoice_duedate}',
                    'available' => [
                        'invoice',
                        'dispute'
                    ],
                ],
                [
                    'name'      => _l('invoice_date'),
                    'key'       => '{invoice_date}',
                    'available' => [
                        'invoice',
                        'dispute'
                    ],
                    'templates' => [
                        'subscription-payment-succeeded',
                    ],

                ],
                [
                    'name'      => _l('invoice_status'),
                    'key'       => '{invoice_status}',
                    'available' => [
                        'invoice',
                        'dispute'
                    ],
                    'templates' => [
                        'subscription-payment-succeeded',
                    ],
                ],
                [
                    'name'      => _l('invoice_sale_agent'),
                    'key'       => '{invoice_sale_agent}',
                    'available' => [
                        'invoice',
                        'dispute'
                    ],
                ],
                [
                    'name'      => _l('invoice_total'),
                    'key'       => '{invoice_total}',
                    'available' => [
                        'invoice',
                        'dispute'
                    ],
                    'templates' => [
                        'subscription-payment-succeeded',
                    ],
                ],
                [
                    'name'      => _l('invoice_subtotal'),
                    'key'       => '{invoice_subtotal}',
                    'available' => [
                        'invoice',
                        'dispute'
                    ],
                    'templates' => [
                        'subscription-payment-succeeded',
                    ],
                ],
                [
                    'name'      => _l('invoice_amount_due'),
                    'key'       => '{invoice_amount_due}',
                    'available' => [
                        'invoice',
                        'dispute'
                    ],
                ],
                [
                    'name'      => _l('payment_recorded_total'),
                    'key'       => '{payment_total}',
                    'available' => [

                    ],
                    'templates' => [
                        'subscription-payment-succeeded',
                        'invoice-payment-recorded-to-staff',
                        'invoice-payment-recorded',
                    ],
                ],
                [
                    'name'      => _l('payment_recorded_date'),
                    'key'       => '{payment_date}',
                    'available' => [

                    ],
                    'templates' => [
                        'subscription-payment-succeeded',
                        'invoice-payment-recorded-to-staff',
                        'invoice-payment-recorded',
                    ],
                ],
                [
                    'name'      => 'Project name',
                    'key'       => '{service_name}',
                    'available' => [
                        'invoice',
                        'dispute'
                    ],
                ],
            ];
    }

    /**
     * Merge fields for invoices
     * @param  mixed $invoice_id invoice id
     * @param  mixed $payment_id payment id
     * @return array
     */
    public function format($invoice_id, $payment_id = false)
    {
        $fields = [];
        $this->ci->db->where('id', $invoice_id);
        $invoice = $this->ci->db->get(db_prefix().'my_project_invoices')->row();

        if (!$invoice) {
            return $fields;
        }

        $currency = get_currency($invoice->currency);

        $fields['{payment_total}'] = '';
        $fields['{payment_date}']  = '';

        if ($payment_id) {
            $this->ci->db->where('id', $payment_id);
            $payment = $this->ci->db->get(db_prefix().'invoicepaymentrecords')->row();

            $fields['{payment_total}'] = app_format_money($payment->amount, $currency);
            $fields['{payment_date}']  = _d($payment->date);
        }

        $fields['{invoice_amount_due}'] = app_format_money(get_invoice_total_left_to_pay($invoice_id, $invoice->total), $currency);
        $fields['{invoice_sale_agent}'] = get_staff_full_name($invoice->sale_agent);
        $fields['{invoice_total}']      = app_format_money($invoice->total, $currency);
        $fields['{invoice_subtotal}']   = app_format_money($invoice->subtotal, $currency);

        $fields['{invoice_link}']    = site_url('invoice/' . $invoice_id . '/' . $invoice->hash);
        $fields['{invoice_number}']  = format_dispute_invoice_number($invoice_id);
        $fields['{invoice_duedate}'] = _d($invoice->duedate);
        $fields['{invoice_date}']    = _d($invoice->date);
        $fields['{invoice_status}']  = format_invoice_status($invoice->status, '', false);
        $fields['{service_name}']    = get_project_name_by_id($invoice->project_id);
        
        $custom_fields = get_custom_fields('invoice');
        foreach ($custom_fields as $field) {
            $fields['{' . $field['slug'] . '}'] = get_custom_field_value($invoice_id, $field['id'], 'invoice');
        }

        return hooks()->apply_filters('dispute_merge_fields', $fields, [
        'id'      => $invoice_id,
        'invoice' => $invoice,
     ]);
    }
}
