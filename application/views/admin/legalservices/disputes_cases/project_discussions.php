<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php if(!isset($discussion)){ ?>
<a href="#" onclick="new_discussion();return false;" class="btn btn-info mbot25"><?php echo _l('new_project_discussion'); ?></a>
<?php
    $table_attributes['data-new-rel-slug'] = $service->slug;
    $this->load->view('admin/legalservices/disputes_cases/project_discussion');
    render_datatable(array(
     _l('project_discussion_subject'),
     _l('project_discussion_last_activity'),
     _l('project_discussion_total_comments'),
     _l('project_discussion_show_to_customer'),
     ),'case-discussions', [] ,$table_attributes); ?>
<?php } else { ?>
<h3 class="bold no-margin"><?php echo $discussion->subject; ?></h3>
<hr />
<p class="no-margin"><?php echo _l('project_discussion_posted_on',_d($discussion->datecreated)); ?></p>
<p class="no-margin">
    <?php if($discussion->staff_id == 0){
        echo _l('project_discussion_posted_by',get_contact_full_name($discussion->contact_id)) . ' <span class="label label-info inline-block">'._l('is_customer_indicator').'</span>';
        } else {
        echo _l('project_discussion_posted_by',get_staff_full_name($discussion->staff_id));
        }
        ?>
</p>
<p><?php echo _l('project_discussion_total_comments'); ?>: <?php echo total_rows(db_prefix().'my_disputes_casediscussioncomments',array('discussion_id'=>$discussion->id, 'discussion_type'=>'regular')); ?></p>
<p class="text-muted"><?php echo $discussion->description; ?></p>
<hr />
<div id="discussion-comments" class="tc-content"></div>
<?php } ?>