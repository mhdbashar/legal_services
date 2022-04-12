<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head();  ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="_buttons">
                            <div class="_buttons">
                                <a href="<?php echo admin_url('add_court') ?>" class="btn btn-info pull-left display-block">
                                    <?php echo _l('NewCourt'); ?>
                                </a>
                                <div class="clearfix"></div>
                                <hr class="hr-panel-heading" />
                            </div>
                            <table class="table dt-table scroll-responsive">
                                <thead>
                                <th>#</th>
                                <th><?php echo _l('name'); ?></th>
                                <th><?php echo _l('_description'); ?></th>
                                <th><?php echo _l('clients_country'); ?></th>
                                <th><?php echo _l('clients_city'); ?></th>
                                <th><?php echo _l('Categories'); ?></th>
                                <th><?php echo _l('options'); ?></th>

                                </thead>
                                <tbody>
                                <?php $i=1; foreach($courts as $court){
                                    if($court->is_default == 1)
                                        continue;
                                    ?>

                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td>
                                            <?php echo $court->court_name; ?>
                                        </td>
                                        <td>
                                            <?php $value = (isset($court) ? $court->court_description : ''); ?>
                                            <?php echo $value; ?>
                                        </td>
                                        <td>
                                            <?php $staff_language = get_staff_default_language(get_staff_user_id());?>
                                            <?php $value = (isset($court) ? $court->country : ''); ?>
                                            <?php echo get_country_name_by_staff_default_language($value,$staff_language);?>
                                        </td>
                                        <td>
                                            <?php $value = (isset($court) ? $court->city : ''); ?>
                                            <?php echo $value; ?>
                                        </td>
                                        <td>
                                            <?php $value = get_category_by_court_id($court->c_id); ?>
                                        <?php if($value){foreach ($value as $cat){

                                            echo $cat->name;
                                            echo '<br>';
                                            } }?>
                                        </td>
                                        <td>
                                            <?php if($court->is_basic != 1){ ?>
                                                <a href="<?php echo admin_url("delete_court/$court->c_id"); ?>" class="btn btn-danger btn-icon _delete"><i class="fa fa-remove"></i></a>
                                            <?php } ?>
                                            <a href="<?php echo admin_url("edit_court/$court->c_id"); ?>" class="btn btn-default btn-icon"><i class="fa fa-pencil-square-o"></i></a>

                                            <a href="<?php echo admin_url("judicial_control/$court->c_id"); ?>" class="btn btn-info btn-icon">
                                                <?php echo _l('Judicial'); ?>
                                            </a>

                                        </td>

                                    </tr>
                                    <?php $i++; } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
</body>
</html>