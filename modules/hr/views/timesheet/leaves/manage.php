<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                     <div class="_buttons">
                        <a href="#" class="btn btn-info pull-left" data-toggle="modal" data-target="#add_leave"><?php echo _l('new_leave'); ?></a>
                    </div>
                    <div class="clearfix"></div>
                    <hr class="hr-panel-heading" />
                    <div class="clearfix"></div>
                    <?php 
                    $data = array(
                        _l('staff_name'),
                        _l('request_duration'),
                        _l('applied_on'),
                        _l('control'),
                    ); 
                    if($this->app_modules->is_active('branches'))
                        $data = array_merge([_l('branch')], $data);
                    $data = array_merge([_l('leave_type')], $data);
                    render_datatable($data,'resignation'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('timesheet/leaves/modals/leave_modal'); ?>
<?php init_tail(); ?>
<?php if (has_permission('hr', '', 'view')){ ?>
<script>
   $(function(){
        initDataTable('.table-resignation', window.location.href);
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

$(document).on('change','#branch_id',function () {
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

$(document).on('change','#e_staff_id',function () {
    $.get(admin_url + 'hr/timesheet/get_leave_types_by_staff_id/' + $(this).val(), function(response) {
        if (response.success == true) {
            $('#e_leave_type').empty();
            $('#e_leave_type').append($('<option>', {
                value: '',
                text: ''
            }));
            for(let i = 0; i < response.data.length; i++) {
                let key = response.data[i].key;
                let value = response.data[i].value;
                $('#e_leave_type').append($('<option>', {
                    value: key,
                    text: value
                }));
                $('#e_leave_type').selectpicker('refresh');
            }
        } else {
            alert_float('danger', response.message);
        }
    }, 'json');
});

$(document).on('change','#staff_id',function () {
    $.get(admin_url + 'hr/timesheet/get_leave_types_by_staff_id/' + $(this).val(), function(response) {
        if (response.success == true) {
            $('#leave_type').empty();
            $('#leave_type').append($('<option>', {
                value: '',
                text: ''
            }));
            for(let i = 0; i < response.data.length; i++) {
                let key = response.data[i].key;
                let value = response.data[i].value;
                $('#leave_type').append($('<option>', {
                    value: key,
                    text: value
                }));
                $('#leave_type').selectpicker('refresh');
            }
        } else {
            alert_float('danger', response.message);
        }
    }, 'json');
});
</script>
<?php }else{ ?>

<script>

$(function(){
        initDataTable('.table-resignation', window.location.href);
   });

var staff_id = <?php echo get_staff_user_id() ?>;
$(document).ready(function(){
    $.get(admin_url + 'hr/timesheet/get_leave_types_by_staff_id/' + staff_id, function(response) {
        if (response.success == true) {
            $('#leave_type').empty();
            $('#leave_type').append($('<option>', {
                value: '',
                text: ''
            }));
            for(let i = 0; i < response.data.length; i++) {
                let key = response.data[i].key;
                let value = response.data[i].value;
                $('#leave_type').append($('<option>', {
                    value: key,
                    text: value
                }));
                $('#leave_type').selectpicker('refresh');
            }
        } else {
            alert_float('danger', response.message);
        }
    }, 'json');
});
</script>

<?php } ?>
</body>
</html>
