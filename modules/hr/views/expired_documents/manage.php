<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-3">
                    <ul class="nav navbar-pills navbar-pills-flat nav-tabs nav-stacked customer-tabs">
                        <li class="customer_tab_contacts">
                  <a data-group='employee' href="?group=employee"><?php echo _l('staff_documents') ?></a>
                </li>
                <li class="customer_tab_contacts">
                  <a data-group='immigration' href="?group=immigration"><?php echo _l('immigration') ?></a>
                </li>
                        <li class="customer_tab_contacts">
                            <a data-group='official' href="?group=official"><?php echo _l('official_documents') ?></a>
                        </li>
                    </ul>
            </div>
            <div class="col-md-9">
                <?php $this->load->view('expired_documents/'.$group) ?>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
<script>
   $(function(){
        initDataTable('.table-<?php echo $group ?>', window.location.href);
   });
</script>
</body>
</html>
