<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body _buttons">
                        <?php if(has_permission('hr_contracts','','create')){ ?>
                            <a href="<?php echo admin_url('hr/contracts/contract'); ?>" class="btn btn-info pull-left display-block"><?php echo _l('new_contract'); ?></a>
                        <?php } ?>
                    </div>
                </div>
                <div class="panel_s">
                    <?php echo form_hidden('custom_view'); ?>
                    <div class="panel-body">
                        <?php $this->load->view('admin/contracts/table_html'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
<script>
    $(function(){

        var ContractsServerParams = {};
        $.each($('._hidden_inputs._filters input'),function(){
            ContractsServerParams[$(this).attr('name')] = '[name="'+$(this).attr('name')+'"]';
        });

        initDataTable('.table-hr_contracts', admin_url+'hr/contracts/table', undefined, undefined, ContractsServerParams,<?php echo hooks()->apply_filters('hr_contracts_table_default_order', json_encode(array(6,'asc'))); ?>);

        new Chart($('#contracts-by-type-chart'), {
            type: 'bar',
            data: <?php echo $chart_types; ?>,
            options: {
                legend: {
                    display: false,
                },
                responsive: true,
                maintainAspectRatio:false,
                scales: {
                    yAxes: [{
                        display: true,
                        ticks: {
                            suggestedMin: 0,
                        }
                    }]
                }
            }
        });
        new Chart($('#contracts-value-by-type-chart'), {
            type: 'line',
            data: <?php echo $chart_types_values; ?>,
            options: {
                responsive: true,
                legend: {
                    display: false,
                },
                maintainAspectRatio:false,
                scales: {
                    yAxes: [{
                        display: true,
                        ticks: {
                            suggestedMin: 0,
                        }
                    }]
                }
            }
        });
    });
</script>
</body>
</html>
