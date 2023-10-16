<script>
    $(function() {
        var is_busy_times_enabled = "<?= get_option('appointly_busy_times_enabled'); ?>";
        var allowedLeadsHours = <?= json_encode(json_decode(get_option('appointly_available_hours'))); ?>;
        var appLeadsMinTime = <?= get_option('appointments_show_past_times'); ?>;
        var appLeadsWeekends = <?= (get_option('appointments_disable_weekends')) ? "[0, 6]" : "[]"; ?>;

        var todaysLeadsDate = new Date();
        var currentLeadDate = todaysLeadsDate.getFullYear() + "-" + (((todaysLeadsDate.getMonth() + 1) < 10) ? "0" : "") + (todaysLeadsDate.getMonth() + 1 + "-" + ((todaysLeadsDate.getDate() < 10) ? "0" : "") + todaysLeadsDate.getDate());

        init_selectpicker();
        initAppointmentScheduledDatesStaff();
        init_editor('textarea[name="notes"]', {
            menubar: false,
        });

        $('.modal').on('hidden.bs.modal', function(e) {
            $('.xdsoft_datetimepicker').remove();
            $(this).removeData();
        });

        appValidateForm($("#appointment-internal-crm-form"), {
            subject: "required",
            description: "required",
            date: "required",
            rel_type: "required",
            'attendees[]': {
                required: true,
                minlength: 2
            }
        }, apply_appointments_form_data, {
            'attendees[]': "Please select at least 1 staff member"
        });

        function apply_appointments_form_data(form) {
            $('button[type="submit"], button.close_btn').prop('disabled', true);
            $('button[type="submit"]').html('<i class="fa fa-refresh fa-spin fa-fw"></i>');
            $('#appointment-internal-crm-form .modal-body').addClass('filterBlur');
            $('.modal-title').html(
                "<?= _l('appointment_please_wait'); ?>"
            );

            var formSerializedData = $(form).serializeArray();


            var data = $(form).serialize();
            var url = form.action;

            $.post(url, data).done(function(response) {
                if (response.result) {
                    alert_float('success', "<?= _l("appointment_created"); ?>");
                    setTimeout(() => window.location.reload(), 1000);
                }
            });
            return false;
        }
        function initAppointmentScheduledDatesStaff() {
            var appointmentDatePickerOptions = {
                dayOfWeekStart: app.options.calendar_first_day,
                minDate: 0,
                defaultTime: "09:00",
                allowTimes: allowedLeadsHours,
                minTime: appLeadsMinTime,
                disabledWeekDays: appLeadsWeekends,
                closeOnDateSelect: 0,
                closeOnTimeSelect: 1,
                disabledWeekDays: [5],
                validateOnBlur: false
            };
            var dateFormat = app.options.date_format;
            if (app.options.time_format == 24) {
                appointmentDatePickerOptions.format = dateFormat + " H:i";
            } else {
                // appointmentDatePickerOptions.format = dateFormat + " g:i A";
                appointmentDatePickerOptions.formatTime = "h:i A";
            }

            $('.appointment-date').datetimepicker(appointmentDatePickerOptions);
        }

    });
</script>