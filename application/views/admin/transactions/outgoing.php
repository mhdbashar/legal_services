


<?php defined('BASEPATH') or exit('No direct script access allowed');

//var_dump($outgoing);exit();
if(empty($id)){
    $id = '';
    $description = '';
    $type = '';
    $origin = '';
    $is_secret = '';
    $importance = '';
    $classification = '';
    $owner = '';
    $owner_phone = '';
}else{
    $id = $outgoing->id;
    $description = $outgoing->description;
    $type = $outgoing->type;
    $origin = $outgoing->origin;
    $is_secret = $outgoing->is_secret;
    $importance = $outgoing->importance;
    $classification = $outgoing->classification;
    $owner = $outgoing->owner;
    $owner_phone = $outgoing->owner_phone;
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
                            <?php echo  _l('incoming_data'); ?>
                        </h4>
                        <hr class="hr-panel-heading" />
                        <?php echo form_open_multipart($this->uri->uri_string(),array('id'=>'incoming-form','class'=>'')) ;?>
                        <div class="row">
                            <div class="col-md-12">
                                <?php echo render_input('trans_type', '',1,'hidden'); ?>

                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <?php echo render_input('trans_id', _l('trans_id'),$id); ?>
                            </div>
                            <div class="col-md-6">
                                <?php
                                $options = array(
                                    0 => array(
                                        'key' => 1,
                                        'value' => _l('low')
                                    ),
                                    1 => array(
                                        'key' => 2,
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
                                        'key' => 1,
                                        'value' => _l('low')
                                    ),
                                    1 => array(
                                        'key' => 2,
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
                                        'key' => 1,
                                        'value' => _l('internal')
                                    ),
                                    1 => array(
                                        'key' => 2,
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
                                        'key' => 1,
                                        'value' => _l('normal_paper')
                                    ),
                                    1 => array(
                                        'key' => 2,
                                        'value' => _l('notnormal_paper')
                                    ),
                                ) ;
                                echo render_select('origin', $options,['key','value'],_l('origin'),$origin,['required' => 'required']);
                                ?>

                            </div>
                            <div class="col-md-6">
                                <?php echo render_input('owner_phone', _l('owner_phone'),$owner_phone); ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="pull-left">

                                    <?php $checked = $is_secret == 1 ?'checked':''; ?>
                                    <div class="form-group" app-field-wrapper="secret">
                                        <label for="secret" class="control-label"><?php echo _l('secret');?></label>
                                        <input type="checkbox" id="secret" name="secret" class="form-control" style="width:20px;height:20px;" value="" <?php echo $checked;?>>
                                    </div>

                                </div>
                            </div>

                        </div>

                        <button type="submit" class="btn btn-info pull-left"><?php echo _l('submit'); ?></button>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
<script>
    $(function(){
        _validate_form($('form'),{transaction:'required'});
    });

</script>
<script>

</script>
</body>
</html>
