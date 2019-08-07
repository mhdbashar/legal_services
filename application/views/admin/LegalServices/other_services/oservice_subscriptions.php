<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php $this->load->view('admin/subscriptions/table_html', array('url'=>admin_url('subscriptions/table?oservice_id='.$oservice_id))); ?>
