<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                     <div class="_buttons">
                        <a href="#" class="btn btn-info pull-left" data-toggle="modal" data-target="#add_office_shift"><?php echo _l('new_office_shift'); ?></a>
                    </div>
                    <div class="clearfix"></div>
                    <hr class="hr-panel-heading" />
                    <div class="clearfix"></div>
                    <?php
                    $data = array(
                        _l('shift_name'),
                        _l('saturday'),
                        _l('sunday'),
                        _l('monday'),
                        _l('tuesday'),
                        _l('wednesday'),
                        _l('thursday'),
                        _l('friday'),
                        _l('control'),
                    ); 
                    if($this->app_modules->is_active('branches'))
                        array_unshift($data, _l('branch_name'));
                    render_datatable($data,'office_shift');
                    ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('timesheet/office_shift/modals/office_shift_modal'); ?>
<?php init_tail(); ?>
<script>
   $(function(){
        initDataTable('.table-office_shift', window.location.href);
   });


$( ".form" ).submit(function( event ) {
    var error = 0;
    if (
        ($('[name="saturday_out"]')[1].value != '' && $('[name="saturday_in"]')[1].value == '') || 
        ($('[name="saturday_out"]')[1].value == '' && $('[name="saturday_in"]')[1].value != ''))
    {
        error = 1;   
    }
    if (
        ($('[name="sunday_out"]')[1].value != '' && $('[name="sunday_in"]')[1].value == '') || 
        ($('[name="sunday_out"]')[1].value == '' && $('[name="sunday_in"]')[1].value != ''))
    {
        error = 1;   
    }
    if (
        ($('[name="monday_out"]')[1].value != '' && $('[name="monday_in"]')[1].value == '') || 
        ($('[name="monday_out"]')[1].value == '' && $('[name="monday_in"]')[1].value != ''))
    {
        error = 1;   
    }
    if (
        ($('[name="tuesday_out"]')[1].value != '' && $('[name="tuesday_in"]')[1].value == '') || 
        ($('[name="tuesday_out"]')[1].value == '' && $('[name="tuesday_in"]')[1].value != ''))
    {
        error = 1;   
    }
    if (
        ($('[name="wednesday_out"]')[1].value != '' && $('[name="wednesday_in"]')[1].value == '') || 
        ($('[name="wednesday_out"]')[1].value == '' && $('[name="wednesday_in"]')[1].value != ''))
    {
        error = 1;   
    }
    if (
        ($('[name="thursday_out"]')[1].value != '' && $('[name="thursday_in"]')[1].value == '') || 
        ($('[name="thursday_out"]')[1].value == '' && $('[name="thursday_in"]')[1].value != ''))
    {
        error = 1;   
    }
    if (
        ($('[name="friday_out"]')[1].value != '' && $('[name="friday_in"]')[1].value == '') || 
        ($('[name="friday_out"]')[1].value == '' && $('[name="friday_in"]')[1].value != ''))
    {
        error = 1;   
    }
 
  if(error != 0){
    alert_float('warning', "<?php echo _l('if_you_insert_time_in_you_must_insert_time_out') ?>");
  }else{
    return;
  }
  event.preventDefault();
});

$( ".edit_form" ).submit(function( event ) {
    var error = 0;
    if (
        ($('[name="saturday_out"]')[0].value != '' && $('[name="saturday_in"]')[0].value == '') || 
        ($('[name="saturday_out"]')[0].value == '' && $('[name="saturday_in"]')[0].value != ''))
    {
        error = 1;   
    }
    if (
        ($('[name="sunday_out"]')[0].value != '' && $('[name="sunday_in"]')[0].value == '') || 
        ($('[name="sunday_out"]')[0].value == '' && $('[name="sunday_in"]')[0].value != ''))
    {
        error = 1;   
    }
    if (
        ($('[name="monday_out"]')[0].value != '' && $('[name="monday_in"]')[0].value == '') || 
        ($('[name="monday_out"]')[0].value == '' && $('[name="monday_in"]')[0].value != ''))
    {
        error = 1;   
    }
    if (
        ($('[name="tuesday_out"]')[0].value != '' && $('[name="tuesday_in"]')[0].value == '') || 
        ($('[name="tuesday_out"]')[0].value == '' && $('[name="tuesday_in"]')[0].value != ''))
    {
        error = 1;   
    }
    if (
        ($('[name="wednesday_out"]')[0].value != '' && $('[name="wednesday_in"]')[0].value == '') || 
        ($('[name="wednesday_out"]')[0].value == '' && $('[name="wednesday_in"]')[0].value != ''))
    {
        error = 1;   
    }
    if (
        ($('[name="thursday_out"]')[0].value != '' && $('[name="thursday_in"]')[0].value == '') || 
        ($('[name="thursday_out"]')[0].value == '' && $('[name="thursday_in"]')[0].value != ''))
    {
        error = 1;   
    }
    if (
        ($('[name="friday_out"]')[0].value != '' && $('[name="friday_in"]')[0].value == '') || 
        ($('[name="friday_out"]')[0].value == '' && $('[name="friday_in"]')[0].value != ''))
    {
        error = 1;   
    }
 
  if(error != 0){
    alert_float('warning', "<?php echo _l('if_you_insert_time_in_you_must_insert_time_out') ?>");
  }else{
    return;
  }
  event.preventDefault();
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
</script>
</body>
</html>
