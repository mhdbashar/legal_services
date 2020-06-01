<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="_buttons">
                            <h4 class="no-margin"><?php echo _l('LService_recycle_bin'); ?></h4>
                            <div class="clearfix"></div>
                            <hr class="hr-panel-heading" />
                            <?php foreach ($services as $row): ?>
                            <a href="<?php echo admin_url('LegalServices/LegalServices_controller/legal_recycle_bin/').$row->id; ?>" class="btn mright5 btn-info pull-left display-block" style="<?php echo $row->id == $ServID ? 'border: 2px solid #51647c;' : ''; ?>">
                                <?php echo $row->name; ?>
                            </a>
                            <?php endforeach; ?>
                            <div class="clearfix"></div>
                            <hr class="hr-panel-heading" />
                            <?php
                            if ($ServID != '') {
                                $table_data = array();
                                $_table_data = array(
                                    array(
                                        'name' => _l('the_number_sign'),
                                    ),
                                    array(
                                        'name' => _l('name'),
                                    ),
                                    array(
                                        'name' => _l('options'),
                                    ),
                                );
                                foreach ($_table_data as $_t) {
                                    array_push($table_data, $_t);
                                }
                                render_datatable($table_data, 'legal_recycle_bin');
                            }else{ ?>
                                <div class="alert alert-info mtop15 no-mbot">
                                  <?php echo _l('ChooseLegalServices'); ?>
                               </div>
                           <?php }  ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
<script>
    <?php if($ServID != ''){ ?>
    $(function(){
        initDataTable('.table-legal_recycle_bin', admin_url + 'LegalServices/LegalServices_controller/legal_recycle_bin/<?php echo $ServID; ?>', undefined, undefined, 'undefined', [0, 'asc']);
    });
    <?php } ?>
</script>
</body>
</html>