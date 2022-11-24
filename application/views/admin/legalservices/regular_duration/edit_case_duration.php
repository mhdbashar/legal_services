<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <?php echo form_open($this->uri->uri_string(),array('id'=>'regular_duration-form')); ?>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel_s">
                    <div class="panel-body">
                        <h4 class="no-margin">
                            <?php echo _l("select_regular_duration") ; ?>
                        </h4>
                        <hr class="hr-panel-heading" />
                        <div class="clearfix"></div>
                        <?php
                        $durations = get_durations();
                        ?>
                        <?php
                        $case_info=get_case_by_id($case_id);
                        $case_duration=get_case_duration_by_id($id);

                        ?>
                        <div class="form-group">
                            <label class="control-label"><?php echo _l("regular_duration") ; ?></label>
                            <select id="duration_id"  name="reg_id" class="form-control custom_select_arrow" >
                                <option value="<?php echo $case_duration->reg_id ?>"> <?php echo _l(get_dur_name_by_id($case_duration->reg_id)); ?></option>

                                <?php foreach($durations as $duration){
                                    if($duration->court_id==0 && $duration->categories==0 && $duration->sub_categories== 0 ||
                                        $duration->court_id== $case_info->court_id && $duration->categories==$case_info->cat_id && $duration->sub_categories==$case_info->subcat_id ||
                                        $duration->court_id== $case_info->court_id && $duration->categories==0 && $duration->sub_categories==0 && $case_info->cat_id ==0 && $case_info->subcat_id ==0
                                    ){
                                        ?>
                                        <option value="<?php echo $duration->id;?>"><?php echo $duration->name; ?> </option>

                                    <?php } ?>

                                <?php } ?>

                            </select>
                        </div>
                        <div class="form-group">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php echo render_date_input( 'start_date','regular_duration_begin_date1',$case_duration->start_date ); ?>
                                        <?php echo form_hidden('case_id',$case_id); ?>
                                        <?php //echo form_hidden('case_id',$case_info->reg_id); ?>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>
            </div>

            <div class="btn-bottom-toolbar btn-toolbar-container-out text-right">
                <button type="submit" class="btn btn-info pull-right"><?php echo _l('submit'); ?></button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<?php init_tail(); ?>
<script>
    $(function(){
        _validate_form($('#regular_duration-form'),{reg_id:'required',start_date:'required'});
    });



    }
</script>
</body>
</html>


