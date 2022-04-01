<?php defined('BASEPATH') or exit('No direct script access allowed');?>
<?php init_head();?>
<div id="wrapper">
    <div class="content">
        <div class="row">
        <div class="col-md-12">
                <div class="panel_s">
                <div class="panel-body">
                <h4 class="pull-left"><?php echo _l('google_sheets_and_documents_files'); ?></h4>
                <?php if (!isset($login_button)) {?>
                    <div class="_buttons pull-right">
                    <a class="btn btn-info pull-left mright5 test display-block" href="<?php echo site_url("googlesheets/logout/"); ?>"
                        onclick="return confirm('LOGOUT?');"><?php echo _l('logout_google'); ?></a>
                        </div>
                        <?php }?>
                        <?php if (isset($login_button)) {?>
                        <div class="_buttons pull-right">

                        <a href="<?php echo $login_button; ?>" onclick="#" class="btn btn-info pull-right mright5 test display-block">login to your google account</a>
                        </div>
                        <?php }?>
                </div>
                <iframe dir='rtl' src="https://docs.google.com/<?=$type?>/d/<?=$id?>" style="height: 100vh; width: 100%;"></iframe>
                    </div>

            </div>
        </div>
    </div>

</div>

<?php init_tail();?>
</body>
</html>
