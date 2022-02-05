<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php if ($project->settings->view_session_logs == 1 && $project->settings->edit_sessions == 1) : ?>
  <div class="row">
    <div class="col-md-12 mtop10">
      <?php echo form_open_multipart('', array('id' => 'session-form')); ?>
      <?php echo form_hidden('action', 'edit_session'); ?>
      <?php echo form_hidden('session_id', $session->id); ?>
      <h2 class="no-mtop" id="session-edit-heading"><?php echo $session->name; ?></h2>
      <hr />
      <div class="row">
        <div class="form-group col-md-6">
          <label for="name"><?php echo _l('session_add_edit_subject'); ?></label>
          <input type="text" name="name" id="name" class="form-control"  value="<?php echo $session->name; ?>">
        </div>
        <div class="col-md-6" )>
          <div class="form-group">
            <label for="time" class="col-form-label"><?php echo _l('session_add_edit_session_time'); ?></label>
            <?php $value = (isset($session->time) ? $session->time : ''); ?>
            <input type="text" class="form-control" value="<?php echo $value; ?>" id="time" name="time" autocomplete="off" >
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <?php echo render_date_input('startdate', 'session_add_edit_start_date', $session->startdate); ?>
        </div>
        <div class="form-group">
          <div class="col-md-6">
            <label for="court_id" class="control-label"><?php echo _l('Court'); ?></label>
            <select name="court_id" onchange="GetCourtJad()" class="selectpicker" id="court_id" data-width="100%" data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
              <option value="<?php echo $default_courts ?>"></option>
              <?php $value = (isset($session) ? $session->court_id : ''); ?>
              <?php
              foreach ($courts as $court) { ?>
                <option value="<?php echo $court['c_id'] ?>" <?php echo $value == $court['c_id'] ? 'selected' : ''; ?>><?php echo $court['court_name'] ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
      </div>
      <div class="row">
        <?php if ($project->settings->view_team_members == 1) { ?>
          <div class="col-md-6  form-group ">
            <label for="assignees"><?php echo _l('session_single_assignees_select_title'); ?></label>
            <select class="selectpicker" multiple="true" name="assignees[]" id="assignees" data-width="100%" data-live-search="true">
              <?php foreach ($members as $member) { ?>
                <option value="<?php echo $member['staff_id']; ?>" <?php if ($this->sessions_model->is_task_assignee($member['staff_id'], $session->id)) {
                                                                      echo ' selected';
                                                                    } ?>><?php echo get_staff_full_name($member['staff_id']); ?></option>
              <?php } ?>
            </select>
          </div>
        <?php } ?>
      </div>
      <div class="form-group">
        <label for="description"><?php echo _l('session_add_edit_description'); ?></label>
        <textarea name="description" id="description" rows="10" class="form-control"><?php echo clear_textarea_breaks($session->description); ?></textarea>
      </div>
      <?php echo render_custom_fields('sessions', $session->id, array('show_on_client_portal' => 1)); ?>
      <button type="submit" class="btn btn-info pull-right"><?php echo _l('submit'); ?></button>
      <?php echo form_close(); ?>
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