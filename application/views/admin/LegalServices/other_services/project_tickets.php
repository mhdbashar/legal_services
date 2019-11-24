<?php defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('admin/tickets/summary_oservices',array('project_id'=>$project_id));
echo form_hidden('project_id',$project_id);
echo '<div class="clearfix"></div>';
if(((get_option('access_tickets_to_none_staff_members') == 1 && !is_staff_member()) || is_staff_member())){
    echo '<a href="'.admin_url('tickets/add?ServID='.$ServID.'&oserviceid='.$project->id).'" class="mbot20 btn btn-info">'._l('new_ticket').'</a>';
}
echo AdminTicketsOserviceTableStructure('tickets_oservice-table', false, $service->slug);
?>
