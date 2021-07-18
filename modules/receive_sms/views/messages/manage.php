<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12" id="small-table">
                <div class="panel_s">
                    <div class="panel-body">
                        <h3><?php echo _l('messages') ?></h3>
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
                                            <button onclick="show('<?php echo $message->msg ?>')" type="button" data-toggle="modal" class="btn btn-default btn-icon"><i class="fa fa-eye"></i></button>
                                            <a href="<?php echo admin_url('LegalServices/Cases_controller/remove_file/'); ?>" class="btn btn-danger btn-icon _delete"><i class="fa fa-remove"></i></a>
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