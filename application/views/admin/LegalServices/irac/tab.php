<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<p><?php echo _l('IRAC_method'); ?></p>
<?php /*if(!empty($IRAC)): ?>
<div class="btn-group">
    <a href="#" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-file-pdf-o"></i>
        <?php echo _l('more'); ?>
        <?php if(is_mobile()){echo ' PDF';} ?> <span class="caret"></span></a>
    <ul class="dropdown-menu dropdown-menu-right">
        <li class="hidden-xs"><a href="<?php echo admin_url('LegalServices/irac/pdf/'.$ServID.'/'.$id.'?output_type=I'); ?>"><?php echo _l('view_pdf'); ?></a></li>
        <li class="hidden-xs"><a href="<?php echo admin_url('LegalServices/irac/pdf/'.$ServID.'/'.$id.'?output_type=I'); ?>" target="_blank"><?php echo _l('view_pdf_in_new_window'); ?></a></li>
        <li><a href="<?php echo admin_url('LegalServices/irac/pdf/'.$ServID.'/'.$id); ?>"><?php echo _l('download'); ?></a></li>
        <li>
            <a href="<?php echo admin_url('LegalServices/irac/pdf/'.$ServID.'/'.$id.'?print=true'); ?>" target="_blank">
                <?php echo _l('print'); ?>
            </a>
        </li>
    </ul>
</div>
<?php endif;*/ ?>
<hr />
<?php echo form_open(admin_url('LegalServices/irac/edit/'.$ServID.'/'.$id)); ?>
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="head_facts">
            <h4 class="panel-title collapsed" role="button" data-toggle="collapse" href="#facts" aria-expanded="false" aria-controls="collapseOne">
                <?php echo _l('facts'); ?>
            </h4>
        </div>
        <div id="facts" class="panel-collapse collapse" role="tabpanel" aria-labelledby="head_facts">
            <div class="panel-body">
                <?php echo render_textarea('facts','',isset($IRAC) ? $IRAC->facts : '',array(),array(),'','tinymce'); ?>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="head_legal_authority">
            <h4 class="panel-title collapsed" role="button" data-toggle="collapse" href="#legal_authority" aria-expanded="false" aria-controls="collapseOne">
                <?php echo _l('legal_authority'); ?>
            </h4>
        </div>
        <div id="legal_authority" class="panel-collapse collapse" role="tabpanel" aria-labelledby="head_legal_authority">
            <div class="panel-body">
                <?php echo render_textarea('legal_authority','',isset($IRAC) ? $IRAC->legal_authority : '',array(),array(),'','tinymce'); ?>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="head_analysis">
            <h4 class="panel-title collapsed" role="button" data-toggle="collapse" href="#analysis" aria-expanded="false" aria-controls="collapseOne">
                <?php echo _l('analysis'); ?>
            </h4>
        </div>
        <div id="analysis" class="panel-collapse collapse" role="tabpanel" aria-labelledby="head_analysis">
            <div class="panel-body">
                <?php echo render_textarea('analysis','',isset($IRAC) ? $IRAC->analysis : '',array(),array(),'','tinymce'); ?>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="head_result">
            <h4 class="panel-title collapsed" role="button" data-toggle="collapse" href="#IRAC_result" aria-expanded="false" aria-controls="collapseOne">
                <?php echo _l('IRAC_result'); ?>
            </h4>
        </div>
        <div id="IRAC_result" class="panel-collapse collapse" role="tabpanel" aria-labelledby="head_result">
            <div class="panel-body">
                <?php echo render_textarea('result','',isset($IRAC) ? $IRAC->result : '',array(),array(),'','tinymce'); ?>
            </div>
        </div>
    </div>
</div>
<button type="submit" class="btn btn-info"><?php echo _l('save'); ?></button>
<?php echo form_close(); ?>
