<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php $this->load->view('admin/subscriptions/table_html_oservice', array('url'=>admin_url("subscriptions/table_oservice/$ServID/$service->slug?project_id=".$project->id))); ?>
