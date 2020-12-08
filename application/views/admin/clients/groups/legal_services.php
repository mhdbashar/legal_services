<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<h4 class="customer-profile-group-heading"><?php echo _l('LegalServices'); ?></h4>
<?php if(isset($client)){
    $CI = &get_instance();
    $services = $CI->db->get_where('my_basic_services', array('id !=' => 1, 'is_module' => 0))->result();
    ?>
<?php
    $count_of_services=0;
    foreach ($services as $service):
        if(has_permission('projects','','create')){ ?>
<a href="<?php echo admin_url('SOther/add/'.$service->id.'?customer_id='.$client->userid); ?>" class="btn btn-info mbot25<?php if($client->active == 0){echo ' disabled';} ?>"><?php echo _l('permission_create').' '.$service->name; ?></a>
<?php } ?>
<div class="row">
   <?php
      $_where = '';
      if(!has_permission('projects','','view')){
        $_where = 'id IN (SELECT oservice_id FROM '.db_prefix().'my_members_services WHERE staff_id='.get_staff_user_id().')';
      }
      ?>
   <?php foreach($project_statuses as $status){ ?>
   <div class="col-md-5ths total-column">
      <div class="panel_s">
         <div class="panel-body">
            <h3 class="text-muted _total">
               <?php $where = ($_where == '' ? '' : $_where.' AND ').'status = '.$status['id']. ' AND clientid='.$client->userid; ?>
               <?php echo total_rows(db_prefix().'my_other_services',$where); ?>
            </h3>
            <span style="color:<?php echo $status['color']; ?>"><?php echo $status['name']; ?></span>
         </div>
      </div>
   </div>
   <?php } ?>
</div>
<?php
   $this->load->view('admin/LegalServices/other_services/table_html', array('class'=>'legal_services-single-client-'.$count_of_services.'', 'model' => $model, 'slug' => $service->slug));
   $count_of_services++;
   endforeach;
   echo render_input('count_of_services', '', $count_of_services, 'hidden');
}
?>
