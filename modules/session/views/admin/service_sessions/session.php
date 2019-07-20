<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">

                <div class="col-md-12">
                    <div class="table-responsive p-5 bg-white border" style="padding: 10px">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <div class="pull-right">
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#basic" data-title="New Holiday" data-readonly="">
                                        Edit Staff Account
                                    </button>
                                </div>
                            </div><hr>
                        </div>
                        <div class="row">
                            <div class="col-md-12" style="font-size: 17px">
                                    <div class="col-md-4">
                                        <?php echo 'Service Id' ?> : <?php echo $session->service_id ?>
                                    </div>

                                    <div class="col-md-4">
                                        <?php echo 'Type' ?> : <?php echo $session->rel_type ?>
                                    </div>
                                    <div class="col-md-4">
                                        <?php echo 'Subject' ?> : <?php echo $session->subject ?>
                                    </div>

                                    <div class="col-md-4">
                                        <?php echo 'Court' ?> : <?php echo ($court_name->court_name) ?>
                                    </div>

                                    <div class="col-md-4">
                                        <?php echo 'Judge' ?> : <?php echo $judge_name->name ?>
                                    </div>

                                    <div class="col-md-4">
                                        <?php echo 'Date' ?> : <?php echo $session->date ?>
                                    </div>

                                <?php if ($session->details){ ?>
                                    <div class="col-md-4">
                                        <?php echo 'Details' ?> : <?php echo $session->details ?>
                                    </div>
                                <?php } ?>
                                <?php if ($session->next_action){ ?>
                                    <div class="col-md-4">
                                        <?php echo 'Next Action' ?> : <?php echo $session->details ?>
                                    </div>
                                <?php } ?>
                                <?php if ($session->next_date){ ?>
                                    <div class="col-md-4">
                                        <?php echo 'Next Date' ?> : <?php echo $session->details ?>
                                    </div>
                                <?php } ?>
                                <?php if ($session->report){ ?>
                                    <div class="col-md-4">
                                        <?php echo 'Report' ?> : <?php echo $session->details ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            
                    
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
</body>
</html>