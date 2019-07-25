<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="panel_s">
					<div class="panel-body">
						<div class="_buttons">
							<?php if(is_admin()) { ?>
							<a href="<?php echo admin_url('procuration/statecu'); ?>" class="btn btn-info pull-left display-block"><?php echo _l('new_procuration_state'); ?></a>
							<div class="clearfix"></div>
							<hr class="hr-panel-heading" />
							<!-- <?php render_datatable(array(_l('Id'),_l('procuration_state'),"c1","c2","c3"),'procurationstate');  } ?> -->
							<?php
                     $table_data = array();
                     $_table_data = array(
                      '<span class="hide"> - </span><div class="checkbox mass_select_all_wrap"><input type="checkbox" id="mass_select_all" data-to-table="clients"><label></label></div>',
                       array(
                         'name'=>_l('the_number_sign'),
                         'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-number')
                        ),
                         array(
                         'name'=>_l('procuration_state'),
                         'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-procuration-state')
                        ),
                      );
                     foreach($_table_data as $_t){
                      array_push($table_data,$_t);
                     }

                     $custom_fields = get_custom_fields('proc_state',array('show_on_table'=>1));
                     foreach($custom_fields as $field){
                      array_push($table_data,$field['name']);
                     }

                    //  $table_data = hooks()->apply_filters('customers_table_columns', $table_data);

                     render_datatable($table_data,'procurationstate');
                     ?>
						</div>						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php init_tail(); ?>
<script>
   $(function(){
   			 initDataTable('.table-procurationstate', admin_url + 'procuration/state', undefined, undefined, 'undefined', [0, 'desc']);
	});
</script>
</body>
</html>
