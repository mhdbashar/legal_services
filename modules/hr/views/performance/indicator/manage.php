<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                     <div class="_buttons">
                        <a href="#" class="btn btn-info pull-left" data-toggle="modal" data-target="#add_indicator"><?php echo _l('new_indicator'); ?></a>
                    </div>
                    <div class="clearfix"></div>
                    <hr class="hr-panel-heading" />
                    <div class="clearfix"></div>
                    <?php render_datatable(array(
                        _l('branch_name'),
                        _l('department_name'),
                        _l('designation_name'),
                        _l('added_by'),
                        _l('created'),
                        _l('control'),
                    ),'indicator'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('performance/indicator/modals/indicator_modal'); ?>
<?php init_tail(); ?>
<script>
   $(function(){
        initDataTable('.table-indicator', window.location.href);
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
    $.get(admin_url + 'hr/performance/get_designations_by_branch_id/' + $(this).val(), function(response) {
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
                    text: value
                }));
                $('#e_designation_id').selectpicker('refresh');
            }
        } else {
            alert_float('danger', response.message);
        }
    }, 'json');
});

$(document).on('change','#a_branch_id',function () {
    $.get(admin_url + 'hr/performance/get_designations_by_branch_id/' + $(this).val(), function(response) {
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
                    text: value,
                }));
                $('#designation_id').selectpicker('refresh');
            }
        } else {
            alert_float('danger', response.message);
        }
    }, 'json');
});

</script>
</body>
</html>
