<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel_s">
                <div class="panel-body">
                    <div class="_buttons">
                        <a href=<?php echo admin_url('legalservices/regular_durations/add_duration_cases/'.$project->id)?> class="btn btn-info pull-left" ><?php echo _l('new_case_regular_duration'); ?></a>
                    </div>
                    <div class="clearfix"></div>
                    <hr class="hr-panel-heading" />
                    <div class="clearfix"></div>
                    <div class="table-responsive"><table data-last-order-identifier="kb-articles" data-default-order="" class="table table-articles dataTable no-footer" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                            <thead>
                            <tr class="has-row-options odd text-center"  role="row">
                                <th class="sorting " tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Article Name activate to sort column ascending"><?php echo _l("duration_name")?></th>
                                <th class="sorting " tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Article Name activate to sort column ascending"><?php echo _l("number_of_dayes")?></th>
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Group activate to sort column ascending"><?php echo _l("duration_start_date")?></th>
                                <th class="sorting " tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Article Name activate to sort column ascending"><?php echo _l('duration_end_date'); ?></th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $case_durations = get_case_durations_by_case_id($project->id);
                            foreach($case_durations as $case_duration){ ?>
                                <?php
                               $duration= get_duration_by_id($case_duration['reg_id']);
                               ?>
                                <tr class="has-row-options odd text-center" >
                                    <td><a  href="#" class="font-size-14"><b><?php echo get_dur_name_by_id($case_duration['reg_id']); ?></b></a>
                                        <div class="row-options">

                                            <a href="<?php echo admin_url('legalservices/regular_durations/edit_case_duration/'.$case_duration['case_id'].'/'.$duration->id.'/'.$case_duration['id']); ?>"><?php echo _l("edit")?> </a>
                                            | <a href="<?php echo admin_url('legalservices/regular_durations/delete_case_duration/'.$case_duration['id'].'/'.$case_duration['case_id']); ?>" class="_delete text-danger"><?php echo _l("delete")?> </a>
                                        </div>
                                    </td>
                                    <td><?php echo $case_duration['days'] ; ?> </td>
                                    <td><?php echo $case_duration['start_date']; ?> </td>
                                    <td><?php echo $case_duration['end_date']; ?> </td>


                                </tr>
                            <?php } ?>

                            </tbody>
                        </table>


                    </div>
                </div>
            </div>
        </div>
    </div>


<script>

</script>
</body>
</html>
