<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<h4 class="customer-profile-group-heading"><?php echo _l('disputes_cases'); ?></h4>
<?php if(isset($client)){ ?>
    <?php if(has_permission('projects','','create')){ ?>
        <a href="<?php echo admin_url('Disputes_cases/add/22?customer_id='.$client->userid); ?>" class="btn btn-info mbot25<?php if($client->active == 0){echo ' disabled';} ?>"><?php echo _l('add').' '._l('disputes_cases'); ?></a>
    <?php }?>
    <div class="row">
        <?php
        $_where = '';
        if(!has_permission('projects','','view')){
            $_where = 'id IN (SELECT project_id FROM '.db_prefix().'my_members_disputes_cases WHERE staff_id='.get_staff_user_id().')';
        }
        ?>
        <?php foreach($project_statuses as $status){ ?>
            <div class="col-md-5ths total-column">
                <div class="panel_s">
                    <div class="panel-body">
                        <h3 class="text-muted _total">
                            <?php $where = ($_where == '' ? '' : $_where.' AND ').'status = '.$status['id']. ' AND clientid='.$client->userid; ?>
                            <?php echo total_rows(db_prefix().'my_disputes_cases',$where); ?>
                        </h3>
                        <span style="color:<?php echo $status['color']; ?>"><?php echo $status['name']; ?></span>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    <?php
    $this->load->view('admin/legalservices/disputes_cases/table_html', array('class'=>'disputes-cases-single-client', 'model' => $model));
}
?>
