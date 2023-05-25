<?php defined('BASEPATH') or exit('No direct script access allowed');?>
<?php init_head();?>
<div id="wrapper">
	<div class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="panel_s">
					<div class="panel-body">

						<div  style="padding: 10px;">
                  <?php if (has_permission('system_messages', '', 'create')) {?>
                     <a style="margin-left:5px ;" href="<?php echo admin_url('Messages/messagescu'); ?>" class="btn btn-info pull-left  new"><?php echo _l(' رسالة جديدة للموظف'); ?></a>


                        <?php }?>

                        <?php if (has_permission('system_messages_client', '', 'create')) {?>
                        <a style="margin-left:5px ;" href="<?php echo admin_url('Messages/messagescu_client'); ?>" class="btn btn-info pull-left  new"><?php echo _l(' رسالة جديدة للزبون'); ?>

                        <?php }?>
                        <?php if (has_permission('system_messages_client', '', 'create') || has_permission('system_messages', '', 'create')) {?>
                        <a style="margin-left:5px ;" href="<?php echo admin_url('Messages/sent_items'); ?>" class="btn btn-info pull-left "><?php echo _l(' البريد الصادر'); ?></a>
                        <?php }?>

                     <a style="margin-left:5px ;" href="<?php echo admin_url('Messages/inbox'); ?>" class="btn btn-info pull-left "><?php echo _l(' البريد الوارد'); ?></a>


							<div class="clearfix"></div>
							<hr class="hr-panel-heading" />
						</div>
						<div class="clearfix"></div>

                        <?php
$table_data = array();
$_table_data = array(
    '<span class="hide"> - </span><div class="checkbox mass_select_all_wrap"><input type="checkbox" id="mass_select_all" data-to-table="messages"><label></label></div>',
    array(
        'name' => _l('the_number_sign'),
        'th_attrs' => array('class' => 'toggleable', 'id' => 'th-number'),
    ),
    array(
        'name' => _l('date_time'),
        'th_attrs' => array('class' => 'toggleable', 'id' => 'th-created_at'),
    ),
    array(
        'name' => 'المرسل',
        'th_attrs' => array('class' => 'toggleable', 'id' => 'th-from_user_id'),
    ),
    array(
        'name' => 'الموضوع',
        'th_attrs' => array('class' => 'toggleable', 'id' => 'th-subject'),
    ),

);
foreach ($_table_data as $_t) {
    array_push($table_data, $_t);
}

$custom_fields = get_custom_fields('messages', array('show_on_table' => 1));
foreach ($custom_fields as $field) {
    array_push($table_data, $field['name']);
}

//  $table_data = hooks()->apply_filters('customers_table_columns', $table_data);

render_datatable($table_data, 'messages');
?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php init_tail();?>




?>
<script>
   $(function(){
   			 initDataTable('.table-messages', admin_url + 'messages/inbox', undefined, undefined, 'undefined', [0, 'desc']);
	});
</script>





</body>
</html>
