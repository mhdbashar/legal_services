<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
			<?php
			echo form_open($this->uri->uri_string(),array('id'=>'invoice-form','class'=>'_transaction_form invoice-form'));
			if(isset($invoice)){
				echo form_hidden('isedit');
			}
			?>
			<div class="col-md-12">
				<?php $this->load->view('admin/legalservices/disputes_cases/invoices/invoice_template'); ?>
			</div>
			<?php echo form_close(); ?>
			<!--<?php $this->load->view('admin/legalservices/disputes_cases/invoice_items/item'); ?>-->
		</div>
	</div>
</div>
<?php init_tail(); ?>
<script>
/*function validate_disputes_invoice_form(selector) {
    selector = typeof(selector) == 'undefined' ? '#invoice-form' : selector;

    appValidateForm($(selector), {
        clientid: {
            required: {
                depends: function() {
                    var customerRemoved = $('select#clientid').hasClass('customer-removed');
                    return !customerRemoved;
                }
            }
        },
        date: 'required',
        currency: 'required',
        repeat_every_custom: { min: 1 },
        number: {
            required: true,
        }
    });
    $("body").find('input[name="number"]').rules('add', {
        remote: {
            url: admin_url + "legalservices/disputes_invoices/validate_invoice_number",
            type: 'post',
            data: {
                number: function() {
                    return $('input[name="number"]').val();
                },
                isedit: function() {
                    return $('input[name="number"]').data('isedit');
                },
                original_number: function() {
                    return $('input[name="number"]').data('original-number');
                },
                date: function() {
                    return $('input[name="date"]').val();
                },
            }
        },
        messages: {
            remote: app.lang.invoice_number_exists,
        }
    });
}*/

	$(function(){
		validate_disputes_invoice_form();
	    // Init accountacy currency symbol
	    init_currency();
	    // Project ajax search
	    init_ajax_project_search_by_customer_id();
	    // Maybe items ajax search
	    init_ajax_search('items','#item_select.ajax-search',undefined,admin_url+'items/search');

	    show_installments();
	});

<?php
   if(isset($invoice)){
    echo('is_not_recurring();');
   }
?>
</script>
</body>
</html>
