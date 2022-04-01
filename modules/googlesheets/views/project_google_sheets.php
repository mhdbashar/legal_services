<?php defined('BASEPATH') or exit('No direct script access allowed');?>
<?php $this->load->helper('download');?>
<?php $this->load->model('Sheets_model');?>
<?php $data = get_project();
$files = $this->Sheets_model->get_google_sheets($data->id);
?>
<div class="clearfix"></div>
<h4 class="pull-left"><?php echo _l('google_sheets_and_documents_files'); ?></h4>
    <table class="table dt-table scroll-responsive" data-order-col="0" data-order-type="asc">
        <thead>
        <th><?php echo _l('file_name'); ?></th>
        <th><?php echo _l('options'); ?></th>

        </thead>
        <tbody>

        <?php
foreach ($files as $file) {?>
            <tr>
                <td>
                    <a href="<?php echo site_url($file['file_path']); ?>"><?php echo $file['file_title']; ?></a>
                    <br>

                </td>
                <td>
                <a class="btn btn-danger btn-icon _delete" href="<?php echo site_url("googlesheets/DeleteSpreadsheet_from_project/") . $file['file_id']; ?>"
                   onclick="return confirm('deleted sheet from database?');"><i class="fa fa-remove"></i></a>
                    <a href="#" onclick="edit_sheet(this,<?php $id['id'] = $file['file_id'];?>);return false;"data-name="<?php echo $file['file_title']; ?>"data-id="<?php echo $file['file_id']; ?>"class="btn btn-info btn-icon" ><i class="fa fa-pencil-square-o"></i></a>

                    <a class="btn btn-default btn-icon" href="<?php echo site_url($file['file_path']); ?>"
                   onclick="#"><i class="fa fa-download"></i></a>

                   <a class="btn btn-default btn-icon" href="<?php echo site_url("googlesheets/synchronizaion_file/") . $file['file_id']; ?>"
                                                    onclick="#"><i class="fa fa-refresh"></i></a>


                    <?php }?>
                </td>

            </tr>
        </tbody>
    </table>
</div>
<?php $this->load->view('modal_edit');?>
<script src="<?php echo module_dir_url('googlesheets', 'assets/js/modal.js'); ?>"></script>
