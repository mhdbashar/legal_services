<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php $this->load->view('admin/subscriptions/table_html_case', array('url'=>admin_url("subscriptions/table_case/$ServID/$service->slug?project_id=".$project->id))); ?>
