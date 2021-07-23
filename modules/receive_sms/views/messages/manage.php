<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12" id="small-table">
                <div class="panel_s">
                    <div class="panel-body">
                        <h3><?php echo $title ?></h3>
                        <div class="clearfix"></div>
                        <hr class="hr-panel-heading" />
                        <div class="clearfix"></div>

                        <?php if(!isset($error)){ ?>

                            <table class="table dt-table scroll-responsive table-case-files" data-order-type="desc">
                                <thead>
                                <tr>
<!--                                    <th>--><?php //echo _l('message'); ?><!--</th>-->
                                    <th><?php echo _l('sender'); ?></th>
                                    <th><?php echo _l('date'); ?></th>
                                    <th><?php echo _l('options'); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach($messages as $message){
                                    ?>
                                    <tr>

<!--                                        <td data-order="--><?php //echo $message->msg; ?><!--">--><?php //echo $message->msg; ?><!--</td>-->


                                        <td data-order="<?php echo $message->phone; ?>"><?php echo $message->phone; ?></td>


                                        <td data-order="<?php echo $message->date; ?>"><?php echo $message->date; ?></td>

                                        <td>
                                            <button onclick="show('<?php echo $message->id ?>')" type="button" data-toggle="modal" class="btn btn-default btn-icon"><i class="fa fa-eye"></i></button>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                            <?php $this->load->view('messages/modal') ?>

                        <?php }else{ ?>
                            <div class="col-md-12">
                                <div class="alert alert-warning" >
                                    <h4><b><?php echo _l('error') ?></b></h4>
                                    <hr class="hr-10">
                                    <p>
                                        <b><?php echo $error ?></b>
                                    </p>
                                </div>
                            </div>
                        <?php } ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
<script>


    $("#show_msg").on('hidden.bs.modal', function(){
       //location.reload()
    });

</script>
<script>
    var _rel_id = $('#rel_id'),
        _rel_type = $('#rel_type'),
        _rel_id_wrapper = $('#rel_id_wrapper'),
        data = {};

    var _milestone_selected_data;
    _milestone_selected_data = undefined;

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
            judge_id: 'required',
            //court_id: 'required',
            time: 'required',
            repeat_every_custom: { min: 1},
        },session_form_handler);

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
        });

        init_datepicker();
        init_color_pickers();
        init_selectpicker();
        task_rel_select();

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
                            //reset_task_duedate_input();
                        }
                        init_project_details(_rel_type.val(),project.allow_to_view_tasks);
                    },'json');
                } else {
                    //reset_task_duedate_input();
                }
            }
        });

        <?php if(!isset($task) && $rel_id != ''){ ?>
        _rel_id.change();
        <?php } ?>

        $('#time').datetimepicker({
            datepicker:false,
            format:'H:i'
        });
    });


    function task_rel_select(){
        var serverData = {};
        serverData.rel_id = _rel_id.val();
        data.type = _rel_type.val();
        init_ajax_search(_rel_type.val(),_rel_id,serverData);
    }


</script>