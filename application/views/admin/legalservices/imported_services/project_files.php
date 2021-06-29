
<div class="clearfix"></div>
<div class="mtop25"></div>

<a href="#" onclick="window.location.href = '<?php echo admin_url('legalservices/imported_services/download_all_files/'.$project->id); ?>'; return false;" class="table-btn hide" data-table=".table-iservice-files"><?php echo _l('download_all'); ?></a>
<div class="clearfix"></div>
<table class="table dt-table scroll-responsive table-iservice-files" data-order-type="desc">
    <thead>
    <tr>
        <th data-orderable="false"><span class="hide"> - </span><div class="checkbox mass_select_all_wrap"><input type="checkbox" id="mass_select_all" data-to-table="iservice-files"><label></label></div></th>
        <th><?php echo _l('project_file_filename'); ?></th>
        <th><?php echo _l('project_file__filetype'); ?></th>
        <th><?php echo _l('project_file_dateadded'); ?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($files as $file){
        $path = get_upload_path_by_type('iservice') . $project_id . '/'. $file['file_name'];
        ?>
        <tr>
            <td>
                <div class="checkbox"><input type="checkbox" value="<?php echo $file['id']; ?>"><label></label></div>
            </td>
            <td data-order="<?php echo $file['file_name']; ?>">
                <a href="#" onclick="view_iservice_file(<?php echo $file['id']; ?>,<?php echo $file['iservice_id']; ?>); return false;">
                    <?php if(is_image(ISERVICE_ATTACHMENTS_FOLDER .$project_id.'/'.$file['file_name']) || (!empty($file['external']) && !empty($file['thumbnail_link']))){
                        echo '<div class="text-left"><i class="fa fa-spinner fa-spin mtop30"></i></div>';
                        echo '<img class="project-file-image img-table-loading" src="#" data-orig="'.iservice_file_url($file,true).'" width="100">';
                        echo '</div>';
                    }
                    echo $file['subject']; ?></a>
            </td>
            <td data-order="<?php echo $file['filetype']; ?>"><?php echo $file['filetype']; ?></td>

            <td data-order="<?php echo $file['dateadded']; ?>"><?php echo _dt($file['dateadded']); ?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<div id="project_file_data"></div>
<?php include_once(APPPATH . 'views/admin/clients/modals/send_file_modal.php'); ?>
