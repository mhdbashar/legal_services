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

<script>

  $(document).on('change','#branch_id',function () {
    $.get(admin_url + 'branches/getDepartments/' + $(this).val(), function(response) {
        if (response.success == true) {
            $('#department_id').empty();
            $('#department_id').append($('<option>', {
                value: '',
                text: ''
            }));
            for(let i = 0; i < response.data.length; i++) {
                let key = response.data[i].key;
                let value = response.data[i].value;
                $('#department_id').append($('<option>', {
                    value: key,
                    text: value
                }));
                $('#department_id').selectpicker('refresh');
            }
        } else {
            alert_float('danger', response.message);
        }
    }, 'json');
});

  $(document).on('change','#branch_id',function () {
    $.get(admin_url + 'branches/get_office_shift/' + $(this).val(), function(response) {
        if (response.success == true) {
            $('#office_shift_id').empty();
            $('#office_shift_id').append($('<option>', {
                value: '',
                text: ''
            }));
            for(let i = 0; i < response.data.length; i++) {
                let key = response.data[i].key;
                let value = response.data[i].value;
                $('#office_shift_id').append($('<option>', {
                    value: key,
                    text: value
                }));
                $('#office_shift_id').selectpicker('refresh');
            }
        } else {
            alert_float('danger', response.message);
        }
    }, 'json');
});

$(document).ready(function(){
  <?php if(empty($branch)) $branch = 1 ?>
  var branch_id = <?php echo $branch ?>;
  <?php  
    $departmentid = 0;
    if ($this->Extra_info_model->get($member->staffid) and $this->Extra_info_model->get_staff_department($member->staffid))
      $departmentid = $this->Extra_info_model->get_staff_department($member->staffid)->departmentid;
  ?>
  var department_id = <?php echo $departmentid ?>;
  console.log(department_id);
  <?php if(is_numeric($extra_info->sub_department)){ ?>
    var sub_departmant = <?php echo $extra_info->sub_department ?>;
    var designation = <?php echo $extra_info->designation ?>;
    var office_shift = <?php echo $extra_info->office_sheft ?>;
  <?php }else{ ?>
    var sub_departmant = '';
    var designation = '';
  <?php  }  ?>
  console.log(<?php echo $extra_info->sub_department ?>);
  $.get(admin_url + 'branches/getDepartments/' + branch_id, function(response) {
      if (response.success == true) {
          $('#department_id').empty();
          $('#department_id').append($('<option>', {
              value: '',
              text: ''
          }));
          for(let i = 0; i < response.data.length; i++) {
              let key = response.data[i].key;
              let value = response.data[i].value;
              let select = false;
              if(key == department_id)
                select = true;
              $('#department_id').append($('<option>', {
                  value: key,
                  text: value,
                  selected: select
              }));
              $('department_id').selectpicker('refresh');
          }
      } else {
          alert_float('danger', response.message);
      }
  }, 'json');

  $.get(admin_url + 'branches/get_office_shift/' + branch_id, function(response) {
        if (response.success == true) {
            $('#office_shift_id').empty();
            $('#office_shift_id').append($('<option>', {
                value: '',
                text: ''
            }));
            for(let i = 0; i < response.data.length; i++) {
                let key = response.data[i].key;
                let value = response.data[i].value;
                let select = false;
                if(key == office_shift)
                select = true;
                $('#office_shift_id').append($('<option>', {
                    value: key,
                    text: value,
                    selected: select
                }));
                $('#office_shift_id').selectpicker('refresh');
            }
        } else {
            alert_float('danger', response.message);
        }
    }, 'json');

  $.get(admin_url + 'hr/organization/get_sub_departments/' + department_id, function(response) {
        if (response.success == true) {
            $('#sub_department_id').empty();
            $('#sub_department_id').append($('<option>', {
                value: '',
                text: ''
            }));
            for(let i = 0; i < response.data.length; i++) {
                let key = response.data[i].key;
                let value = response.data[i].value;
                let select = false;
                if(key == sub_departmant)
                  select = true;
                $('#sub_department_id').append($('<option>', {
                    value: key,
                    text: value,
                    selected: select
                }));
                $('#sub_department_id').selectpicker('refresh');
            }
        } else {
            alert_float('danger', response.message);
        }
    }, 'json');

  $.get(admin_url + 'hr/organization/get_designations/' + department_id, function(response) {
        if (response.success == true) {
            $('#designation_id').empty();
            $('#designation_id').append($('<option>', {
                value: '',
                text: ''
            }));
            for(let i = 0; i < response.data.length; i++) {
                let key = response.data[i].key;
                let value = response.data[i].value;
                let select = false;
                if(key == designation)
                  select = true;
                $('#designation_id').append($('<option>', {
                    value: key,
                    text: value,
                    selected: select
                }));
                $('#designation_id').selectpicker('refresh');
            }
        } else {
            alert_float('danger', response.message);
        }
    }, 'json');
});

  function check(sel)
  {
    console.log('#designation_'+sel.value);
    $.get(admin_url + 'hr/organization/get_designations/' + sel.value, function(response) {
        if (response.success == true) {
            $('#designation_id').empty();
            $('#designation_id').append($('<option>', {
                value: '',
                text: ''
            }));
            for(let i = 0; i < response.data.length; i++) {
                let key = response.data[i].key;
                let value = response.data[i].value;
                $('#designation_id').append($('<option>', {
                    value: key,
                    text: value
                }));
                $('#designation_id').selectpicker('refresh');
            }
        } else {
            alert_float('danger', response.message);
        }
    }, 'json');

    console.log('#sub_departmant_'+sel.value);
    $.get(admin_url + 'hr/organization/get_sub_departments/' + sel.value, function(response) {
        if (response.success == true) {
            $('#sub_department_id').empty();
            $('#sub_department_id').append($('<option>', {
                value: '',
                text: ''
            }));
            for(let i = 0; i < response.data.length; i++) {
                let key = response.data[i].key;
                let value = response.data[i].value;
                $('#sub_department_id').append($('<option>', {
                    value: key,
                    text: value
                }));
                $('#sub_department_id').selectpicker('refresh');
            }
        } else {
            alert_float('danger', response.message);
        }
    }, 'json');
  }
   $(function() {

       $('select[name="role"]').on('change', function() {
           var roleid = $(this).val();
           init_roles_permissions(roleid, true);
       });

       $('input[name="administrator"]').on('change', function() {
           var checked = $(this).prop('checked');
           var isNotStaffMember = $('.is-not-staff');
           if (checked == true) {
               isNotStaffMember.addClass('hide');
               $('.roles').find('input').prop('disabled', true).prop('checked', false);
           } else {
               isNotStaffMember.removeClass('hide');
               isNotStaffMember.find('input').prop('checked', false);
               $('.roles').find('.capability').not('[data-not-applicable="true"]').prop('disabled', false)
           }
       });

       $('#is_not_staff').on('change', function() {
           var checked = $(this).prop('checked');
           var row_permission_leads = $('tr[data-name="leads"]');
           if (checked == true) {
               row_permission_leads.addClass('hide');
               row_permission_leads.find('input').prop('checked', false);
           } else {
               row_permission_leads.removeClass('hide');
           }
       });

       init_roles_permissions();

       appValidateForm($('.staff-form'), {
           firstname: 'required',
           lastname: 'required',
           username: 'required',
           password: {
               required: {
                   depends: function(element) {
                       return ($('input[name="isedit"]').length == 0) ? true : false
                   }
               }
           },
           email: {
               required: true,
               email: true,
               remote: {
                   url: site_url + "admin/misc/staff_email_exists",
                   type: 'post',
                   data: {
                       email: function() {
                           return $('input[name="email"]').val();
                       },
                       memberid: function() {
                           return $('input[name="memberid"]').val();
                       }
                   }
               }
           }
       });
   });

</script>
</body>
</html>