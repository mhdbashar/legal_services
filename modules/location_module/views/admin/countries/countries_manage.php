<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                     <div class="_buttons">
                        <a href="#" class="btn btn-info pull-left" data-toggle="modal" data-target="#add_country"><?php echo 'New Country'; ?></a>
                    </div>
                    <div class="clearfix"></div>
                    <hr class="hr-panel-heading" />
                    <div class="clearfix"></div>
                    <?php render_datatable(array(
                        'Country Name',
                        'Arabic Country Name',
                        'Options',
                        ),'countries'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('admin/countries/countries_view'); ?>
<?php init_tail(); ?>
<script>
   $(function(){
        initDataTable('.table-countries', window.location.href);
   });
</script>
</body>
</html>
