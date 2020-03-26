<div class="text-center">
    <div class="alert alert-warning">
        <i class="fa fa-paperclip" aria-hidden="true"></i> <?php echo _l('file_phase'); ?>
    </div>
</div>
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
<?php if(isset($phases)): ?>
<div class="panel panel-default">
<?php echo form_open(admin_url('LegalServices/Phases_controller/handle_phases/'.$ServID.'/'.$project->id),array('id'=> 'form_phases')); ?>
<?php
$i=1;
foreach ($phases as $phase):
    $custom_fields = false;
    if (total_rows(db_prefix() . 'customfields', array('fieldto' => $phase->slug.'_'.$service->slug, 'active' => 1)) > 0) {
        $custom_fields = true;
    }

    $showing = false;
    $var_phase = substr($phase->slug, -1, 1) - 1;
    $p_phase = $var_phase == 0 ? 1 : $var_phase;
    $previous_slug = 'legal_phase_'.$p_phase.'_'.$service->slug;

    if(count($phases) == $i){
        $slug_for_btn_previous1 = $phase->slug.'_'.$service->slug;
        $slug_for_btn_previous2 = $previous_slug;
    }else{
        $slug_for_btn_previous1 = $previous_slug;
        $slug_for_btn_previous2 = null;
    }


    if (total_rows(db_prefix() . 'customfieldsvalues', array('fieldto' => $previous_slug, 'relid' => $project->id)) > 0) {
        $showing = true;
    }

    $compleate = false;
    if (total_rows(db_prefix() . 'customfieldsvalues', array('fieldto' =>$phase->slug.'_'.$service->slug, 'relid' => $project->id)) > 0) {
        $compleate = true;
    }
    ?>
    <?php if($showing || $i == 1): ?>
    <div class="panel-heading" role="tab" id="phase<?php echo $phase->id; ?>" style="background-color: #f1f5f7;">
        <h4 class="panel-title" role="button" data-toggle="collapse" data-parent="#accordion" href="#<?php echo $phase->slug; ?>" aria-expanded="true" aria-controls="collapseOne">
            <?php echo $i.'- '.$phase->name; ?>
            <?php if($compleate){ ?>
                <i class="fa fa-check-circle text-success" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="<?php echo _l('phase_compleate'); ?>"></i>
            <?php }else{ ?>
                <i class="fa fa-exclamation-circle text-warning" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="<?php echo _l('phase_not_compleate'); ?>"></i>
            <?php } ?>
        </h4>
    </div>
    <div id="<?php echo $phase->slug; ?>" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="phase<?php echo $phase->id; ?>" <?php if($compleate && count($phases) != $i){ ?> style="pointer-events: none;opacity: 0.6;" <?php } ?>>
        <div class="panel-body" <?php if($compleate && count($phases) != $i){ ?>style="background-color: #e1e6ec;"<?php } ?>>
            <div class="row">
                <div class="col-md-6">
                    <!-- custom_fields -->
                    <?php if ($custom_fields) { ?>
                        <div role="tabpanel" id="custom_fields">
                            <?php $rel_id = (isset($phase) ? $phase->id : false); ?>
                            <?php echo render_custom_fields($phase->slug.'_'.$service->slug, $project->id); ?>
                        </div>
                    <?php }else{ ?>
                        <div class="alert alert-danger">
                          <?php echo _l('create_fields') ?>
                            <a href="<?php echo admin_url('custom_fields'); ?>" target="_blank"><?php echo _l('from_here') ?></a>
                        </div>
                    <?php } ?>
                    <input type="hidden" name="legal_phase[<?php echo $phase->id; ?>]" value="<?php echo $phase->id; ?>">
                    <?php if(!$compleate || count($phases) == $i){ ?>
                    <?php if($custom_fields){ ?>
                    <button type="submit" class="btn btn-success"><?php echo _l('submit'); ?></button>
                    <?php } ?>
                    <?php if($i != 1){ ?>
                    <button type="button" class="btn btn-primary" onclick="back_to_previous_phase(<?php echo $project->id; ?>, '<?php echo $slug_for_btn_previous1; ?>', '<?php echo $slug_for_btn_previous2; ?>')"><?php echo _l('back_to_previous_phase'); ?> <i class="fa fa-backward" aria-hidden="true"></i></button>
                    <?php } ?>
                    <?php /*<button type="button" class="btn btn-danger"><?php echo _l('waiver'); ?> <i class="fa fa-thumbs-o-down" aria-hidden="true"></i></button> */ ?>
                    <?php } ?>
                </div>
                <?php /*if(!$compleate && $custom_fields){
                <div class="col-md-6 text-center">
                    <div class="alert alert-warning">
                        <i class="fa fa-paperclip" aria-hidden="true"></i> <?php echo _l('file_phase'); ?>
                    </div>
                </div>
                } */ ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
<?php $i++; endforeach; ?>
<?php form_close(); ?>
</div>
<?php else: ?>
    <div class="alert alert-danger">
        <?php echo _l('no_phases') ?>
        <a href="<?php echo admin_url('LegalServices/Phases_controller'); ?>" target="_blank"><?php echo _l('from_here') ?></a>
    </div>
<?php endif; ?>
</div>
<script type="text/javascript">
    function hide_show_delay_period() {
        $('#assign_has_delay,#decision34_has_delay,#announcement_has_delay,#decision46_has_delay,#decision83_has_delay').change(function(){
            if(this.checked){
                $('.month').removeAttr("style").fadeIn('slow');
                $('#assign_delay_period,#decision34_delay_period,#announcement_delay_period,#decision46_delay_period,#decision83_delay_period').removeAttr("style").fadeIn('slow');
            }else{
                $('.month').fadeOut('slow');
                $('#assign_delay_period,#decision34_delay_period,#announcement_delay_period,#decision46_delay_period,#decision83_delay_period').fadeOut('slow');
            }
        });
    }

    function back_to_previous_phase(relid, slug1, slug2){
        if (confirm_delete()) {
            $.ajax({
                url: '<?php echo admin_url('LegalServices/Phases_controller/back_to_previous_phase/'); ?>' + relid + '/' + slug1 + '/' + slug2,
                success: function (data) {
                    if(data == true){
                        alert_float('success', '<?php echo _l('Done').' '._l('back_to_previous_phase'); ?>');
                        location.reload();
                    }else {
                        alert_float('danger', '<?php echo _l('faild').' '._l('back_to_previous_phase'); ?>');
                        alert_float('danger', data);
                    }
                }
            });
        }else {
            return false;
        }
    }
</script>