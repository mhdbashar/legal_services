<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="_buttons">
                            <a href=<?php echo admin_url('legalservices/regular_durations/add')?> class="btn btn-info pull-left" ><?php echo _l('new_regular_duration'); ?></a>
                        </div>
                        <div class="clearfix"></div>
                        <hr class="hr-panel-heading" />
                        <div class="clearfix"></div>
                        <div class="table-responsive"><table data-last-order-identifier="kb-articles" data-default-order="" class="table table-articles dataTable no-footer" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                                <thead>
                                <tr role="row">
                                    <th class="sorting " tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Article Name activate to sort column ascending"><?php echo _l("name")?></th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Group activate to sort column ascending"><?php echo _l("number_of_days")?></th>
                                    <th class="sorting " tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Article Name activate to sort column ascending"><?php echo _l('Court'); ?></th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Group activate to sort column ascending"><?php echo _l('child_sub_categories'); ?></th>
                                    <th class="sorting sorting_desc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="descending" aria-label="Date Published activate to sort column ascending"><?php echo _l("categories")?></th>
                                    <th class="sorting sorting_desc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="descending" aria-label="Date Published activate to sort column ascending"><?php echo _l("sub_categories")?></th>

                                </tr>
                                </thead>
                                <tbody>

                                <?php foreach($durations as $duration){ ?>

                                    <tr class="has-row-options odd">
                                        <td><a  href="#" class="font-size-14"><b><?php echo $duration->name; ?></b></a>
                                            <div class="row-options">

                                                <a href="<?php echo admin_url('legalservices/regular_durations/edit_duration/'.$duration->id); ?>"><?php echo _l("edit")?> </a>
                                                | <a href="<?php echo admin_url('legalservices/regular_durations/delete_duration/'.$duration->id); ?>" class="_delete text-danger"><?php echo _l("delete")?> </a>
                                            </div>
                                        </td>
                                        <td><?php echo $duration->number_of_days; ?> </td>
                                        <td> <?php if($duration->court_id) echo _l(get_court_by_id($duration->court_id)->court_name); ?></td>
                                        <td><?php if($duration->childsubcat_id)echo _l(get_cat_name_by_id($duration->childsubcat_id)); ?> </td>
                                        <td><?php echo get_cat_name_by_id($duration->categories); ?> </td>
                                        <td><?php echo get_cat_name_by_id($duration->sub_categories); ?> </td>

                                    </tr>
                                <?php } ?>

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
<script>
   // $(function(){
      //  initDataTable('.table-regular_durations', window.location.href, [1], [1]);
    });
</script>
</body>
</html>
