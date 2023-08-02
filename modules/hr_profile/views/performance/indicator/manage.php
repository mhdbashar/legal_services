<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                     <div class="_buttons">
                        <?php if (has_permission('hr', '', 'create')){ ?><a href="#" class="btn btn-info pull-left" data-toggle="modal" data-target="#add_indicator"><?php echo _l('new_indicator'); ?></a><?php } ?>
                    </div>
                    <div class="clearfix"></div>
                    <hr class="hr-panel-heading" />
                    <div class="clearfix"></div>
                    <?php $data = array(
                        // _l('department_name'),
                        _l('job position'),
                        _l('added_by'),
                        _l('created'),
                        _l('control'),
                    ); 
//                    if($this->app_modules->is_active('branches'))
//                        //$data[0] = _l('branch');
//                        $data = array_merge([_l('branch')], $data);
                    render_datatable($data,'indicator');
                    ?>
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

</script>
</body>
</html>
