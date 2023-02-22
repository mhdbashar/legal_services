<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_521 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
    }
    public function up()
    {
        // Add saudi vat option for invoices and credit notes
        if(!get_option('saudi_vat'))
            add_option('saudi_vat', 0);

    }
}