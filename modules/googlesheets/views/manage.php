<?php defined('BASEPATH') or exit('No direct script access allowed');?>
<?php $this->load->model('Sheets_model');?>
<?php init_head();?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                <div class="panel-body">
                    <?php if (isset($login_button)) {?>
                        <div class="_buttons pull-left">

                            <a href="<?php echo $login_button; ?>" onclick="#" class="btn btn-info pull-left mright5 test display-block"><?php echo _l('login_google'); ?></a>
                        </div>

                    <?php }?>
                     <?php if (!isset($login_button)) {?>
                    <div class="_buttons pull-left">

                     <a href="<?php echo site_url("googlesheets/synchronizaion/"); ?>" onclick="return confirm('synchronizaion all files from database?');" class="btn btn-info pull-left mright5 test display-block"><?php echo _l('synchronizaion'); ?></a>

                        <a href="#" onclick="add_new_sheet(); return false;" class="btn btn-info pull-left mright5 test display-block"><?php echo _l('new_sheet'); ?></a>
                        </div>
                        <div class="_buttons pull-right">
                        <a class="btn btn-info pull-left mright5 test display-block" href="<?php echo site_url("googlesheets/logout/"); ?>"
                    onclick="return confirm('LOGOUT?');"><?php echo _l('logout_google'); ?></a>
                        </div>
                    <?php }?>


                    <div class="clearfix"></div>
                        <?php if (!isset($login_button)) {?>
                            <hr class="hr-panel-heading" />

                            <h4 class="pull-left"><?php echo _l('google_sheets_and_documents_files'); ?></h4>

                            <table class="table dt-table scroll-responsive" data-order-col="0" data-order-type="asc">
                            <thead>
                                        <th><?php echo _l('file_name'); ?></th>
                                        <th><?php echo _l('related_to'); ?></th>
                                        <th><?php echo _l('related_name'); ?></th>
                                        <th><?php echo _l('options'); ?></th>

                            </thead>
                            <tbody>
                                <?php foreach ($files as $file) {?>
                                    <tr>
                                        <td>
                                        <?php echo '<a href="Googlesheets/sheetbyid/' . $file->getId() . '">'.$file->getName().'</a>';
                                                echo '<br>'; ?>
                                                            
                                        </td>
                                        <td>
                                            <?php $data_file = $this->Sheets_model->get($file->getId());
                                                if ($data_file > 0) {?>
                                            <?php echo $data_file['rel_type'] ?>
                                            <?php } else {
                                                    echo _l('no_related'); }?>
   
    
                                        </td>

                                        <td>
                                           <?php if ($data_file > 0) {?>
                                            <?php $type = $data_file['rel_type'];
                                                    $id = $data_file['rel_id'];
                                                    $data_relate = get_relation_data($type, $id);
                                                    $rel_values = get_relation_values($data_relate, $type);?>
                                            <a href="<?=$rel_values['link'] . '?group=project_google_sheets'?>" > <?php echo $rel_values['name']; ?></a>
                                            <?php } else {echo '';}?>
                                        </td>
                                        <td>
                                               <?php if ($data_file > 0) {?>
                                                <a class="btn btn-danger btn-icon _delete" href="<?php echo site_url("googlesheets/DeleteSpreadsheet_from_database/") . $file->getId(); ?>"
                                         onclick="return confirm('deleted sheet from database?');"><i class="fa fa-remove"></i></a>
                                         <a href="#" onclick="edit_sheet(this,<?php $data['id'] = $file->getId();?>);return false;"data-name="<?php echo $file->getName(); ?>"data-id="<?php echo $file->getId(); ?>"class="btn btn-info btn-icon" ><i class="fa fa-pencil-square-o"></i></a>
                                         <a class="btn btn-default btn-icon" href="<?php echo site_url("googlesheets/getfiles/") . $file->getId() . '/' . $file->getName(); ?>"
                                                     onclick="#"><i class="fa fa-download"></i></a>
                                        <a class="btn btn-default btn-icon" href="<?php echo site_url("googlesheets/synchronizaion_file/") . $file->getId(); ?>"
                                                    onclick="#"><i class="fa fa-refresh"></i></a>

                                         </td>

                                         <?php }if ($data_file == 0) {?>
        
                                             <a class="btn btn-danger btn-icon _delete" href="<?php echo site_url("googlesheets/DeleteSpreadsheet_from_google/") . $file->getId(); ?>"
                                                onclick="return confirm('deleted sheet from google drive?');"><i class="fa fa-remove"></i></a>
                                             <a class="btn btn-default btn-icon" onclick="save_sheet(this,<?php $data['id'] = $file->getId();?>);return false;"data-name="<?php echo $file->getName(); ?>"data-id="<?php echo $file->getId(); ?>"class="btn btn-info btn-icon"
                                                     ><i class="fa fa-save"></i></a>
                                                     <a class="btn btn-default btn-icon" href="<?php echo site_url("googlesheets/getfiles/") . $file->getId() . '/' . $file->getName(); ?>"
                                                     onclick="#"><i class="fa fa-download"></i></a>

                                                     <?php }?>
                                    </tr>
                                <?php }?>
                            </tbody>
                        </table>
                        <?php }?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<?php $this->load->view('modal');?>
<?php $this->load->view('modal_edit');?>
<?php $this->load->view('modal_save');?>



<?php init_tail();?>

<script src="<?php echo module_dir_url('googlesheets', 'assets/js/modal.js'); ?>"></script>

</body>
</html>

