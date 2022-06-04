<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- Copy Project -->
<div class="modal fade" id="linked_services" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <?php echo form_open(admin_url('legalservices/disputes_cases/link/'.$ServID.'/'.(isset($project) ? $project->id : '')),array('id'=>'link_form','data-link-url'=>admin_url('legalservices/disputes_cases/link/'))); ?>

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    <?php echo _l('linked_services'); ?><?php echo $ServID;?>
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="copy-project-tasks-status-wrapper">
                            <p class="bold"><?php echo _l('father_linked_services'); ?></p>
                                <div>
                                    <?php if( is_object($father_linked_services)): ?>
                                        <?php
                                        if($father_linked_services->to_service_id == 1)
                                            $to = 'Case';
                                        else
                                            $to = 'SOther';
                                        ?>
                                        <a href="<?php echo admin_url($to.'/view/'.$father_linked_services->l_service_id.'/'.$father_linked_services->rel_id) ?>">
                                            <?php echo $father_linked_services->name ?>
                                        </a>
                                    <?php endif;?>
                                </div>
                            <hr />
                        </div>
                        <div class="copy-project-tasks-status-wrapper">
                            <p class="bold"><?php echo _l('child_linked_services'); ?></p>
                                <div>
                                    <?php foreach($child_linked_services as $child_linked_service): ?>
                                      <?php
                                        if($child_linked_service->to_service_id == 1)
                                          $to = 'Case';
                                        else
                                          $to = 'SOther';
                                      ?>
                                      <p>
                                        <a href="<?php echo admin_url($to.'/view/'.$child_linked_service->to_service_id.'/'.$child_linked_service->to_rel_id) ?>">
                                            <?php echo $child_linked_service->name  ?>
                                        </a>
                                      </p>
                                    <?php endforeach;?>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
            </div>
        </div>
        <!-- /.modal-content -->
        <?php echo form_close(); ?>
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!-- Copy Project end -->
<script>
// Copy project modal and set url if ID is passed manually eq from project list area
function linked_services(id) {

    $('#linked_services').modal('show');

    if (typeof(id) != 'undefined') {
        $('#link_form').attr('action', $('#link_form').data('link-url') + id);
    }

    appValidateForm($('#link_form'), {
        start_date: 'required',
        clientid_copy_project: 'required',
    });

    var copy_members = $('#c_members');
    var copy_tasks = $('input[name="tasks"].copy');
    var copy_assignees_and_followers = $('input[name="task_include_assignees"],input[name="task_include_followers"]');

    copy_members.off('change');
    copy_tasks.off('change');
    copy_assignees_and_followers.off('change');

        copy_members.on('change',function(){
            if(!$(this).prop('checked')) {
                copy_assignees_and_followers.prop('checked',false)
           }
       });

        copy_tasks.on('change', function() {
          var checked = $(this).prop('checked');
          if (checked) {

              var copy_assignees = $('input[name="task_include_assignees"]').prop('checked');
              var copy_followers = $('input[name="task_include_followers"]').prop('checked');

              if (copy_assignees || copy_followers) {
                  $('input[name="members"].copy').prop('checked', true);
              }

              $('.copy-project-tasks-status-wrapper').removeClass('hide');
              $('.tasks-copy-option').removeClass('hide');

          } else {
              $('.copy-project-tasks-status-wrapper').addClass('hide');
              $('.tasks-copy-option').addClass('hide');
          }
      });

      copy_assignees_and_followers.on('change', function() {
          var checked = $(this).prop('checked');
          if (checked == true) {
              $('input[name="members"].copy').prop('checked', true);
          }
      });
}

</script>
