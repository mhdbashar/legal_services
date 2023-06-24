<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
    	<?php $this->load->view('hr_profile/details/hr_tabs') ?>
        <div class="row">
        	<div class="col-md-3">
			       	<ul class="nav navbar-pills navbar-pills-flat nav-tabs nav-stacked customer-tabs">
                       <?PHP if(is_admin() || has_permission('update_salary',$staff_id,'view')){
                        ?>
                        <li class="customer_tab_contacts">
				       		<a data-group='update_salary' href="?group=update_salary"><?php echo _l('update_salary') ?></a>
				       	</li>
                      <?php  } ?>
                        <?PHP if(is_admin() || has_permission('allowances',$staff_id,'view')){?>
				       	<li class="customer_tab_contacts">
				       		<a data-group='allowances' href="?group=allowances"><?php echo _l('allowances') ?></a>
				       	</li>
                        <?php  } ?>
                        <?PHP if(is_admin() || has_permission('commissions',$staff_id,'view')){?>
                        <li class="customer_tab_contacts">
				       		<a data-group='commissions' href="?group=commissions"><?php echo _l('commissions') ?></a>
				       	</li>
                        <?php  } ?>
                        <?PHP if(is_admin() || has_permission('loan',$staff_id,'view')){?>
                        <li class="customer_tab_contacts">
				       		<a data-group='loan' href="?group=loan"><?php echo _l('loan') ?></a>
				       	</li>
                        <?php  } ?>
                        <?PHP if(is_admin() || has_permission('statutory_deductions',$staff_id,'view')){?>
                        <li class="customer_tab_contacts">
				       		<a data-group='statutory_deductions' href="?group=statutory_deductions"><?php echo _l('statutory_deductions') ?></a>
				       	</li>
                        <?php  } ?>
                        <?PHP if(is_admin() || has_permission('other_payments',$staff_id,'view')){?>
                                <li class="customer_tab_contacts">
				       		<a data-group='other_payments' href="?group=other_payments"><?php echo _l('other_payments') ?></a>
				       	</li>
                        <?php  } ?>
                        <?PHP if(is_admin() || has_permission('overtime',$staff_id,'view')){?>
                            <li class="customer_tab_contacts">
				       		<a data-group='overtime' href="?group=overtime"><?php echo _l('overtime') ?></a>
				       	</li>
                        <?php  } ?>
			      	</ul>
            </div>
		   	<div class="col-md-9">
        		<div class="panel_s">
            		<div class="panel-body">
            			<?php $this->load->view('details/salary/'.$this->input->get('group')) ?>
				   	</div>
				</div>
		   	</div>
            
        </div>
    </div>
</div>
<?php init_tail() ?>

<script>
   $(function(){
        initDataTable('.table-<?php echo $group ?>', window.location.href);
   });
</script>
</body>
</html>