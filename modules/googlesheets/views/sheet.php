<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
        <div class="col-md-12">
                <div class="panel_s">
                <div class="panel-body">
                <h4 class="pull-left"><?php echo _l('My Google Sheets and Excel Files'); ?></h4>
                <?php  if(!isset($login_button)){?>

                <!-- <div class="_buttons pull-left"> -->
                    

                        <!-- <a href="<?php echo site_url("googlesheets/synchronizaion/"); ?>" onclick="#" class="btn btn-info pull-left mright5 test display-block"><?php echo _l('synchronizaion'); ?></a>

                        <a href="#" onclick="add_new_sheet(); return false;" class="btn btn-info pull-left mright5 test display-block"><?php echo _l('new sheet'); ?></a> -->
                <!-- </div> -->
                    <div class="_buttons pull-right">
                    <a class="btn btn-info pull-left mright5 test display-block" href="<?php echo site_url("googlesheets/logout/");?>"
                        onclick="return confirm('LOGOUT?');">LOGOUT</a>
                        </div>
                        <?php } ?>
                        <?php  if(isset($login_button)){?>
                        <div class="_buttons pull-right">

                        <a href="<?php echo $login_button ; ?>" onclick="#" class="btn btn-info pull-right mright5 test display-block">login to your google account</a>
                        </div>
                        <?php } ?>
                   
                    <!-- <div class="clearfix"></div> -->
                        <!-- <hr class="hr-panel-heading" /> -->

                    
                </div>
                <iframe dir='rtl' src="https://docs.google.com/spreadsheets/d/<?=$id?>" style="height: 100vh; width: 100%;"></iframe>
                    </div>

            </div>
        </div>
    </div>

</div>

<?php init_tail(); ?>
</body>
</html>
