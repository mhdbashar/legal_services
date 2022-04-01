(function($) {
    "use strict";
        jQuery.validator.addMethod("alphanumeric", function(value, element) {
            return this.optional(element) || /^[a-zA-Z0-9]+$/i.test(value) ||  /^[\u0600-\u06FF]+$/i.test(value);
        }, "Letters, numbers, and underscores only please");
        appValidateForm($("body").find('#google-sheets-form'), {
            name: {'required':true,'alphanumeric':true,'maxlength':50},
        }
        );
    })(jQuery);
    
    function add_new_sheet() {
        $('#googlesheets').modal('show');
        $('.edit-title').addClass('hide');
    }
    
    function edit_sheet(data) {


        $('#googlesheets_edit').modal('show');
        $('#googlesheets_edit input[name="name"]').val($(data).data('name'));
        $('#googlesheets_edit input[name="id"]').val($(data).data('id'));


    }
    function save_sheet(data) {

        $('#googlesheets_save').modal('show');
        $('#googlesheets_save input[name="name"]').val($(data).data('name'));
        $('#googlesheets_save input[name="id"]').val($(data).data('id'));
        var _rel_id = $('#rel_id'),
            _rel_type = $('#rel_type'),
            _rel_id_wrapper = $('#rel_id_wrapper'),
            _current_member = undefined,
            data = {};

        var _milestone_selected_data;
        _milestone_selected_data = undefined;

        // <?php if(get_option('new_task_auto_assign_current_member') == '1') { ?>
        //     _current_member = "<?php echo get_staff_user_id(); ?>";
        //     <?php } ?>
        $(function(){

            $( "body" ).off( "change", "#rel_id" );

            var inner_popover_template = '<div class="popover"><div class="arrow"></div><div class="popover-inner"><h3 class="popover-title"></h3><div class="popover-content"></div></div></div>';

            $('#_task_modal .task-menu-options .trigger').popover({
                html: true,
                placement: "bottom",
                trigger: 'click',
                title:"<?php echo _l('actions'); ?>",
                content: function() {
                    return $('body').find('#_task_modal .task-menu-options .content-menu').html();
                },
                template: inner_popover_template
            });

            custom_fields_hyperlink();

            appValidateForm($('#task-form'), {
                name: 'required',
                startdate: 'required',
                repeat_every_custom: { min: 1},
            },task_form_handler);

            $('.rel_id_label').html(_rel_type.find('option:selected').text());

            _rel_type.on('change', function() {

                var clonedSelect = _rel_id.html('').clone();
                _rel_id.selectpicker('destroy').remove();
                _rel_id = clonedSelect;
                $('#rel_id_select').append(clonedSelect);
                $('.rel_id_label').html(_rel_type.find('option:selected').text());

                task_rel_select();
                if($(this).val() != ''){
                    _rel_id_wrapper.removeClass('hide');
                } else {
                    _rel_id_wrapper.addClass('hide');
                }
                init_project_details(_rel_type.val());
            });

            init_datepicker();
            init_color_pickers();
            init_selectpicker();
            task_rel_select();

            var _allAssigneeSelect = $("#assignees").html();

            $('body').on('change','#rel_id',function(){
                if($(this).val() != ''){
                    if(_rel_type.val() == 'project'){
                        $.get(admin_url + 'projects/get_rel_project_data/'+$(this).val()+'/'+taskid,function(project){
                            $("select[name='milestone']").html(project.milestones);
                            if(typeof(_milestone_selected_data) != 'undefined'){
                                $("select[name='milestone']").val(_milestone_selected_data.id);
                                $('input[name="duedate"]').val(_milestone_selected_data.due_date)
                            }
                            $("select[name='milestone']").selectpicker('refresh');

                            $("#assignees").html(project.assignees);
                            if(typeof(_current_member) != 'undefined'){
                                $("#assignees").val(_current_member);
                            }
                            $("#assignees").selectpicker('refresh')
                            if(project.billing_type == 3){
                                $('.task-hours').addClass('project-task-hours');
                            } else {
                                $('.task-hours').removeClass('project-task-hours');
                            }

                            if(project.deadline) {
                                var $duedate = $('#_task_modal #duedate');
                                var currentSelectedTaskDate = $duedate.val();
                                $duedate.attr('data-date-end-date', project.deadline);
                                $duedate.datetimepicker('destroy');
                                init_datepicker($duedate);

                                if(currentSelectedTaskDate) {
                                    var dateTask = new Date(unformat_date(currentSelectedTaskDate));
                                    var projectDeadline = new Date(project.deadline);
                                    if(dateTask > projectDeadline) {
                                        $duedate.val(project.deadline_formatted);
                                    }
                                }
                            } else {
                                reset_task_duedate_input();
                            }
                            init_project_details(_rel_type.val(),project.allow_to_view_tasks);
                        },'json');



                    } else {
                        reset_task_duedate_input();
                    }
                }
            });

            // <?php if(!isset($task) && $rel_id != ''){ ?>
            //     _rel_id.change();
            //     <?php } ?>

            _rel_type.on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
                if (previousValue == 'project') {
                    $("#assignees").html(_allAssigneeSelect);
                    if(typeof(_current_member) != 'undefined'){
                        $("#assignees").val(_current_member);
                    }
                    $("#assignees").selectpicker('refresh')
                }
            });

        });

        // <?php if(isset($_milestone_selected_data)){ ?>
        //     _milestone_selected_data = '<?php echo json_encode($_milestone_selected_data); ?>';
        //     _milestone_selected_data = JSON.parse(_milestone_selected_data);
        //     <?php } ?>

        function task_rel_select(){
            var serverData = {};
            serverData.rel_id = _rel_id.val();
            data.type = _rel_type.val();
            init_ajax_search(_rel_type.val(),_rel_id,serverData);
        }

        function init_project_details(type,tasks_visible_to_customer){
            var wrap = $('.non-project-details');
            var wrap_task_hours = $('.task-hours');
            if(type == 'project'){
                if(wrap_task_hours.hasClass('project-task-hours') == true){
                    wrap_task_hours.removeClass('hide');
                } else {
                    wrap_task_hours.addClass('hide');
                }
                wrap.addClass('hide');
                $('.project-details').removeClass('hide');
            } else {
                wrap_task_hours.removeClass('hide');
                wrap.removeClass('hide');
                $('.project-details').addClass('hide');
                $('.task-visible-to-customer').addClass('hide').prop('checked',false);
            }
            if(typeof(tasks_visible_to_customer) != 'undefined'){
                if(tasks_visible_to_customer == 1){
                    $('.task-visible-to-customer').removeClass('hide');
                    $('.task-visible-to-customer input').prop('checked',true);
                } else {
                    $('.task-visible-to-customer').addClass('hide')
                    $('.task-visible-to-customer input').prop('checked',false);
                }
            }
        }
        function reset_task_duedate_input() {
            var $duedate = $('#_task_modal #duedate');
            $duedate.removeAttr('data-date-end-date');
            $duedate.datetimepicker('destroy');
            init_datepicker($duedate);
        }
    }
    
