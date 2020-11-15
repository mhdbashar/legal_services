


<?php defined('BASEPATH') or exit('No direct script access allowed');
//var_dump($incoming);exit();
    if(empty($id)){
        $id = '';
        $description = '';
        $type = '';
        $origin = '';
        $incoming_num = '';
        $incoming_source = '';
        $incoming_type = '';
        $is_secret = '';
        $importance = '';
        $classification = '';
        $owner = '';
        $owner_phone = '';
        $source_reporter = '';
        $source_reporter_phone = '';
        $email = '';
        $date = '';
    }else{

        $id = $incoming->id;
        $description = $incoming->description;
        $type = $incoming->type;
        $origin = $incoming->origin;
        $incoming_num = $incoming->incoming_num;
        $incoming_source = $incoming->incoming_source;
        $incoming_type = $incoming->incoming_type;
        $is_secret = $incoming->is_secret;
        $importance = $incoming->importance;
        $classification = $incoming->classification;
        $owner = $incoming->owner;
        $owner_phone = $incoming->owner_phone;
        $source_reporter = $incoming->source_reporter;
        $source_reporter_phone = $incoming->source_reporter_phone;
        $email = $incoming->email;
        $date = $incoming->date;

    //    var_dump($is_secret);exit();
    }
?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel_s">
                    <div class="panel-body">
                        <h4 class="no-margin">
                            <?php echo  $title; ?>
                        </h4>
                        <hr class="hr-panel-heading" />
                        <?php echo form_open_multipart($this->uri->uri_string(),array('id'=>'expense-form','class'=>'dropzone dropzone-manual')) ;?>
                        <div class="row">
                            <div class="col-md-12">
                                <?php echo render_input('trans_type', '',0,'hidden'); ?>

                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <?php echo render_input('trans_id', _l('trans_id'),$id,'',['disabled'=>'disabled']); ?>
                            </div>
                            <div class="col-md-6">
                                <?php
                                    $options = array(
                                        0 => array(
                                            'key' => _l('low'),
                                            'value' => _l('low')
                                        ),
                                        1 => array(
                                            'key' => _l('high'),
                                            'value' => _l('high')
                                        ),
                                    ) ;
                                    echo render_select('importance', $options,['key','value'],_l('importance'),$importance);
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <?php echo render_input('description', _l('description'),$description,'',['required' => 'required']); ?>
                            </div>
                            <div class="col-md-6">
                                <?php
                                $options = array(
                                    0 => array(
                                        'key' =>  _l('low'),
                                        'value' => _l('low')
                                    ),
                                    1 => array(
                                        'key' => _l('high'),
                                        'value' => _l('high')
                                    ),
                                ) ;
                                echo render_select('class', $options,['key','value'],_l('classification'),$classification,['required' => 'required']);
                                ?>                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <?php
                                $options = array(
                                    0 => array(
                                        'key' => _l('internal'),
                                        'value' => _l('internal')
                                    ),
                                    1 => array(
                                        'key' => _l('external'),
                                        'value' => _l('external')
                                    ),
                                ) ;
                                echo render_select('type', $options,['key','value'],_l('type'),$type);
                                ?>

                            </div>
                            <div class="col-md-6">
                                <?php echo render_input('owner_name', _l('owner_name'),$owner,'',['required' => 'required']); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <?php
                                $options = array(
                                    0 => array(
                                        'key' => _l('normal_paper'),
                                        'value' => _l('normal_paper')
                                    ),
                                    1 => array(
                                        'key' => _l('notnormal_paper'),
                                        'value' => _l('notnormal_paper')
                                    ),
                                ) ;
                                echo render_select('origin', $options,['key','value'],_l('origin'),$origin,['required' => 'required']);
                                ?>

                            </div>
                            <div class="col-md-6">
                                <?php echo render_input('owner_phone', _l('owner_phone'),$owner_phone,'number'); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <?php echo render_input('incoming_num', _l('incoming_num'),$incoming_num,'',['required' => 'required']); ?>
                            </div>
                            <div class="col-md-6">
                                <?php echo render_input('reporter_name', _l('reporter_name'),$source_reporter,'',['required' => 'required']); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <?php
//                                $options = array(
//                                    0 => array(
//                                        'key' => 1,
//                                        'value' => _l('normal_paper')
//                                    ),
//                                    1 => array(
//                                        'key' => 2,
//                                        'value' => _l('notnormal_paper')
//                                    ),
//                                ) ;
                                //                                echo render_select('incoming_source', $options,['key','value'],_l('incoming_source'),$incoming_source,['required' => 'required']);

                                if(option_exists('incoming_side_En')){
                                    $data =array();
                                    $ad_opts = json_decode(get_option('incoming_side_En')) ;

                                    foreach ($ad_opts as $option){
                                        $sids = json_decode(json_encode($option),true);
                                        array_push($data,$sids);
                                    }
                                }else{
                                    $data =array();
                                }
                                echo  render_select_with_input_group('incoming_source',$data,array('key','value'),_l('incoming_source'),$incoming_source,'<a href="#" onclick="new_incoming_side();return false;"><i class="fa fa-plus"></i></a>',[],[],'','show-menu-arrow')
                                ?>

                            </div>
                            <div class="col-md-6">
                                <?php echo render_input('reporter_phone', _l('reporter_phone'),$source_reporter_phone,'number'); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <?php
                                $options = array(
                                    0 => array(
                                        'key' => _l('electronic_incoming'),
                                        'value' => _l('electronic_incoming')
                                    ),
                                    1 => array(
                                        'key' => _l('paper_incoming'),
                                        'value' => _l('paper_incoming')
                                    ),
                                ) ;
                                echo render_select('incoming_type', $options,['key','value'],_l('incoming_type'),$incoming_type);
                                ?>

                            </div>
                            <div class="col-md-6">
                                <?php echo render_input('email', _l('email'),$email,'email'); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="pull-left">

                                    <?php
                                    $checked = $is_secret == 1 ? 'checked' : '';
                                    // echo render_input('secret', _l('secret'),'','checkbox',['style' =>'width:20px;height:20px;', '' => 'checked']); ?>
                                    <?php $checked = $is_secret == 1 ?'checked':''; ?>
                                    <div class="form-group" app-field-wrapper="secret">
                                        <label for="secret" class="control-label"><?php echo _l('secret');?></label>
                                        <input type="checkbox" id="secret" name="secret" class="form-control"  style="width:20px;height:20px;" value="" <?php echo $checked;?>>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div id="incoming_date" style="display: inline-flex">
                                    <?php echo render_date_input('date', _l('incoming_date'),$date); ?>

                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <!--                            --><?php //echo form_open_multipart(admin_url('projects/upload_file'),array('class'=>'dropzone','id'=>'project-files-upload')); ?>
                            <!--                            <input type="file" name="file" multiple />-->
                            <!--                            --><?php //echo form_close(); ?>
                            <div class="clearfix"></div>
                            <label class="col-form-label">
                                <?php echo _l('incoming_transaction_file') ?>
                            </label>
                            <?php if(isset($incoming) && $incoming->attachment !== ''){ ?>
                                <div class="row">
                                    <div class="col-md-10">
                                        <i class="<?php echo get_mime_class($incoming->filetype); ?>"></i> <a href="<?php echo site_url('download/file/transaction/'.$incoming->id); ?>"><?php echo $incoming->attachment; ?></a>
                                    </div>
                                    <div class="col-md-2 text-right">
                                        <a href="<?php $type = 0; // trans type 0 if incoming or 1 if outgoing
                                        echo admin_url('transactions/delete_transaction_attachment/'.$incoming->id.'/'.$type); ?>" class="text-danger _delete"><i class="fa fa fa-times"></i></a>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if(!isset($incoming) || (isset($incoming) && $incoming->attachment == '')){ ?>
                                <div id="dropzoneDragArea" class="dz-default dz-message">
                                    <span><?php echo _l('expense_add_edit_attach_receipt'); ?></span>
                                </div>
                                <div class="dropzone-previews"></div>
                            <?php } ?>
                        </div>
                        <hr class="hr-panel-heading" />

                        <button type="submit" class="btn btn-info pull-left"><?php echo _l('submit'); ?></button>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('admin/transactions/incoming_side_modal'); ?>
<?php init_tail(); ?>
<script>
    $(function(){
        _validate_form($('form'),{transaction:'required'});
    });



</script>
<script>
    Dropzone.options.expenseForm = false;
    var expenseDropzone;

    $(function(){
        $

        if($('#dropzoneDragArea').length > 0){
            expenseDropzone = new Dropzone("#expense-form", appCreateDropzoneOptions({
                autoProcessQueue: false,
                clickable: '#dropzoneDragArea',
                previewsContainer: '.dropzone-previews',
                addRemoveLinks: true,
                maxFiles: 1,
                success:function(file,response){
                    response = JSON.parse(response);
                    if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
                        window.location.assign(response.url);
                    }
                },
            }));
        }

        appValidateForm($('#expense-form'),{},expenseSubmitHandler);


        function expenseSubmitHandler(form){


            $.post(form.action, $(form).serialize()).done(function(response) {
                var response = admin_url + "transactions/incoming_list";
                if(typeof(expenseDropzone) !== 'undefined'){
                    <?php if(empty($id)) $id = $last_id ?>;
                    if (expenseDropzone.getQueuedFiles().length > 0) {
                        expenseDropzone.options.url = admin_url + 'transactions/add_transaction_attachment/' + <?php echo $id ?>;
                        expenseDropzone.processQueue();
                    }else {
                        window.location.assign(response);
                    }
                } else {
                    window.location.assign(response);
                }
            });
            return false;
        }
    })
</script>
</body>
</html>
