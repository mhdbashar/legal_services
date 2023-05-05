<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head();
?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div role="tabpanel" class="tab-pane active" id="knowlege_activity">
                            <div class="col-md-12">
                                <?php if (has_permission('knowledge_base', '', 'create')) { ?>
                                    <a href="<?php echo admin_url('knowledge_base/knowlege_nezam_vers'); ?>"
                                       class="btn btn-success pull-left"><?php echo _l('kb_nezam_vers_new'); ?></a>
                                <?php } ?>
                                <div class="clearfix"></div>
                                <hr class="hr-panel-heading"/>
                                <?php render_datatable(
                                    array(
                                        _l('kb_nezam_vers_name'),
                                        _l('clients_country'),
                                    ), 'knowlege_nezam_vers'
                                ); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
<script>
    initDataTable('.table-knowlege_nezam_vers', admin_url + 'knowledge_base/kb_nezam_vers', undefined, undefined);
</script>
</body>
</html>
