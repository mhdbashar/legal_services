
<div class="modal fade" id="show_msg" tabindex="-1" role="dialog" aria-labelledby="show_msg">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="add-title"><?php echo _l("message"); ?></span>
                </h4>
            </div>
            <?php echo form_open_multipart(admin_url('babil_sms_gateway/save_sms'),array('id'=>'form_transout')); ?>
            <?php echo form_hidden('id'); ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <h3 id="msg"></h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="rel_type" class="control-label"><?php echo _l('task_related_to'); ?></label>
                            <select name="rel_type" class="selectpicker" id="rel_type" data-width="100%" data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                <option value=""></option>

                                <?php foreach ($legal_services as $service): ?>
                                    <option value="<?php echo $service->is_module == 0 ? $service->slug : 'project'; ?>"
                                        <?php if(isset($task) || $this->input->get('rel_type')){
                                            if($service->is_module == 0){
                                                if($rel_type == $service->slug){
                                                    echo 'selected';
                                                }
                                            }else{
                                                if($rel_type == 'project'){
                                                    echo 'selected';
                                                }
                                            }
                                        } ?>><?php echo $service->name; ?>
                                    </option>
                                <?php endforeach; ?>
                                <?php
                                // hooks()->do_action('task_modal_rel_type_select', ['task' => (isset($task) ? $task : 0), 'rel_type' => $rel_type]);
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group<?php if($rel_id == ''){echo ' hide';} ?>" id="rel_id_wrapper">
                            <label for="rel_id" class="control-label"><span class="rel_id_label"></span></label>
                            <div id="rel_id_select">
                                <select name="rel_id" id="rel_id" class="ajax-sesarch" data-width="100%" data-live-search="true" data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                    <?php if($rel_id != '' && $rel_type != ''){
                                        $rel_data = get_relation_data($rel_type,$rel_id);
                                        $rel_val = get_relation_values($rel_data,$rel_type);
                                        if(!$rel_data){
                                            echo '<option value="'.$rel_id.'" selected>'.$rel_id.'</option>';
                                        }else{
                                            echo '<option value="'.$rel_val['id'].'" selected>'.$rel_val['name'].'</option>';
                                        }
                                    } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal"><?php echo _l("close"); ?></button>
                <button type="submit" class="btn btn-info"><?php echo _l("submit"); ?></button>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>



<script>

    function edit(id){
        $('[id="msg"]').html(msg);


        $.ajax({
            url : "<?php echo site_url('babil_sms_gateway/get/') ?>" + id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                if(data.status)
                {
                    $('#msg').html(data.data.msg)
                    $('input[name="id"]').val(data.data.id)
                    $('#show_msg').modal('show');
                }
                else
                {
                    alert(data.msg)
                }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }


</script>