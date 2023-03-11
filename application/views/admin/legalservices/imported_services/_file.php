<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal fade _project_file" tabindex="-1" role="dialog" data-toggle="modal">
    <div class="modal-dialog full-screen-modal" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick="close_modal_manually('._project_file'); return false;"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php echo $file->subject; ?></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 border-right project_file_area">
                        
                        <?php
                        $path = ISERVICE_ATTACHMENTS_FOLDER .$file->iservice_id.'/'.$file->file_name;
                        if(is_image($path)){ ?>
                            <img src="<?php echo base_url('uploads/imported_services/'.$file->iservice_id.'/'.$file->file_name); ?>" class="img img-responsive">
                        <?php } else if(!empty($file->external) && !empty($file->thumbnail_link) && $file->external == 'dropbox'){ ?>
                            <img src="<?php echo optimize_dropbox_thumbnail($file->thumbnail_link); ?>" class="img img-responsive">
                        <?php } else if(strpos($file->filetype,'pdf') !== false && empty($file->external)){ ?>
                            <iframe src="<?php echo base_url('uploads/imported_services/'.$file->iservice_id.'/'.$file->file_name); ?>" height="100%" width="100%" frameborder="0"></iframe>
                        <?php } else if(is_html5_video($path)) { ?>
                            <video width="100%" height="100%" src="<?php echo site_url('download/preview_video?path='.protected_file_url_by_path($path).'&type='.$file->filetype); ?>" controls>
                                Your browser does not support the video tag.
                            </video>
                        <?php } else if(is_markdown_file($path) && $previewMarkdown = markdown_parse_preview($path)) {
                            echo $previewMarkdown;
                        } else {
                            if(empty($file->external)) {
                                echo '<a href="'.site_url('uploads/imported_services/'.$file->iservice_id.'/'.$file->file_name).'" download>'.$file->file_name.'</a>';
                            } else {
                                echo '<a href="'.$file->external_link.'" target="_blank">'.$file->file_name.'</a>';
                            }
                            echo '<p class="text-muted">'._l('no_preview_available_for_file').'</p>';
                        } ?>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="close_modal_manually('._project_file'); return false;"><?php echo _l('close'); ?></button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<?php $discussion_lang = get_iservice_discussions_language_array(); ?>
<script>
    var discussion_id = '<?php echo $file->id; ?>';
    var discussion_user_profile_image_url = '<?php echo $discussion_user_profile_image_url; ?>';
    var current_user_is_admin = '<?php echo is_admin(); ?>';
    $('body').on('shown.bs.modal', '._project_file', function() {
        var content_height = ($('body').find('._project_file .modal-content').height() - 165);
        let projectFilePreviewIframe = $('.project_file_area iframe');
     if(projectFilePreviewIframe.length > 0){
       projectFilePreviewIframe.css('height', content_height);
        }
        if(!is_mobile()){
            $('.project_file_area,.project_file_discusssions_area').css('height',content_height);
        }
    });
    $('body').find('._project_file').modal({show:true, backdrop:'static', keyboard:false});
</script>
