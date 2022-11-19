<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="panel_s">
					<div class="panel-body">
                        <?php if (has_permission('judges_manage', '', 'create')) { ?>
						<div class="_buttons">							
							<a href="<?php echo admin_url('judge/judgecu'); ?>" class="btn btn-info pull-left display-block"><?php echo _l('new_judge'); ?></a>
							<div class="clearfix"></div>
							<hr class="hr-panel-heading" />
						</div>
						<div class="clearfix"></div>
                        <?php } ?>
                        <?php
                             $table_data = array();
                             $_table_data = array(
                                '<span class="hide"> - </span><div class="checkbox mass_select_all_wrap"><input type="checkbox" id="mass_select_all" data-to-table="judge"><label></label></div>',
                                 array(
                                   'name'=>_l('the_number_sign'),
                                   'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-number')
                                  ),
                                   array(
                                   'name'=> 'Name',
                                   'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-name')
                                  ),
                                  array(
                                    'name'=> 'Note',
                                    'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-note')
                                   ),
                                );
                               foreach($_table_data as $_t){
                                array_push($table_data,$_t);
                               }
          
                               $custom_fields = get_custom_fields('judge',array('show_on_table'=>1));
                               foreach($custom_fields as $field){
                                array_push($table_data,$field['name']);
                               }
          
                              //  $table_data = hooks()->apply_filters('customers_table_columns', $table_data);
          
                               render_datatable($table_data,'judge');
                               ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php init_tail(); ?>
<script>
   $(function(){
   			 initDataTable('.table-judge', admin_url + 'judge', undefined, undefined, 'undefined', [0, 'desc']);
	});
</script>
</body>
</html>
