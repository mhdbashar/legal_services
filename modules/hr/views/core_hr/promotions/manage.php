<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                     <div class="_buttons">
                        <a href="#" class="btn btn-info pull-left" data-toggle="modal" data-target="#add_promotion"><?php echo _l('new_promotion'); ?></a>
                    </div>
                    <div class="clearfix"></div>
                    <hr class="hr-panel-heading" />
                    <div class="clearfix"></div>
                    <?php render_datatable(array(
                        _l('staff_name'),
                        _l('branch'),
                        _l('promotion_title'),
                        _l('promotion_date'),
                        _l('control'),
                    ),'promotion'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('core_hr/promotions/modals/promotion_modal'); ?>
<?php init_tail(); ?>
<script>
   $(function(){
        initDataTable('.table-promotion', window.location.href);
   });
</script>
<script>
   $(function(){
        initDataTable('.table-transfer', window.location.href);
   });

$('#add_promotion').on('hidden.bs.modal', function (e) {
  console.log('agt');
  $(this)
    .find("input,textarea,select")
       .val('')
       .end()
    .find("input[type=checkbox], input[type=radio]")
       .prop("checked", "")
       .end();
})

$(document).on('change','#staff_id',function () {
        $.get(admin_url + 'hr/core_hr/in_hr_system/' + $(this).val(), function(response) {
            if (response.success == true) {
                $('#add_transfer').modal('show'); // show bootstrap modal when complete loaded

                if (!response.data){
                    $('#add_promotion').modal('hide');
                    console.log('You Should Add Staff To HR System');
                    alert('You Should Add Staff To HR System');
                    $('button[group="submit"]').attr('disabled', true);
                }else{
                    $('button[group="submit"]').prop("disabled", false);
                }
            } else {
                alert_float('danger', response.message);
            }
        }, 'json');
    });
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
                    class: 'department_id'
                }));
                $('#staff_id').selectpicker('refresh');
            }
        } else {
            alert_float('danger', response.message);
        }
    }, 'json');
});

$(document).on('change','#staff_id',function () {
    $.get(admin_url + 'hr/organization/get_designations_by_staff_id/' + $(this).val(), function(response) {
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
});

$(document).on('change','#e_staff_id',function () {
    $.get(admin_url + 'hr/organization/get_designations_by_staff_id/' + $(this).val(), function(response) {
        if (response.success == true) {
            $('#e_designation_id').empty();
            $('#e_designation_id').append($('<option>', {
                value: '',
                text: ''
            }));
            for(let i = 0; i < response.data.length; i++) {
                let key = response.data[i].key;
                let value = response.data[i].value;
                $('#e_designation_id').append($('<option>', {
                    value: key,
                    text: value,
                    class: 'e_designation_id'
                }));
                $('#e_designation_id').selectpicker('refresh');
            }
        } else {
            alert_float('danger', response.message);
        }
    }, 'json');
});
</script>
</body>
</html>
