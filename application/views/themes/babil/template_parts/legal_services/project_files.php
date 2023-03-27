<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php if ($project->settings->upload_files == 1) { ?>
  <?php echo form_open_multipart(site_url('clients/legal_services/' . $project->id . '/' . $ServID), array('class' => 'dropzone mbot15', 'id' => 'project-files-upload')); ?>
  <input type="file" name="file" multiple class="hide" />
  <?php echo form_close(); ?>
  <div class="pull-left mbot20">
    <?php $path = $ServID == 1 ? 'case' : 'oservice' ?>
    <a href="<?php echo site_url('clients/download_all_' . $path . '_files/' . $project->id); ?>" class="btn btn-info">
      <?php echo _l('download_all'); ?>
    </a>
  </div>
  <div class="pull-right mbot20">
      <?php if (get_option('google_client_id') != '' && get_option('enable_google_picker') == '1') {?>
          <button id="authorize_button" onclick="createGooglePicker()" >
              <i class="fa fa-google" aria-hidden="true"></i>
              <?php echo _l('choose_from_google_drive'); ?>
          </button>
      <?php }?>

<!--      <button class="gpicker" data-on-pick="projectFileGoogleDriveSave">-->
<!--      <i class="fa fa-google" aria-hidden="true"></i>-->
<!--      --><?php //echo _l('choose_from_google_drive'); ?>
<!--    </button>-->
    <div id="dropbox-chooser-project-files"></div>
  </div>
<?php } ?>
<table class="table dt-table" data-order-col="4" data-order-type="desc">
  <thead>
    <tr>
      <th><?php echo _l('project_file_filename'); ?></th>
      <th><?php echo _l('project_file__filetype'); ?></th>
      <th><?php echo _l('project_discussion_last_activity'); ?></th>
      <th><?php echo _l('project_discussion_total_comments'); ?></th>
      <th><?php echo _l('project_file_dateadded'); ?></th>
      <?php if (get_option('allow_contact_to_delete_files') == 1) { ?>
        <th><?php echo _l('options'); ?></th>
      <?php } ?>
    </tr>
  </thead>
  <tbody>
    <?php
    if ($ServID == 1) {
      $attach_path = CASE_ATTACHMENTS_FOLDER;
      $path_by_type = 'case';
      $java_func_file = 'view_case_file';
      $helper_file = 'case_file_url';
      $table = 'casediscussioncomments';
      $file_id = 'project_id';
    } else {
      $attach_path = OSERVICE_ATTACHMENTS_FOLDER;
      $path_by_type = 'oservice';
      $java_func_file = 'view_oservice_file';
      $helper_file = 'oservice_file_url';
      $table = 'oservicediscussioncomments';
      $file_id = 'oservice_id';
    }
    ?>
    <?php foreach ($files as $file) {
      $path = get_upload_path_by_type($path_by_type) . $project->id . '/' . $file['file_name'];
    ?>
      <tr>
        <td data-order="<?php echo $file['file_name']; ?>">
          <a href="#" onclick="<?php echo $java_func_file; ?>(<?php echo $file['id']; ?>,<?php echo $file[$file_id]; ?>,<?php echo $ServID; ?>); return false;">
            <?php if (is_image($attach_path . $project->id . '/' . $file['file_name']) || (!empty($file['external']) && !empty($file['thumbnail_link']))) {
              echo '<div class="text-left"><i class="fa fa-spinner fa-spin mtop30"></i></div>';
              echo '<img class="project-file-image img-table-loading" src="#" data-orig="' . $helper_file($file, true) . '" width="100">';
              echo '</div>';
            }
            echo $file['subject']; ?></a>
        </td>
        <td data-order="<?php echo $file['filetype']; ?>"><?php echo $file['filetype']; ?></td>
        <td data-order="<?php echo $file['last_activity']; ?>">
          <?php
          if (!is_null($file['last_activity'])) {
            echo time_ago($file['last_activity']);
          } else {
            echo _l('project_discussion_no_activity');
          }
          ?>
        </td>
        <?php $total_file_comments = total_rows(db_prefix() . $table, array('discussion_id' => $file['id'], 'discussion_type' => 'file')); ?>
        <td data-order="<?php echo $total_file_comments; ?>">
          <?php echo $total_file_comments; ?>
        </td>
        <td data-order="<?php echo $file['dateadded']; ?>">
          <?php echo _dt($file['dateadded']); ?>
        </td>
        <?php if (get_option('allow_contact_to_delete_files') == 1) { ?>
          <td>
            <?php if ($file['contact_id'] == get_contact_user_id()) { ?>
              <a href="<?php echo site_url('clients/delete_file/' . $file['id'] . '/legal_services/' . $ServID); ?>" class="btn btn-danger btn-icon _delete"><i class="fa fa-remove"></i></a>
            <?php } ?>
          </td>
        <?php } ?>
      </tr>
    <?php } ?>
  </tbody>
</table>
<div id="project_file_data"></div>
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
                projectFileGoogleDriveSave(retVal);

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
