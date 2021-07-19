<?php defined('BASEPATH') or exit('No direct script access allowed');
$where = array();
if ($this->input->get('project_id')) {
    $where['rel_id'] = $this->input->get('project_id');
    $where['rel_type'] = $rel_type;
}
foreach (session_statuses() as $status) {
    $total_pages = ceil($this->sessions_model->do_kanban_query($status['id'], $this->input->get('search'), 1, true, $where) / get_option('tasks_kanban_limit'));
    ?>
    <ul class="kan-ban-col tasks-kanban" data-col-status-id="<?php echo $status['name']; ?>"
        data-total-pages="<?php echo $total_pages; ?>" style="width: 49%;">
        <li class="kan-ban-col-wrapper">
            <div class="border-right panel_s">
                <div class="panel-heading-bg"
                     style="background:<?php echo $status['color']; ?>;border-color:<?php echo $status['color']; ?>;color:#fff;"
                     data-status-id="<?php echo $status['id']; ?>">
                    <div class="kan-ban-step-indicator<?php if ($status['id'] == Sessions_model::STATUS_COMPLETE) {
                        echo ' kan-ban-step-indicator-full';
                    } ?>"></div>
                    <span class="heading"><?php echo _l($status['name']); ?>
          </span>
                    <a href="#" onclick="return false;" class="pull-right color-white">
                    </a>
                </div>
                <div class="kan-ban-content-wrapper">
                    <div class="kan-ban-content">
                        <ul class="status tasks-status sortable relative"
                            data-task-status-id="<?php echo $status['id']; ?>">
                            <?php
                            $tasks = $this->sessions_model->do_kanban_query($status['name'], $this->input->get('search'), 1, false, $where);
                            $total_tasks = count($tasks);
                            foreach ($tasks as $task) {
                                $this->load->view('admin/sessions/_kan_ban_card', array('task' => $task, 'status' => $status['id']));
                            } ?>
                            <?php if ($total_tasks > 0) { ?>
                                <li class="text-center not-sortable kanban-load-more"
                                    data-load-status="<?php echo $status['id']; ?>">
                                    <a href="#" class="btn btn-default btn-block<?php if ($total_pages <= 1) {
                                        echo ' disabled';
                                    } ?>" data-page="1"
                                       onclick="kanban_load_more(<?php echo $status['id']; ?>,this,'legalservices/sessions/tasks_kanban_load_more',265,360); return false;"><?php echo _l('load_more'); ?></a>
                                </li>
                            <?php } ?>
                            <li class="text-center not-sortable mtop30 kanban-empty<?php if ($total_tasks > 0) {
                                echo ' hide';
                            } ?>">
                                <h4>
                                    <i class="fa fa-circle-o-notch" aria-hidden="true"></i><br/><br/>
                                    <?php echo _l('no_sessions_found'); ?></h4>
                            </li>
                        </ul>
                    </div>
                </div>
        </li>
    </ul>
<?php } ?>
