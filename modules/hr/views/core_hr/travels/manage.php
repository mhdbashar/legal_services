<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                     <div class="_buttons">
                        <a href="#" class="btn btn-info pull-left" data-toggle="modal" data-target="#add_travel"><?php echo _l('new_travel'); ?></a>
                    </div>
                    <div class="clearfix"></div>
                    <hr class="hr-panel-heading" />
                    <div class="clearfix"></div>
                    <?php
                    $data = array(
                        _l('staff_name'),
                        _l('place_of_visit'),
                        _l('start_date'),
                        _l('end_date'),
                        _l('status'),
                        _l('control'),
                    ); 
                    if($this->app_modules->is_active('branches'))
                        $data = array(
                            _l('staff_name'),
                            _l('branch_name'),
                            _l('place_of_visit'),
                            _l('start_date'),
                            _l('end_date'),
                            _l('status'),
                            _l('control'),
                        ); 
                    render_datatable($data,'travel');
                    ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('core_hr/travels/modals/travels_modal'); ?>
<?php init_tail(); ?>
<script>
   $(function(){
        initDataTable('.table-travel', window.location.href);
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

</script>
</body>
</html>
