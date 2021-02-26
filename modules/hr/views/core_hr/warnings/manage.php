<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                     <div class="_buttons">
                         <?php if (has_permission('hr', '', 'create')){ ?>
                        <a href="#" class="btn btn-info pull-left" data-toggle="modal" data-target="#add_warning"><?php echo _l('new_warning'); ?></a>
                         <?php } ?>
                    </div>
                    <div class="clearfix"></div>
                    <hr class="hr-panel-heading" />
                    <div class="clearfix"></div>
                    <?php
                    $data = array(
                        _l('warning_to'),
                        _l('warning_date'),
                        _l('subject'),
                        _l('warning_by'),
                        _l('control'),
                    ); 

                    render_datatable($data,'warning');
                    ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('core_hr/warnings/modals/warnings_modal'); ?>
<?php init_tail(); ?>
<script>
   $(function(){
        initDataTable('.table-warning', window.location.href);
   });
$(document).on('change','#branch_id',function () {
    $.get(admin_url + 'hr/organization/get_staffs_by_branch_id/' + $(this).val(), function(response) {
        if (response.success == true) {
            $('#e_warning_to').empty();
            $('#e_warning_to').append($('<option>', {
                value: '',
                text: ''
            }));
            for(let i = 0; i < response.data.length; i++) {
                let key = response.data[i].key;
                let value = response.data[i].value;
                $('#e_warning_to').append($('<option>', {
                    value: key,
                    text: value
                }));
                $('#e_warning_to').selectpicker('refresh');
            }
        } else {
            alert_float('danger', response.message);
        }
    }, 'json');
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

$(document).on('change','#a_branch_id',function () {
    $.get(admin_url + 'hr/organization/get_staffs_by_branch_id/' + $(this).val(), function(response) {
        if (response.success == true) {
            $('#warning_to').empty();
            $('#warning_to').append($('<option>', {
                value: '',
                text: ''
            }));
            for(let i = 0; i < response.data.length; i++) {
                let key = response.data[i].key;
                let value = response.data[i].value;
                $('#warning_to').append($('<option>', {
                    value: key,
                    text: value,
                }));
                $('#warning_to').selectpicker('refresh');
            }
        } else {
            alert_float('danger', response.message);
        }
    }, 'json');
});

$(document).on('change','#branch_id',function () {
    $.get(admin_url + 'hr/organization/get_staffs_by_branch_id/' + $(this).val(), function(response) {
        if (response.success == true) {
            $('#e_warning_by').empty();
            $('#e_warning_by').append($('<option>', {
                value: '',
                text: ''
            }));
            for(let i = 0; i < response.data.length; i++) {
                let key = response.data[i].key;
                let value = response.data[i].value;
                $('#e_warning_by').append($('<option>', {
                    value: key,
                    text: value
                }));
                $('#e_warning_by').selectpicker('refresh');
            }
        } else {
            alert_float('danger', response.message);
        }
    }, 'json');
});

$(document).on('change','#a_branch_id',function () {
    $.get(admin_url + 'hr/organization/get_staffs_by_branch_id/' + $(this).val(), function(response) {
        if (response.success == true) {
            $('#warning_by').empty();
            $('#warning_by').append($('<option>', {
                value: '',
                text: ''
            }));
            for(let i = 0; i < response.data.length; i++) {
                let key = response.data[i].key;
                let value = response.data[i].value;
                $('#warning_by').append($('<option>', {
                    value: key,
                    text: value,
                }));
                $('#warning_by').selectpicker('refresh');
            }
        } else {
            alert_float('danger', response.message);
        }
    }, 'json');
});
</script>
</body>
</html>
