<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<p><?php echo _l('regular_durations'); ?></p>
<?php if (has_permission('legal_services', '', 'create')) { ?>
    <hr />
    <?php echo form_open(admin_url('legalservices/regular_durations/add_duration_cases/'.$ServID), array('id' => 'written-reports-form')); ?>
    <?php
    $durations = $this->db->get(db_prefix() . 'regular_durations')->result_array();
    $this->db->where('id', $project->id);
    $case_info= $this->db->get(db_prefix() . 'my_cases')->row();
    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label"><?php echo _l("regular_duration") ; ?></label>
                <select id="duration_id"  name="duration_id" class="form-control custom_select_arrow">
                    <option value="<?php echo $case_info->duration_id; ?>" "selected" ><?php echo  get_dur_name_by_id($case_info->duration_id); ?></option>

                    <?php foreach($durations as $duration){
                        if($duration['id']==$case_info->duration_id)
                        {
                            continue;

                        }
                         if($duration['court_id']==0 && $duration['categories']==0 && $duration['sub_categories'] == 0 ||
                             $duration['court_id']== $case_info->court_id && $duration['categories']==$case_info->cat_id && $duration['sub_categories']==$case_info->subcat_id ||
                             $duration['court_id']== $case_info->court_id && $duration['categories']==0 && $duration['sub_categories']==0 && $case_info->cat_id ==0 && $case_info->subcat_id ==0
                         ){?>
                             <option value="<?php echo $duration['id']; ?>"> <?php echo $duration['name']; ?></option>

                        <?php } ?>

                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <?php echo render_date_input( 'regular_duration_begin_date','regular_duration_begin_date',$case_info->regular_duration_begin_date , [], [],'',"regular_duration_begin_date"); ?>
            <?php echo form_hidden('id',$project->id); ?>

        </div>

    </div>
    <button type="submit" id="save" data-form="#written-reports-form" autocomplete="off" data-loading-text="<?php echo _l('wait_text'); ?>" class="btn btn-info"><?php echo _l('save'); ?></button>
    <?php echo form_close(); ?>
<?php } ?>
<?php init_tail(); ?>
<script>
    $(function(){
        _validate_form($('#written-reports-form'),{duration_id:'required',regular_duration_begin_date:'required'});
    });

  </script>

</body>
</html>


