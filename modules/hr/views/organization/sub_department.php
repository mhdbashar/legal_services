<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                     <div class="_buttons">
                        <a href="#" class="btn btn-info pull-left" data-toggle="modal" data-target="#add_sub_department"><?php echo _l('new_sub_department'); ?></a>
                    </div>
                    <div class="clearfix"></div>
                    <hr class="hr-panel-heading" />
                    <div class="clearfix"></div>
                    <?php
                    $data = array(
                                _l('sub_department'),
                                _l('control'),
                            );
                     render_datatable($data,'sub_department'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('organization/modals/sub_department_modal'); ?>
<?php init_tail(); ?>
<script>
   $(function(){
        initDataTable('.table-sub_department', window.location.href);
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
});
</script>
</body>
</html>
