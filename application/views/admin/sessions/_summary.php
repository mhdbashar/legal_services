<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<h4 class="mbot15"><?php echo _l('sessions_summary'); ?></h4>
<div class="row">
  <?php /*foreach(sessions_summary_data((isset($rel_id) ? $rel_id : null),(isset($rel_type) ? $rel_type : null)) as $summary){ ?>
    <div class="col-md-2 col-xs-6 border-right">
      <h3 class="bold no-mtop"><?php echo $summary['total_tasks']; ?></h3>
      <p style="color:<?php echo $summary['color']; ?>" class="font-medium no-mbot">
        <?php echo $summary['name']; ?>
      </p>
      <p class="font-medium-xs no-mbot text-muted">
        <?php echo _l('sessions_view_assigned_to_user'); ?>: <?php echo $summary['total_my_tasks']; ?>
      </p>
    </div>
    <?php }*/ ?>
    <div class="col-md-2 col-xs-6 border-right">
        <h3 class="bold no-mtop"><?php echo get_count_of_watting_sessions(); ?></h3>
        <p style="color:#03A9F4" class="font-medium no-mbot">
            <?php echo _l('Waiting_sessions'); ?>
        </p>
    </div>
    <div class="col-md-2 col-xs-6">
        <h3 class="bold no-mtop"><?php echo get_count_of_previous_sessions(); ?></h3>
        <p style="color:#989898" class="font-medium no-mbot">
            <?php echo _l('Previous_Sessions'); ?>
        </p>
    </div>
  </div>
<!--  <hr class="hr-panel-heading" />-->
