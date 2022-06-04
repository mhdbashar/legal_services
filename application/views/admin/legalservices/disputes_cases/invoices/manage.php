<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php if(isset($invoiceid) && $invoiceid != ''){
    init_head(); ?>
    <div id="wrapper">
        <div class="content">
            <div class="row">
<?php } ?>

<?php include_once(APPPATH . 'views/admin/legalservices/disputes_cases/invoices/invoices_top_stats.php'); ?>
<div class="project_invoices">
    <?php include_once(APPPATH.'views/admin/legalservices/disputes_cases/invoices/filter_params.php'); ?>
    <?php $this->load->view('admin/legalservices/disputes_cases/invoices/list_template'); ?>
</div>
<?php if(isset($invoiceid) && $invoiceid != ''){?>
            </div>
        </div>
    </div>
    <?php init_tail(); ?>
<?php } ?>

<?php //init_head(); ?>
<!--<div id="wrapper">-->
<!--	<div class="content">-->
<!--		<div class="row">-->
<!--			--><?php
//			include_once(APPPATH.'../modules/disputes/views/invoices/filter_params.php');
//			$this->load->view('disputes/invoices/list_template');
//			?>
<!--		</div>-->
<!--	</div>-->
<!--</div>-->
<?php //$this->load->view('admin/includes/modals/sales_attach_file'); ?>
<script>var hidden_columns = [2,6,7,8];</script>
<?php //init_tail(); ?>
<script>
    // $(function(){
    //
    //     init_invoice_disputes();
    //
    // });
    // $(function(){
    //     init_invoice();
    //     init_invoice_case();
    //     init_invoice_oservice();
    //     init_invoice_disputes();
    //
    // });

	function record_payment_disputes(id) {
    	if (typeof(id) == 'undefined' || id === '') { return; }
    	$('#invoice').load(admin_url + 'legalservices/disputes_invoices/record_invoice_payment_ajax/' + id);
	}
    function init_disputes_invoices_total(manual) {

        if ($('#invoices_total').length === 0) { return; }
        var _inv_total_inline = $('.invoices-total-inline');
        var _inv_total_href_manual = $('.invoices-total');

        if ($("body").hasClass('invoices-total-manual') && typeof(manual) == 'undefined' &&
            !_inv_total_href_manual.hasClass('initialized')) {
            return;
        }

        if (_inv_total_inline.length > 0 && _inv_total_href_manual.hasClass('initialized')) {
            // On the next request won't be inline in case of currency change
            // Used on dashboard
            _inv_total_inline.removeClass('invoices-total-inline');
            return;
        }

        _inv_total_href_manual.addClass('initialized');
        var _years = $("body").find('select[name="invoices_total_years"]').selectpicker('val');
        var years = [];
        $.each(_years, function(i, _y) {
            if (_y !== '') { years.push(_y); }
        });

        var currency = $("body").find('select[name="total_currency"]').val();
        var data = {
            currency: currency,
            years: years,
            init_total: true,
        };

        var project_id = $('input[name="project_id"]').val();
        var customer_id = $('.customer_profile input[name="userid"]').val();
        if (typeof(project_id) != 'undefined') {
            data.project_id = project_id;
        } else if (typeof(customer_id) != 'undefined') {
            data.customer_id = customer_id;
        }
        $.post(admin_url + 'legalservices/disputes_invoices/get_invoices_total', data).done(function(response) {
            $('#invoices_total').html(response);
        });
    }


	// Init single invoice

</script>
</body>
</html>
