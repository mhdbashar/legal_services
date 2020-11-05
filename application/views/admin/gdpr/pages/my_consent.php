<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<h4 class="no-mtop">
    <?php echo _l('gdpr_consent'); ?>
    <small>
        <a href="https://ico.org.uk/for-organisations/guide-to-the-general-data-protection-regulation-gdpr/lawful-basis-for-processing/consent/" target="_blank"><?php echo _l('learn_more'); ?></a>
    </small>
</h4>
<hr class="hr-panel-heading">
<?php render_yes_no_option('gdpr_enable_consent_for_contacts','gdbr_enable_consent_for_contacts'); ?>
<hr />
<?php render_yes_no_option('gdpr_enable_consent_for_leads','gdpr_enable_consent_for_leads'); ?>
<hr />
<p class="">
    <?php echo _l('gdpr_public_page_consent_information_block');?>
</p>
<?php echo render_textarea('settings[gdpr_consent_public_page_top_block]','',get_option('gdpr_consent_public_page_top_block'),array(),array(),'','tinymce'); ?>

<hr class="hr-panel-heading" />
<button type="button" class="btn btn-info pull-left mright10" onclick="conset_purpose(); return false;" data-toggle="tooltip" title=<?php echo _l("gdpr_new_consent_purpose");?>><i class="fa fa-plus-square-o"></i></button>
<h4 class="mbot30 mtop7 pull-left"><?php echo _l('gdpr_purposes_of_consent');?></h4>

<div class="clearfix"></div>
<table class="table dt-table scroll-responsive" data-order-type="desc" data-order-col="1">
    <thead>
        <tr>
            <th> <?php echo _l('gdpr_name');?> </th>
            <th> <?php echo _l('gdpr_description');?> </th>
            <th> <?php echo _l('gdpr_created');?> </th>
            <th> <?php echo _l('gdpr_last_update');?> </th>
            <th> <?php echo _l('gdpr_options');?> </th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach($consent_purposes as $purpose) { ?>
        <tr>
            <td><?php echo $purpose['name']; ?></td>
            <td><?php echo $purpose['description']; ?></td>
            <td data-order="<?php echo $purpose['date_created']; ?>"><?php echo _dt($purpose['date_created']); ?></td>
            <td data-order="<?php echo $purpose['last_updated']; ?>"><?php echo _dt($purpose['last_updated']); ?></td>
            <td>
                <?php
                    echo icon_btn('#' . $purpose['id'], 'pencil-square-o', 'btn-default', ['onclick'=>'conset_purpose('.$purpose['id'].'); return false;']);
                    echo icon_btn('gdpr/delete_consent_purpose/' . $purpose['id'], 'remove', 'btn-danger _delete');
                ?>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    function conset_purpose(id) {
        var url = admin_url+'gdpr/consent_purpose';
        if(typeof(id) != 'undefined') {
            url += '/' + id;
        }
        requestGet(url).done(function(response){
            $('#page-tail').html(response);
            $('#consentModal').modal('show');
            var $consentForm = $('#consentForm');
            $consentForm.attr('action', url);
            appValidateForm($consentForm, {
                name:'required',
            });
        });
    }
</script>
