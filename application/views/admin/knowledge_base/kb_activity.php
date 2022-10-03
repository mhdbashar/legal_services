<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head();
?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s mtop5">
                    <div class="panel-body">
                        <div role="tabpanel" class="tab-pane active" id="knowlege_activity">
                            <div class="col-md-12">
                                <?php render_datatable(
                                    array(
                                        _l('kb_dt_article_name'),
                                        _l('kb_article_basic_group'),
                                        _l('kb_dt_group_name'),
                                        _l('staff_member'),
                                        _l('kb_process'),
                                        _l('kb_datecreated'),
                                    ),'knowlege_activity'
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
        initKnowledgeBaseTableArticles();
        function initKnowledgeBaseTableArticles() {
            // var KB_Articles_ServerParams = {};
            // $.each($('._hidden_inputs._filters input'), function () {
            //     KB_Articles_ServerParams[$(this).attr('name')] = '[name="' + $(this).attr('name') + '"]';
            // });
            $('._filter_data').toggleClass('hide');
            initDataTable('.table-knowlege_activity', admin_url + 'knowledge_base/kb_activity', undefined, undefined);
        }

</script>
</body>
</html>
