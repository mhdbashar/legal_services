<?php defined('BASEPATH') or exit('No direct script access allowed');
$__google_sheets_ClientId = get_option('google_sheets_client_id');
$_google_sheets_ClientSecret = get_option('google_sheets_client_secret');
$__google_sheets_ProjectId = get_option('google_sheets_project_id');
$_google_sheetsAppRedirectUri = site_url('/admin/googlesheets/login');

if (is_admin()) : ?>
     <h4 class="pull-left"><?php echo _l('google_sheets_and_documents_settings'); ?></h4>
     <hr>
     <div class="form-group">
          <label for="google_sheets_client_id"><?= _l('google_sheets_client_id_label'); ?></label>
          <input type="text" class="form-control" value="<?= $__google_sheets_ClientId; ?>" id="google_sheets_client_id" name="settings[google_sheets_client_id]">
     </div>
     <div class="form-group">
          <label for="google_sheets_client_secret"><?= _l('google_sheets_client_secret_label'); ?></label>
          <input type="text" class="form-control" value="<?= $_google_sheets_ClientSecret; ?>" id="google_sheets_client_secret" name="settings[google_sheets_client_secret]">
     </div>
<!--    <div class="form-group">-->
<!--        <label for="google_sheets_project_id">--><?//= _l('google_sheets_project_id_label'); ?><!--</label>-->
<!--        <input type="text" class="form-control" value="--><?//= $__google_sheets_ProjectId; ?><!--" id="google_sheets_project_id" name="settings[google_sheets_project_id]">-->
<!--    </div>-->
     <div class="form-group">
          <div class="alert alert-info alert-dismissible mtop15" role="alert">
               <?= _l('google_sheets_app_redirect_uri_label'); ?>: <strong> <?= $_google_sheetsAppRedirectUri; ?></strong>
               <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
               </button>
          </div>
     </div>
<?php endif; ?>