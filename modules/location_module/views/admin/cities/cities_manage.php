<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                     <div class="_buttons">
                        <a href="#" class="btn btn-info pull-left" data-toggle="modal" data-target="#add_city"><?php echo 'New City'; ?></a>
                    </div>
                    <div class="clearfix"></div>
                    <hr class="hr-panel-heading" />
                    <div class="clearfix"></div>
                    <?php render_datatable(array(
                        'City Name',
                        'Options',
                        ),'cities'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('admin/cities/cities_view', ['country_id' => $country_id]); ?>
<?php init_tail(); ?>
<script>
   $(function(){
        initDataTable('.table-cities', window.location.href, [1], [1]);
   });
</script>
</body>
</html>