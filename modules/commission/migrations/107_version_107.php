<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_107 extends App_module_migration
{
    public function up()
    {
		add_option('calculate_recurring_invoice', 0);
    }
}
