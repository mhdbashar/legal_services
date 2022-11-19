<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal fade invoice-project" id="invoice-project-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-xxl" role="document">
        <?php echo form_open('admin/legalservices/disputes_invoices/invoice_project/'.$project->id,array('id'=>'disputes_invoice_project_form','class'=>'_transaction_form invoice-form')); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="edit-title"><?php echo _l('invoice_project'); ?></span>
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php $this->load->view('admin/legalservices/disputes_cases/invoices/invoice_template'); ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="background-color: #fff">
                <!--<button class="btn btn-default invoice-form-submit save-as-draft transaction-submit">
                    <?php echo _l('save_as_draft'); ?>
                </button>-->
                <button disabled="true" class="submit_total btn btn-info invoice-form-submit save-and-send transaction-submit">
                      <?php echo _l('save_and_send'); ?>
                </button>
                <button disabled="true" class="submit_total btn btn-info invoice-form-submit transaction-submit">
                    <?php echo _l('submit'); ?>
                </button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<?php $this->load->view('admin/invoice_items/item'); ?>
<script>


    init_ajax_search('customer','#clientid.ajax-search');
    init_ajax_search('items','#item_select.ajax-search',undefined,admin_url+'items/search');
    custom_fields_hyperlink();
    init_tags_inputs();
    init_selectpicker();
    init_datepicker();
    init_color_pickers();
    init_items_sortable();
    validate_disputes_invoice_form('#disputes_invoice_project_form');
    $('#invoice-project-modal #clientid').change();
    $('input[name="show_quantity_as"]:checked').change();
    disputes_calculate_total();


</script>
