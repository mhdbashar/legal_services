<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php if (!isset($discussion)) {
    if ($project->settings->open_discussions == 1) { ?>
        <a href="#" onclick="new_discussion();return false;" class="btn btn-info mtop5"><?php echo _l('new_project_discussion'); ?></a>
        <hr />
        <!-- Miles Stones -->
        <div class="modal fade" id="discussion" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <?php echo form_open(site_url('clients/legal_services/' . $project->id . '/' . $ServID), array('id' => 'discussion_form')); ?>
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">
                            <span class="edit-title"><?php echo _l('edit_discussion'); ?></span>
                            <span class="add-title"><?php echo _l('new_project_discussion'); ?></span>
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <?php
                                if ($ServID == 1) :
                                    echo form_hidden('project_id', $project->id);
                                else :
                                    echo form_hidden('oservice_id', $project->id);
                                endif;
                                ?>
                                <?php echo form_hidden('action', 'new_discussion'); ?>
                                <div id="additional_discussion"></div>
                                <?php echo render_input('subject', 'project_discussion_subject'); ?>
                                <?php echo render_textarea('description', 'project_discussion_description'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
                        <button type="submit" class="btn btn-info" data-loading-text="<?php echo _l('wait_text'); ?>" data-autocomplete="off" data-form="#discussion_form"><?php echo _l('submit'); ?></button>
                    </div>
                </div>
                <!-- /.modal-content -->
                <?php echo form_close(); ?>
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
        <!-- Mile stones end -->
    <?php } ?>
    <table class="table dt-table" data-order-col="1" data-order-type="desc">
        <thead>
            <tr>
                <th><?php echo _l('project_discussion_subject'); ?></th>
                <th><?php echo _l('project_discussion_last_activity'); ?></th>
                <th><?php echo _l('project_discussion_total_comments'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($discussions as $discussion) { ?>
                <tr>
                    <td><a href="<?php echo site_url('clients/legal_services/' . $project->id . '/' . $ServID . '?group=' . $group . '&discussion_id=' . $discussion['id']); ?>"><?php echo $discussion['subject']; ?></a></td>
                    <td data-order="<?php echo $discussion['last_activity']; ?>">
                        <?php
                        if (!is_null($discussion['last_activity'])) {
                            $last_activity = time_ago($discussion['last_activity']);
                        } else {
                            $last_activity = _l('project_discussion_no_activity');
                        }
                        echo $last_activity;
                        ?>
                    </td>
                    <td><?php echo $discussion['total_comments']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php } else { ?>
    <?php echo form_hidden('discussion_user_profile_image_url', $discussion_user_profile_image_url); ?>
    <?php echo form_hidden('discussion_id', $discussion->id); ?>
    <h3 class="bold no-margin"><?php echo $discussion->subject; ?></h3>
    <hr />
    <p class="no-margin"><?php echo _l('project_discussion_posted_on', _d($discussion->datecreated)); ?></p>
    <p class="no-margin">
        <?php if ($discussion->staff_id == 0) {
            echo _l('project_discussion_posted_by', get_contact_full_name($discussion->contact_id)) . ' <span class="label label-info inline-block">' . _l('is_customer_indicator') . '</span>';
        } else {
            echo _l('project_discussion_posted_by', get_staff_full_name($discussion->staff_id));
        }
        ?>
    <?php
    if ($ServID == 1) {
        $table_name = 'casediscussioncomments';
    } else {
        $table_name = 'oservicediscussioncomments';
    }
    ?>
    </p>
    <p><?php echo _l('project_discussion_total_comments'); ?>: <?php echo total_rows(db_prefix() . 'casediscussioncomments', array('discussion_id' => $discussion->id, 'discussion_type' => 'regular')); ?></p>
    <p class="text-muted"><?php echo $discussion->description; ?></p>
    <hr />
    <div id="discussion-comments" class="tc-content"></div>
<?php } ?>