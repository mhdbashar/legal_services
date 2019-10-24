<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        
                        <a href="#" class="btn mright5 btn-info pull-left display-block" data-toggle="modal" data-target="#customer_company_group_modal">
                            <?php echo _l('new_company_customer_group'); ?>
                        </a>

                        <a href="<?php echo admin_url('clients/company_groups') ?>" class="btn mright5 btn-info pull-left display-block" style="">
                                Company                          
                        </a>
                     <div class="_buttons">
                        

                        <a href="<?php echo admin_url('clients/personal_groups') ?>" class="btn mright5 btn-info pull-left display-block" style="">
                                Individual                          
                        </a>

                    </div>
                    <div class="clearfix"></div>
                    <hr class="hr-panel-heading" />
                    <div class="clearfix"></div>
                    <?php render_datatable(array(
                        _l('customer_group_name'),
                        _l('options'),
                        ),'customer-groups'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('admin/clients/client_company_group'); ?>
<?php init_tail(); ?>
<script>
   $(function(){
        initDataTable('.table-customer-groups', window.location.href, [1], [1]);
   });
</script>
</body>
</html>
