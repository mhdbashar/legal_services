<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php if ($project->settings->view_session_logs == 1 && $project->settings->create_sessions == 1) : ?>
  <div class="row">
    <div class="col-md-12 mtop10">
      <?php echo form_open_multipart('', array('id' => 'session-form')); ?>
      <?php echo form_hidden('action', 'new_session'); ?>
      <h2 class="no-mtop"><?php echo _l('new_session'); ?></h2>
      <hr />
      <div class="row">
        <div class=" col-md-6">
          <label for="name"><?php echo _l('session_add_edit_subject'); ?></label>
          <input type="text" name="name" id="name" class="form-control">
        </div>
        <div class="form-group col-md-6">
          <label for="time" class="col-form-label"><?php echo _l('session_time'); ?></label>
          <?php $value = (isset($task) ? $task->time : ''); ?>
          <input type="text" class="form-control" value="<?php echo $value; ?>" id="time" name="time" autocomplete="off">
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <?php echo render_date_input('startdate', 'session_add_edit_start_date', _d(date('Y-m-d'))); ?>
        </div>
        <div class="form-group">
          <div class="col-md-6">
            <label for="court_id" class="control-label"><?php echo _l('Court'); ?></label>
            <select name="court_id" onchange="GetCourtJad()" class="selectpicker" id="court_id" data-width="100%" data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
              <?php if (isset($courts)) { ?>
                <option value="<?php echo $default_courts ?>"></option>
                <?php foreach ($courts as $court) { ?>
                  <option value="<?php echo $court['c_id'] ?>"><?php echo $court['court_name'] ?></option>
                <?php }
              } else { ?>
                <option value="<?php echo $default_corts ?>"></option>
              <?php } ?>

            </select>
          </div>
        </div>
      </div>
      <div class="row">
        <?php if ($project->settings->view_team_members == 1) { ?>
          <div class="col-md-6 form-group ">
            <label for="assignees"><?php echo _l('session_single_assignees_select_title'); ?></label>
            <select class="selectpicker" multiple="true" name="assignees[]" id="assignees" data-width="100%" data-live-search="true">
              <?php foreach ($members as $member) { ?>
                <option value="<?php echo $member['staff_id']; ?>" <?php if (count($members) == 1) {
                                                                      echo ' selected';
                                                                    } ?>><?php echo get_staff_full_name($member['staff_id']); ?></option>
              <?php } ?>
            </select>
          </div>
        <?php } ?>
      </div>
      <div class="form-group">
        <label for="description"><?php echo _l('session_add_edit_description'); ?></label>
        <textarea name="description" id="description" rows="10" class="form-control"></textarea>
      </div>
      <?php echo render_custom_fields('sesssions', '', array('show_on_client_portal' => 1)); ?>
      <?php if ($project->settings->upload_on_sessions == 1) { ?>
        <hr />
        <div class="row attachments">
          <div class="attachment">
            <div class="col-md-6 center">
              <div class="form-group">
                <label for="attachment" class="control-label"><?php echo _l('add_session_attachments'); ?></label>
                <div class="input-group">
                  <input type="file" extension="<?php echo str_replace('.', '', get_option('allowed_files')); ?>" filesize="<?php echo file_upload_max_size(); ?>" class="form-control" name="attachments[0]">
                  <span class="input-group-btn">
                    <button class="btn btn-success add_more_attachments p8-half" type="button"><i class="fa fa-plus"></i></button>
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>

      <?php echo render_custom_fields('sessions', '', array('show_on_client_portal' => 1)); ?>
      <button type="submit" class="btn btn-info pull-right"><?php echo _l('submit'); ?></button>
      <?php echo form_close(); ?>
    </div>
  </div>
  </div>
  <script>
    $(document).ready(function() {
      $('#time').datetimepicker({
        datepicker: false,
        format: 'H:i'
      });

      appValidateForm($('#session-form'), {
        name: 'required',
        time: 'required',
        description: 'required',
      });
    })
  </script>
<?php else :
  redirect(site_url() . 'clients/legal_services/' . $rel_id . '/' . $ServID);
endif; ?>