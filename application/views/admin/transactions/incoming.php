


<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
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
                            <div class="col-md-6">
                                <?php echo render_input('trans_id', _l('trans_id')); ?>
                            </div>
                            <div class="col-md-6">
                                <?php
                                    $options = array(
                                        0 => array(
                                            'key' => 0,
                                            'value' => _l('low')
                                        ),
                                        1 => array(
                                            'key' => 1,
                                            'value' => _l('high')
                                        ),
                                    ) ;
                                    echo render_select('importance', $options,['key','value'],_l('importance'));
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <?php echo render_input('description', _l('description'),'','',['required' => 'required']); ?>
                            </div>
                            <div class="col-md-6">
                                <?php
                                $options = array(
                                    0 => array(
                                        'key' => 0,
                                        'value' => _l('low')
                                    ),
                                    1 => array(
                                        'key' => 1,
                                        'value' => _l('high')
                                    ),
                                ) ;
                                echo render_select('class', $options,['key','value'],_l('classification'),'',['required' => 'required']);
                                ?>                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <?php
                                $options = array(
                                    0 => array(
                                        'key' => 0,
                                        'value' => _l('internal')
                                    ),
                                    1 => array(
                                        'key' => 1,
                                        'value' => _l('external')
                                    ),
                                ) ;
                                echo render_select('type', $options,['key','value'],_l('type'));
                                ?>

                            </div>
                            <div class="col-md-6">
                                <?php echo render_input('owner_name', _l('owner_name'),'','',['required' => 'required']); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <?php
                                $options = array(
                                    0 => array(
                                        'key' => 0,
                                        'value' => _l('normal_paper')
                                    ),
                                    1 => array(
                                        'key' => 1,
                                        'value' => _l('notnormal_paper')
                                    ),
                                ) ;
                                echo render_select('origin', $options,['key','value'],_l('origin'),'',['required' => 'required']);
                                ?>

                            </div>
                            <div class="col-md-6">
                                <?php echo render_input('owner_phone', _l('owner_phone')); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <?php echo render_input('incoming_num', _l('incoming_num'),'','',['required' => 'required']); ?>
                            </div>
                            <div class="col-md-6">
                                <?php echo render_input('reporter_name', _l('reporter_name'),'','',['required' => 'required']); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <?php
                                $options = array(
                                    0 => array(
                                        'key' => 0,
                                        'value' => _l('normal_paper')
                                    ),
                                    1 => array(
                                        'key' => 1,
                                        'value' => _l('notnormal_paper')
                                    ),
                                ) ;
                                echo render_select('incoming_source', $options,['key','value'],_l('incoming_source'),'',['required' => 'required']);
                                ?>

                            </div>
                            <div class="col-md-6">
                                <?php echo render_input('reporter_phone', _l('reporter_phone')); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <?php
                                $options = array(
                                    0 => array(
                                        'key' => 0,
                                        'value' => _l('electronic_incoming')
                                    ),
                                    1 => array(
                                        'key' => 1,
                                        'value' => _l('paper_incoming')
                                    ),
                                ) ;
                                echo render_select('incoming_type', $options,['key','value'],_l('incoming_type'));
                                ?>

                            </div>
                            <div class="col-md-6">
                                <?php echo render_input('email', _l('email'),'','email'); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="pull-left">
                                    <?php echo render_input('secret', _l('secret'),'','checkbox',[],[],'','pull-left'); ?>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="incoming_date"> <?php echo _l('incoming_date') ?></label>
                                <div id="incoming_date" style="display: inline-flex">
                                    <?php echo render_date_input('hijri_date', _l('hijri_date')); ?>

                                    <?php echo render_date_input('AD_date', _l('AD_date')); ?>

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
