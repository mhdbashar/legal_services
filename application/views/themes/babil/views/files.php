<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="panel_s section-heading section-files">
    <div class="panel-body">
        <h4 class="no-margin section-text"><?php echo _l('customer_profile_files'); ?></h4>
        <?php hooks()->do_action('after_customers_area_files_heading'); ?>
    </div>
</div>
<div class="panel_s">
   <div class="panel-body">
       <?php echo form_open_multipart(site_url('clients/upload_files'),array('class'=>'dropzone','id'=>'files-upload')); ?>
       <input type="file" name="file" multiple class="hide"/>
       <?php echo form_close(); ?>
       <?php hooks()->do_action('after_customers_area_files_dropzone'); ?>
       <div class="mtop15 mbot15 text-right">
           <?php if (get_option('google_client_id') != '' && get_option('enable_google_picker') == '1') {?>
               <button id="authorize_button" onclick="createGooglePicker()" >
                   <i class="fa fa-google" aria-hidden="true"></i>
                   <?php echo _l('choose_from_google_drive'); ?>
               </button>
           <?php }?>

<!--           <button class="gpicker" data-on-pick="customerFileGoogleDriveSave">-->
<!--            <i class="fa fa-google" aria-hidden="true"></i>-->
<!--            --><?php //echo _l('choose_from_google_drive'); ?>
<!--        </button>-->
        <?php if(get_option('dropbox_app_key') != ''){ ?>
            <div id="dropbox-chooser-files"></div>
        <?php } ?>
    </div>
    <?php if(count($files) == 0){ ?>
        <hr class="hr-panel-heading" />
        <div class="text-center">
            <h4 class="no-margin"><?php echo _l('no_files_found'); ?></h4>
        </div>
    <?php } else { ?>
        <table class="table dt-table mtop15 table-files" data-order-col="1" data-order-type="desc">
           <thead>
            <tr>
                <th class="th-files-file"><?php echo _l('customer_attachments_file'); ?></th>
                <th class="th-files-date-uploaded"><?php echo _l('file_date_uploaded'); ?></th>
                <?php if(get_option('allow_contact_to_delete_files') == 1){ ?>
                    <th class="th-files-option"><?php echo _l('options'); ?></th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach($files as $file){ ?>
                <tr>
                    <td>
                      <?php
                      $url = site_url() .'download/file/client/';
                      $path = get_upload_path_by_type('customer') . $file['rel_id'] . '/' . $file['file_name'];
                      $is_image = false;
                      if(!isset($file['external'])) {
                        $attachment_url = $url . $file['attachment_key'];
                        $is_image = is_image($path);
                        $img_url = site_url('download/preview_image?path='.protected_file_url_by_path($path,true).'&type='.$file['filetype']);
                    } else if(isset($file['external']) && !empty($file['external'])){
                        if(!empty($file['thumbnail_link'])){
                            $is_image = true;
                            $img_url = optimize_dropbox_thumbnail($file['thumbnail_link']);
                        }
                        $attachment_url = $file['external_link'];
                    }
                    if($is_image){
                        echo '<div class="preview_image">';
                    }
                    ?>
                    <a href="<?php echo $attachment_url; ?>"<?php echo (isset($file['external']) && !empty($file['external']) ? ' target="_blank"' : ''); ?>
                    class="display-block mbot5">
                    <?php if($is_image){ ?>
                        <div class="table-image">
                          <div class="text-center"><i class="fa fa-spinner fa-spin mtop30"></i></div>
                          <img src="#" class="img-table-loading" data-orig="<?php echo $img_url; ?>">
                      </div>
                  <?php } else { ?>
                    <i class="<?php echo get_mime_class($file['filetype']); ?>"></i> <?php echo $file['file_name']; ?>
                <?php } ?>
            </a>
            <?php if($is_image){ echo '</div>'; } ?>
        </td>
        <td data-order="<?php echo $file['dateadded']; ?>"><?php echo _dt($file['dateadded']); ?></td>
        <?php if(get_option('allow_contact_to_delete_files') == 1) { ?>
            <td>
                <?php if($file['contact_id'] == get_contact_user_id()){ ?>
                    <a href="<?php echo site_url('clients/delete_file/'.$file['id'].'/general'); ?>"
                        class="btn btn-danger btn-icon _delete file-delete"><i class="fa fa-remove"></i></a>
                    <?php } ?>
                </td>
            <?php } ?>
        </tr>
    <?php } ?>
</tbody>
</table>
<?php } ?>
<?php hooks()->do_action('after_customers_area_files'); ?>
</div>
</div>
<?php if (get_option('google_client_id') != '' && get_option('enable_google_picker') == '1') {?>
    <script>
        let tokenClient;
        let accessToken = null;

        function gisLoaded() {
            const SCOPES = 'https://www.googleapis.com/auth/drive.metadata.readonly';
            const CLIENT_ID = '<?=get_option("google_client_id")?>';
            tokenClient = google.accounts.oauth2.initTokenClient({
                client_id: CLIENT_ID,
                scope: SCOPES,
            });
        }
        function createGooglePicker() {
            tokenClient.callback = async (response) => {
                if (response.error !== undefined) {
                    throw (response);
                }
                accessToken = response.access_token;
                await createPicker();
            };

            if (accessToken === null) {
                // Prompt the user to select a Google Account and ask for consent to share their data
                // when establishing a new session.
                tokenClient.requestAccessToken({prompt: 'consent'});
            } else {
                // Skip display of account chooser and consent dialog for an existing session.
                tokenClient.requestAccessToken({prompt: ''});
            }
        }
        function createPicker() {
            const view = new google.picker.View(google.picker.ViewId.DOCS);
            const APP_ID = '';
            const API_KEY = app.options.google_api;
            // view.setMimeTypes('image/png,image/jpeg,image/jpg');
            const picker = new google.picker.PickerBuilder()
                .enableFeature(google.picker.Feature.NAV_HIDDEN)
                .enableFeature(google.picker.Feature.MULTISELECT_ENABLED)
                .setDeveloperKey(API_KEY)
                .setAppId(APP_ID)
                .setOAuthToken(accessToken)
                .addView(view)
                .addView(new google.picker.DocsUploadView())
                .setCallback(pickerCallback)
                .build();
            picker.setVisible(true);
        }

        async function pickerCallback(data) {
            if (data.action === google.picker.Action.PICKED) {
                const doc = data[google.picker.Response.DOCUMENTS][0];
                var retVal = [];
                retVal.push({
                    name: doc[google.picker.Document.NAME],
                    link: doc[google.picker.Document.URL],
                    mime: doc[google.picker.Document.MIME_TYPE],
                    thumbnailLink: doc[google.picker.Document.thumbnailLink],
                });
                customerFileGoogleDriveSave(retVal);

            }
        }

        function gapiLoaded() {
            gapi.load('client:picker', initializePicker);
        }

        async function initializePicker() {
            await gapi.client.load('https://www.googleapis.com/discovery/v1/apis/drive/v3/rest');
        }

    </script>
    <script async defer src="https://apis.google.com/js/api.js" onload="gapiLoaded()"></script>
    <script async defer src="https://accounts.google.com/gsi/client" onload="gisLoaded()"></script>
<?php }?>
