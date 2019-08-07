<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- oservice Tasks -->
<?php
    if($oservice->settings->hide_tasks_on_main_tasks_table == '1') {
        echo '<i class="fa fa-exclamation fa-2x pull-left" data-toggle="tooltip" data-title="'._l('oservice_hide_tasks_settings_info').'"></i>';
    }
?>
<div class="tasks-table">
    <?php init_relation_tasks_table(array( 'data-new-rel-id'=>$oservice->id,'data-new-rel-type'=> $service->slug, 'data-new-rel-slug'=> $service->slug)); ?>
</div>
