<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
			<div class="col-md-12">

				<div class="panel_s">
					<div class="panel-body">
						<?php if(has_permission('staff','','create')){ ?>
						<div class="_buttons">
							<?php if($this->app_modules->is_active('hr')) {?>
								<a href="<?php echo admin_url('hr/general/member'); ?>" class="btn btn-info pull-left display-block"><?php echo _l('new_staff'); ?></a>
							<?php } else {?>
								<a href="<?php echo admin_url('staff/member'); ?>" class="btn btn-info pull-left display-block"><?php echo _l('new_staff'); ?></a>
							<?php } ?>
						</div>
						<div class="clearfix"></div>
                            <hr class="hr-panel-heading">
                            <div class="row">
                                <div class="col-md-3 pull-left">
                                    <select name="hrm_deparment[]" class="selectpicker" multiple="true" id="hrm_deparment" data-width="100%" data-none-selected-text="<?php echo _l('filter_by_departments'); ?>">

                                        <?php
                                            foreach ($departments as $department) { ?>
                                                <option value="<?php echo $department['departmentid'] ?>">
                                                    <?php echo $department['name'] ?>
                                                </option>
                                            <?php }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <br>

						<?php } ?>
						<div class="clearfix"></div>
						<?php
						$table_data = array(
							_l('staff_dt_name'),
							_l('staff_dt_email'),
							_l('role'),
							_l('staff_dt_last_Login'),
							_l('completed_with_hr_system'),
							_l('staff_dt_active'),
							);
						if($this->app_modules->is_active('branches')){
					        $table_data[] = _l('branch_name');
					  }
						$custom_fields = get_custom_fields('staff',array('show_on_table'=>1));
						foreach($custom_fields as $field){
							array_push($table_data,$field['name']);
						}
                        $table_data = hooks()->apply_filters('staffs_table_columns', $table_data);
						render_datatable($table_data,'staff');
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="delete_staff" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<?php echo form_open(admin_url('staff/delete',array('delete_staff_form'))); ?>
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><?php echo _l('delete_staff'); ?></h4>
			</div>
			<div class="modal-body">
				<div class="delete_id">
					<?php echo form_hidden('id'); ?>
				</div>
				<p><?php echo _l('delete_staff_info'); ?></p>
				<?php
				echo render_select('transfer_data_to',$staff_members,array('staffid',array('firstname','lastname')),'staff_member',get_staff_user_id(),array(),array(),'','',false);
				?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
				<button type="submit" class="btn btn-danger _delete"><?php echo _l('confirm'); ?></button>
			</div>
		</div><!-- /.modal-content -->
		<?php echo form_close(); ?>
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php init_tail(); ?>
<script>
	// $(function(){
	// });
	function delete_staff_member(id){
		$('#delete_staff').modal('show');
		$('#transfer_data_to').find('option').prop('disabled',false);
		$('#transfer_data_to').find('option[value="'+id+'"]').prop('disabled',true);
		$('#delete_staff .delete_id input').val(id);
		$('#transfer_data_to').selectpicker('refresh');
	}

    $(function(){


        var StaffServerParams = {
            "hrm_deparment": "[name='hrm_deparment[]']",
        };
        table_staff = $('table.table-staff');

        initDataTable('.table-staff', window.location.href, '', '', StaffServerParams);

        $.each(StaffServerParams, function() {
            $('#hrm_deparment').on('change', function() {
                table_staff.DataTable().ajax.reload()
                    .columns.adjust()
                    .responsive.recalc();
            });
        });
        //combotree department
    //     $('#hrm_derpartment_tree').on('change', function() {
    //         $('#hrm_deparment').val(tree_dep.getSelectedItemsId());
    //         table_staff.DataTable().ajax.reload()
    //             .columns.adjust()
    //             .responsive.recalc();
    // });
        //staff role
        // $.each(StaffServerParams, function() {
        //     $('#hrm_deparment').on('change', function() {
        //         table_staff.DataTable().ajax.reload()
        //             .columns.adjust()
        //             .responsive.recalc();
        //     });
        // });
    })
</script>
</body>
</html>
