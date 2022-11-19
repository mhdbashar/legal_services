<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="panel_s section-heading section-projects">
    <div class="panel-body">
        <h4 class="no-margin section-text"><?php echo _l('edit_imported_service'); ?></h4>
    </div>
</div>

<div class="panel_s">
    <div class="panel-body">
        <?php echo form_open_multipart($this->uri->uri_string(), array('id' => 'form')); ?>
        <?php echo render_input('name', 'ServiceTitle', $imported->name, 'text', ['required' => true]); ?>
        <p for="description" class="bold"><?php echo _l('project_description'); ?></p>
        <?php echo render_textarea('description', '', $imported->description, array(), array(), '', 'tinymce'); ?>


        <hr class="hr-panel-heading" />
        <button type="submit" class="btn btn-info pull-right"><?php echo _l('submit'); ?></button>

        <?php echo form_close(); ?>
    </div>
</div>