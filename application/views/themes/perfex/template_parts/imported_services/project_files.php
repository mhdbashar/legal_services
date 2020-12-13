<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php //if($project->settings->upload_files == 1){ ?>
<!--    --><?php //echo form_open_multipart(site_url('clients/legal_services/'.$project->id. '/' .$ServID),array('class'=>'dropzone mbot15','id'=>'project-files-upload')); ?>
<!--    <input type="file" name="file" multiple class="hide"/>-->
<!--    --><?php //echo form_close(); ?>
<!--    <div class="pull-left mbot20">-->
<!--        <a href="--><?php //echo site_url('clients/download_all_project_files/'.$project->id); ?><!--" class="btn btn-info">-->
<!--            --><?php //echo _l('download_all'); ?>
<!--        </a>-->
<!--    </div>-->
<!--    <div class="pull-right mbot20">-->
<!--        <button class="gpicker" data-on-pick="projectFileGoogleDriveSave">-->
<!--            <i class="fa fa-google" aria-hidden="true"></i>-->
<!--            --><?php //echo _l('choose_from_google_drive'); ?>
<!--        </button>-->
<!--        <div id="dropbox-chooser-project-files"></div>-->
<!--    </div>-->
<?php //} ?>
<table class="table dt-table" data-order-col="4" data-order-type="desc">
    <thead>
    <tr>
        <th>#</th>
        <th><?php echo _l('project_file_filename'); ?></th>
        <th><?php echo _l('project_file__filetype'); ?></th>
        <th><?php echo _l('project_file_dateadded'); ?></th>
        <th><?php echo _l('control'); ?></th>
    </tr>
    </thead>
    <tbody>
    <?php
    $url_text = 'imported_services';

    foreach($files as $file){
        // $file['file_name'] = str_replace(' ', '%20', $file['file_name']);
        $path = get_upload_path_by_type('iservice') . $project->id . '/'. $file['file_name'];
        ?>
        <tr>
            <td>
                <div class="checkbox"><input type="checkbox" value="<?php echo $file['id']; ?>"><label></label></div>
            </td>
            <td data-order="<?php echo $file['file_name']; ?>">
                <a href="#" onclick="c_view_iservice_file(<?php echo $file['id']; ?>,<?php echo $file['iservice_id']; ?>); return false;">
                    <?php if(is_image(ISERVICE_ATTACHMENTS_FOLDER .$project->id.'/'.$file['file_name']) || (!empty($file['external']) && !empty($file['thumbnail_link']))){
                        //echo '<div class="text-left"><i class="fa fa-spinner fa-spin mtop30"></i></div>';
                        echo '<img class="project-file-image img-table-loading" src="'.base_url('uploads/' . $url_text . '/' . $file['iservice_id'] . '/' . $file['file_name']) .'" data-orig="'.iservice_file_url($file,true).'" width="100">';
                        echo '</div>';
                    }
                    echo $file['subject']; ?></a>
            </td>
            <td data-order="<?php echo $file['filetype']; ?>"><?php echo $file['filetype']; ?></td>

            <td data-order="<?php echo $file['dateadded']; ?>"><?php echo _dt($file['dateadded']); ?></td>
            <td><?php echo client_icon_btn('clients/remove_file/' . $project->id . '/' . $file['id'], 'remove', 'btn-danger _delete') ?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<div id="project_file_data"></div>
