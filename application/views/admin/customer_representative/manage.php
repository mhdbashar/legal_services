<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="panel_s">
					<div class="panel-body">
                        <?php if (has_permission('customer_representative', '', 'create')) { ?>
						<div class="_buttons">
							<a href="<?php echo admin_url('customer_representative/cust_representativecu'); ?>" class="btn btn-info pull-left display-block"><?php echo _l('new_customer_representative'); ?></a>
							<div class="clearfix"></div>
							<hr class="hr-panel-heading" />
                        </div>
                        <?php } ?>
                        <div class="clearfix"></div>
							<?php
                     $table_data = array();
                     $_table_data = array(
                      '<span class="hide"> - </span><div class="checkbox mass_select_all_wrap"><input type="checkbox" id="mass_select_all" data-to-table="clients"><label></label></div>',
                       array(
                         'name'=>_l('the_number_sign'),
                         'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-number')
                        ),
                         array(
                         'name'=>_l('customer_representative'),
                         'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-customer-representative')
                        ),
                      );
                     foreach($_table_data as $_t){
                      array_push($table_data,$_t);
                     }

                     $custom_fields = get_custom_fields('cust_repres',array('show_on_table'=>1));
                     foreach($custom_fields as $field){
                      array_push($table_data,$field['name']);
                     }

                    //  $table_data = hooks()->apply_filters('customers_table_columns', $table_data);

                     render_datatable($table_data,'customer_representative');
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
   			 initDataTable('.table-customer_representative', admin_url + 'customer_representative', undefined, undefined, 'undefined', [0, 'desc']);
	});
</script>
</body>
</html>
