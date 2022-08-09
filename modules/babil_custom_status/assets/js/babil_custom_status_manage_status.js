(function($) {
"use strict";
	jQuery.validator.addMethod("alphanumeric", function(value, element) {
    	return this.optional(element) || /(\w+:\/\/)?([-.a-z0-9_\u0600-\u06FF\u08A0-\u08FF]+)(\.\w+)(:\d{1,5})?(\/\S*)?/i || /^[\w. ]+$/i.test(value);
	}, "Letters, numbers, and underscores only please");
	appValidateForm($("body").find('#babil-custom-status-form'), {
		name: {'required':true,'alphanumeric':true,'maxlength':50},
		color:{'maxlength':7},
		order:{'min':0},
	}, manage_custom_statuses);
	$('#babil_custom_status').on("hidden.bs.modal", function (event) {
		$('#additional').html('');
		$('#babil_custom_status input[name="name"]').val('');
		$('#babil_custom_status input[name="color"]').val('');
		$('#babil_custom_status input[name="order"]').val('');
		$('#babil_custom_status #filter_default').attr('checked',false);
		$('.add-title').removeClass('hide');
		$('.edit-title').removeClass('hide');
		$('#babil_custom_status input[name="order"]').val($('table tbody tr').length + 1);
	});
})(jQuery);

function babil_new_status() {
	$('#babil_custom_status').modal('show');
	$('.edit-title').addClass('hide');
}

function babil_edit_status(invoker, id) {
	$('#additional').append(hidden_input('id', id));
	$('#babil_custom_status input[name="name"]').val($(invoker).data('name'));
	$('#babil_custom_status .colorpicker-input').colorpicker('setValue', $(invoker).data('color'));
	$('#babil_custom_status input[name="order"]').val($(invoker).data('order'));
	$('#babil_custom_status #filter_default').attr('checked',($(invoker).data('filter_default')?true:false));
	$('#babil_custom_status').modal('show');
	$('.add-title').addClass('hide');
}

function manage_custom_statuses(form) {
	var data = $(form).serialize();
	var url = form.action;
	$.post(url, data).done(function (response) {
		window.location.reload();
	});
	return false;
}