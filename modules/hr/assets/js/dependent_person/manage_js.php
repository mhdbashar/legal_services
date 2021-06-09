<script>

	$(function(){
		'use strict';

		window.addEventListener('load',function(){
			appValidateForm($("body").find('.job_p'), {
				'job_name': 'required'
			});
		});

		var ContractsServerParams = {
			"staff_id": "select[name='staff[]']",
			"status_id": "select[name='status[]']",
		};

		var table_dependent_person = $('.table-table_dependent_person');
		initDataTable(table_dependent_person, admin_url+'hr/hr_profile/table_dependent_person', [0], [0], ContractsServerParams, [0, 'desc']);

		//hide first column
		var hidden_columns = [1];
		$('.table-table_dependent_person').DataTable().columns(hidden_columns).visible(false, false);

		$('#staff').on('change', function() {
			table_dependent_person.DataTable().ajax.reload().columns.adjust().responsive.recalc();
		});
		$('#status').on('change', function() {
			table_dependent_person.DataTable().ajax.reload().columns.adjust().responsive.recalc();
		});
		

	});

	function approval(invoker){
		'use strict';

		if($('input[name="status"]')){
			$('input[name="status"]').remove();
		}
		if($('input[name="id"]')){
			$('input[name="id"]').remove();
		}

		$('#dependent_status').html('');
		$('#dependent_status').append(hidden_input('status',1));
		$('#dependent_status').append(hidden_input('id',$(invoker).data('dependent_id')));

		$('#approvaldependent input[name="start_month"]').val($(invoker).data('start_month'))
		$('#approvaldependent input[name="end_month"]').val($(invoker).data('end_month'))

		$('.start_month_hide').removeClass('hide');
		$('.end_month_hide').removeClass('hide');

		$('#approvaldependent').modal('show');
		$('.reject-title').addClass('hide');
		$('.approval-title').removeClass('hide');
	}

	function reject(invoker){
		'use strict';

		if($('input[name="status"]')){
			$('input[name="status"]').remove();
		}
		if($('input[name="id"]')){
			$('input[name="id"]').remove();
		}

		$('#dependent_status').html('');
		$('#dependent_status').append(hidden_input('status',2));
		$('#dependent_status').append(hidden_input('id',$(invoker).data('dependent_id')));

		$('#approvaldependent input[name="start_month"]').val('')
		$('#approvaldependent input[name="end_month"]').val('')

		$('.start_month_hide').addClass('hide');
		$('.end_month_hide').addClass('hide');

		$('#approvaldependent').modal('show');
		$('.approval-title').addClass('hide');
		$('.reject-title').removeClass('hide');
	}

	function update_status(invoker){
		'use strict';

		var id = $('input[name="id"]').val();
		var status = $('input[name="status"]').val();

		if(id != '' && status != ''){
			var formData = new FormData();
			formData.append("csrf_token_name", $('input[name="csrf_token_name"]').val());
			formData.append("id", id);
			formData.append("status", status);
			formData.append("start_month", $('input[name="start_month"]').val());
			formData.append("end_month", $('input[name="end_month"]').val());
			formData.append("reason", $('input[name="reason"]').val());
			$.ajax({ 
				url: admin_url + 'hr/hr_profile/approval_status',
				method: 'post', 
				data: formData, 
				contentType: false, 
				processData: false
			}).done(function(response) {
				response = JSON.parse(response);

				var table_dependent_person = $('.table-table_dependent_person');
				table_dependent_person.DataTable().ajax.reload(null, false)
				.columns.adjust()
				.responsive.recalc();

				if(response.success == true){
					alert_float('success', response.message);
					$('#approvaldependent').modal('hide');

				}else{
					alert_float('warning', response.message);
					$('#approvaldependent').modal('hide');

				}
			});
		}
	}

	function dependent_person_update(staff_id, dependent_person_id, manage) {
		"use strict";

		$("#modal_wrapper").load("<?php echo admin_url('hr/hr_profile/dependent_person_modal'); ?>", {
			slug: 'update',
			staff_id: staff_id,
			dependent_person_id: dependent_person_id,
			manage: manage
		}, function() {
			if ($('.modal-backdrop.fade').hasClass('in')) {
				$('.modal-backdrop.fade').remove();
			}
			if ($('#dependentPersonModal').is(':hidden')) {
				$('#dependentPersonModal').modal({
					show: true
				});
			}
		});

		init_selectpicker();
		$(".selectpicker").selectpicker('refresh');
	}

	function dependent_person_add(staff_id, dependent_person_id, manage) {
		"use strict";

		$("#modal_wrapper").load("<?php echo admin_url('hr/hr_profile/dependent_person_modal'); ?>", {
			slug: 'create',
			staff_id: staff_id,
			dependent_person_id: dependent_person_id,
			manage: manage
		}, function() {
			if ($('.modal-backdrop.fade').hasClass('in')) {
				$('.modal-backdrop.fade').remove();
			}
			if ($('#dependentPersonModal').is(':hidden')) {
				$('#dependentPersonModal').modal({
					show: true
				});
			}
		});

		init_selectpicker();
		$(".selectpicker").selectpicker('refresh');
	}

	function staff_bulk_actions(){
		'use strict';

		$('#table_contract_bulk_actions').modal('show');
	}

   // Leads bulk action
   function staff_delete_bulk_action(event) {
   	'use strict';

   	if (confirm_delete()) {
   		var mass_delete = $('#mass_delete').prop('checked');

   		if(mass_delete == true){
   			var ids = [];
   			var data = {};

   			data.mass_delete = true;
   			data.rel_type = 'hrm_dependent_person';

   			var rows = $('#table-table_dependent_person').find('tbody tr');
   			$.each(rows, function() {
   				var checkbox = $($(this).find('td').eq(0)).find('input');
   				if (checkbox.prop('checked') === true) {
   					ids.push(checkbox.val());
   				}
   			});

   			data.ids = ids;
   			$(event).addClass('disabled');
   			setTimeout(function() {
   				$.post(admin_url + 'hr/hr_profile/hrm_delete_bulk_action_v2', data).done(function() {
   					window.location.reload();
   				}).fail(function(data) {
   					$('#table_contract_bulk_actions').modal('hide');
   					alert_float('danger', data.responseText);
   				});
   			}, 200);
   		}else{
   			window.location.reload();
   		}

   	}
   }


</script>
<script>

    $(function(){
        appValidateForm($('#import_form'),{file_csv:{required:true,extension: "xlsx"},source:'required',status:'required'});
    });
    // function


    function uploadfilecsv(){
        if(($("#file_csv").val() != '') && ($("#file_csv").val().split('.').pop() == 'xlsx')){
            var formData = new FormData();
            formData.append("file_csv", $('#file_csv')[0].files[0]);
            formData.append("csrf_token_name", $('input[name="csrf_token_name"]').val());
            formData.append("leads_import", $('input[name="leads_import"]').val());

            $.ajax({
                url: admin_url + 'hr/hr_profile/import_file_xlsx_hrm_contract',
                method: 'post',
                data: formData,
                contentType: false,
                processData: false

            }).done(function(response) {
                response = JSON.parse(response);
                $("#file_csv").val(null);
                $("#file_csv").change();
                $(".panel-body").find("#file_upload_response").html();

                if($(".panel-body").find("#file_upload_response").html() != ''){
                    $(".panel-body").find("#file_upload_response").empty();
                };

                if(response.total_rows){
                    $( "#file_upload_response" ).append( "<h4><?php echo _l("_Result") ?></h4><h5><?php echo _l('import_line_number') ?> :"+response.total_rows+" </h5>" );
                }
                if(response.total_row_success){
                    $( "#file_upload_response" ).append( "<h5><?php echo _l('import_line_number_success') ?> :"+response.total_row_success+" </h5>" );
                }
                if(response.total_row_false){
                    $( "#file_upload_response" ).append( "<h5><?php echo _l('import_line_number_failed') ?> :"+response.total_row_false+" </h5>" );
                }
                if(response.total_row_false > 0)
                {
                    $( "#file_upload_response" ).append( '<a href="'+response.site_url+'FILE_ERROR_IMPORT_STAFF_CONTRACT'+response.staff_id+'.xlsx" class="btn btn-warning"  ><?php echo _l('hr_download_file_error') ?></a>' );
                }
                if(response.total_rows < 1){
                    alert_float('warning', response.message);
                }
            });
            return false;
        }else if($("#file_csv").val() != ''){
            alert_float('warning', "<?php echo _l('_please_select_a_file') ?>");
        }

    }
</script>