<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
    	<?php $this->load->view('hr/details/hr_tabs') ?>
        <div class="row">
        	<div class="col-md-3">
			       	<ul class="nav navbar-pills navbar-pills-flat nav-tabs nav-stacked customer-tabs">
				       	<li class="customer_tab_contacts">
				       		<a data-group='basic_information' href="?group=basic_information"><?php echo _l('basic_information') ?></a>
				       	</li>
				       	<li class="customer_tab_contacts">
				       		<a data-group='immigration' href="?group=immigration"><?php echo _l('immigration') ?></a>
				       	</li>
				       	<li class="customer_tab_contacts">
				       		<a data-group='emergency_contacts' href="?group=emergency_contacts"><?php echo _l('emergency_contacts') ?></a>
				       	</li>
				       	<li class="customer_tab_contacts">
				       		<a data-group='social_networking' href="?group=social_networking"><?php echo _l('social_networking') ?></a>
				       	</li>
				       	<li class="customer_tab_contacts">
				       		<a data-group='document' href="?group=document"><?php echo _l('document') ?></a>
				       	</li>
				       	<li class="customer_tab_contacts">
				       		<a data-group='qualification' href="?group=qualification"><?php echo _l('qualification') ?></a>
				       	</li>
				       	<li class="customer_tab_contacts">
				       		<a data-group='work_experience' href="?group=work_experience"><?php echo _l('work_experience') ?></a>
				       	</li>
				       	<li class="customer_tab_contacts">
				       		<a data-group='bank_account' href="?group=bank_account"><?php echo _l('bank_account') ?></a>
				       	</li>
				       	<li class="customer_tab_contacts">
				       		<a data-group='change_password' href="?group=change_password"><?php echo _l('change_password') ?></a>
				       	</li>
				       	<li class="customer_tab_contacts">
				       		<a data-group='security_level' href="?group=security_level"><?php echo _l('security_level') ?></a>
				       	</li>
			      	</ul>
            </div>
		   	<div class="col-md-9">
        		<div class="panel_s">
            		<div class="panel-body">
            			<?php $this->load->view('details/general/'.$this->input->get('group')) ?>
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