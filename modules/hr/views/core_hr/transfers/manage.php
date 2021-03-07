<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                     <div class="_buttons">
                         <?php if (has_permission('transfers', '', 'create')){ ?>
                        <a href="#" class="btn btn-info pull-left" data-toggle="modal" data-target="#add_transfer"><?php echo _l('new_transfer'); ?></a>
                         <?php } ?>
                    </div>
                    <div class="clearfix"></div>
                    <hr class="hr-panel-heading" />
                    <div class="clearfix"></div>
                    <?php
                    $data = array(
                        _l('staff_name'),
                        _l('transfer_date'),
                        _l('status'),
                        _l('control'),
                    ); 

                    render_datatable($data,'transfer');
                    ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('core_hr/transfers/modals/transfers_modal'); ?>
<?php init_tail(); ?>
<script>
   $(function(){
        initDataTable('.table-transfer', window.location.href);
   });
$('.modal').on('hidden.bs.modal', function (e) {
  console.log('agt');
  $(this)
    .find("input,textarea,select")
       .val('')
       .end()
    .find("input[type=checkbox], input[type=radio]")
       .prop("checked", "")
       .end()
    .find(".branch")
        .remove()
    .find(".staff")
        .remove()
})
$(document).on('change','#staff_id',function () {
        $.get(admin_url + 'hr/core_hr/in_hr_system/' + $(this).val(), function(response) {
            if (response.success == true) {
                $('#add_transfer').modal('show'); // show bootstrap modal when complete loaded

                if (!response.data){
                    $('#add_transfer').modal('hide');
                    console.log('You Should Add Staff To HR System');
                    alert('You Should Add Staff To HR System');
                    $(this).val('');
                }
            } else {
                alert_float('danger', response.message);
            }
        }, 'json');
    });
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

    $.get(admin_url + 'hr/organization/get_staffs_by_branch_id/' + $(this).val(), function(response) {
        if (response.success == true) {
            $('#e_staff_id').empty();
            $('#e_staff_id').append($('<option>', {
                value: '',
                text: ''
            }));
            for(let i = 0; i < response.data.length; i++) {
                let key = response.data[i].key;
                let value = response.data[i].value;
                $('#e_staff_id').append($('<option>', {
                    value: key,
                    text: value
                }));
                $('#e_staff_id').selectpicker('refresh');
            }
        } else {
            alert_float('danger', response.message);
        }
    }, 'json');
});

$(document).on('change','#a_branch_id',function () {
    $.get(admin_url + 'branches/getDepartments/' + $(this).val(), function(response) {
        if (response.success == true) {
            $('#a_department_id').empty();
            $('#a_department_id').append($('<option>', {
                value: '',
                text: ''
            }));
            for(let i = 0; i < response.data.length; i++) {
                let key = response.data[i].key;
                let value = response.data[i].value;
                $('#a_department_id').append($('<option>', {
                    value: key,
                    text: value,
                    class: 'department_id'
                }));
                $('#a_department_id').selectpicker('refresh');
            }
        } else {
            alert_float('danger', response.message);
        }
    }, 'json');

    $.get(admin_url + 'hr/organization/get_staffs_by_branch_id/' + $(this).val(), function(response) {
        if (response.success == true) {
            $('#staff_id').empty();
            $('#staff_id').append($('<option>', {
                value: '',
                text: ''
            }));
            for(let i = 0; i < response.data.length; i++) {
                let key = response.data[i].key;
                let value = response.data[i].value;
                $('#staff_id').append($('<option>', {
                    value: key,
                    text: value,
                }));
                $('#staff_id').selectpicker('refresh');
            }
        } else {
            alert_float('danger', response.message);
        }
    }, 'json');
});

$(document).on('change','#department_id',function () {
    $.get(admin_url + 'hr/organization/get_sub_departments/' + $(this).val(), function(response) {
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
});

$(document).on('change','#a_department_id',function () {
    $.get(admin_url + 'hr/organization/get_sub_departments/' + $(this).val(), function(response) {
        if (response.success == true) {
            $('#a_sub_department_id').empty();
            $('#a_sub_department_id').append($('<option>', {
                value: '',
                text: ''
            }));
            for(let i = 0; i < response.data.length; i++) {
                let key = response.data[i].key;
                let value = response.data[i].value;
                $('#a_sub_department_id').append($('<option>', {
                    value: key,
                    text: value,
                    class: 'a_sub_department_id'
                }));
                $('#a_sub_department_id').selectpicker('refresh');
            }
        } else {
            alert_float('danger', response.message);
        }
    }, 'json');
});
</script>
</body>
</html>
