<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="panel_s section-heading section-projects">
    <div class="panel-body">
        <h4 class="no-margin section-text"><?php echo _l('add_imported_service'); ?></h4>
    </div>
</div>

<div class="panel_s">
    <div class="panel-body">
        <?php echo form_open_multipart($this->uri->uri_string(), array('id' => 'form')); ?>
        <?php echo render_input('name', 'ServiceTitle'); ?>
        <p for="description" class="bold"><?php echo _l('project_description'); ?></p>
        <?php echo render_textarea('description', '', '', array(), array(), '', 'tinymce'); ?>

        <div class="panel-footer attachments_area">
            <div class="row attachments">
                <div class="attachment">
                    <div class="col-md-4 col-md-offset-4 mbot15">
                        <div class="form-group">
                            <label for="attachment" class="control-label"><?php echo _l('ticket_add_attachments'); ?></label>
                            <div class="input-group">
                                <input type="file" extension="<?php echo str_replace(['.', ' '], '', get_option('ticket_attachments_file_extensions')); ?>" filesize="<?php echo file_upload_max_size(); ?>" class="form-control" name="attachments[0]" accept="<?php echo get_ticket_form_accepted_mimes(); ?>">
                                <span class="input-group-btn">
												<button class="btn btn-success add_more_attachments p8-half" data-max="<?php echo get_option('maximum_allowed_ticket_attachments'); ?>" type="button"><i class="fa fa-plus"></i></button>
											</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr class="hr-panel-heading" />
        <button type="submit" class="btn btn-info pull-right"><?php echo _l('submit'); ?></button>

        <?php echo form_close(); ?>
    </div>
</div>