<script>
    $(function() {
        appValidateForm($("#callback-notes"), {
            callback_notes_description: "required",
        });
        init_selectpicker();
        // When adding if callback is contacted today
        $("body").on('change', 'input[name="callback_contacted_today"]', function() {
            var checked = $(this).prop('checked');
            var csdc = $('.callback-select-date-contacted');
            (checked == false ? csdc.removeClass('hide') : csdc.addClass('hide'));
        });

        // callback modal show contacted indicator input
        $("body").on('change', 'input[name="callback_contacted_indicator"]', function() {
            var csdc = $('.callback-select-date-contacted');
            ($(this).val() == 'yes' ? csdc.removeClass('hide') : csdc.addClass('hide'));
        });


    });
    $('#callbackView').on('hidden.bs.modal', function() {
        $(this).removeData();
        $(this).find('form')[0].reset();
    });

    var appointmentDatePickerOptionsExternal = {
        dayOfWeekStart: app.options.calendar_first_day,
        minDate: 0,
        closeOnDateSelect: 0,
        closeOnTimeSelect: 1,
        validateOnBlur: false,
    };

    var dateFormat = app.options.date_format;
    if (app.options.time_format == 24) {
        appointmentDatePickerOptionsExternal.format = dateFormat + " H:i";
    } else {
        // appointmentDatePickerOptionsExternal.format = dateFormat + " g:i A";
        // appointmentDatePickerOptionsExternal.formatTime = "g:i A";
    }

    $('#custom_contact_date').datetimepicker(appointmentDatePickerOptionsExternal);

    jQuery.datetimepicker.setLocale(app.locale);
</script>