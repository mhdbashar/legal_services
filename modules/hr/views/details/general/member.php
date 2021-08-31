<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <?php $this->load->view('details/general/basic_information'); ?>
        <div class="btn-bottom-pusher"></div>
    </div>
</div>
<?php init_tail(); ?>
<script>
    $("#country").change(function () {
        $.ajax({
            url: "<?php echo admin_url('Countries/build_dropdown_cities'); ?>",
            data: {country: $(this).val()},
            type: "POST",
            success: function (data) {
                $("#city").html(data);
            }
        });
    });
//  $(document).on('change','#branch_id',function () {
//    $.get(admin_url + 'branches/getDepartments/' + $(this).val(), function(response) {
//        if (response.success == true) {
//            $('#department_id').empty();
//            $('#department_id').append($('<option>', {
//                value: '',
//                text: ''
//            }));
//            for(let i = 0; i < response.data.length; i++) {
//                let key = response.data[i].key;
//                let value = response.data[i].value;
//                $('#department_id').append($('<option>', {
//                    value: key,
//                    text: value
//                }));
//                $('#department_id').selectpicker('refresh');
//            }
//        } else {
//            alert_float('danger', response.message);
//        }
//    }, 'json');
//});
//
//$(document).on('change','#branch_id',function () {
//    $.get(admin_url + 'branches/get_office_shift/' + $(this).val(), function(response) {
//        if (response.success == true) {
//            $('#office_shift_id').empty();
//            $('#office_shift_id').append($('<option>', {
//                value: '',
//                text: ''
//            }));
//            for(let i = 0; i < response.data.length; i++) {
//                let key = response.data[i].key;
//                let value = response.data[i].value;
//                $('#office_shift_id').append($('<option>', {
//                    value: key,
//                    text: value
//                }));
//                $('#office_shift_id').selectpicker('refresh');
//            }
//        } else {
//            alert_float('danger', response.message);
//        }
//    }, 'json');
//});

//$(document).ready(function(){
//  <?php //if(empty($branch)) $branch = 1 ?>
//  var branch_id = <?php //echo $branch ?>//;
//
//  console.log(<?php //echo $extra_info->sub_department ?>//);
//  $.get(admin_url + 'branches/getDepartments/' + branch_id, function(response) {
//      if (response.success == true) {
//          $('#department_id').empty();
//          $('#department_id').append($('<option>', {
//              value: '',
//              text: ''
//          }));
//          for(let i = 0; i < response.data.length; i++) {
//              let key = response.data[i].key;
//              let value = response.data[i].value;
//              let select = false;
//              $('#department_id').append($('<option>', {
//                  value: key,
//                  text: value,
//              }));
//              $('department_id').selectpicker('refresh');
//          }
//      } else {
//          alert_float('danger', response.message);
//      }
//  }, 'json');


<?php  if(!$this->app_modules->is_active('branches')){  ?>
  $.get(admin_url + 'branches/get_office_shift/' + 1, function(response) {
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
<?php  }  ?>
    var department_id = 0;
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
                $('#sub_department_id').append($('<option>', {
                    value: key,
                    text: value,
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
                $('#designation_id').append($('<option>', {
                    value: key,
                    text: value,
                }));
                $('#designation_id').selectpicker('refresh');
            }
        } else {
            alert_float('danger', response.message);
        }
    }, 'json');

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
           },
           emloyee_id: {
               required: true,
               remote: {
                   url: site_url + "admin/hr/general/validate_staff_code_number",
                   type: 'post',
                   data: {
                       emloyee_id: function() {
                           return $('input[name="emloyee_id"]').val();
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
<script>
   function getval(sel)
    {
      console.log('#department_'+sel.value);
      $('.department').addClass('hide');
      $('.department input').prop('checked', false);
      $('.department_'+sel.value).removeClass('hide');
    }

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
</script>
</body>
</html>