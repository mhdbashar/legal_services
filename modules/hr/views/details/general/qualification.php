 <?php $this->load->view('details/modals/qualification_modal') ?>
 <div class="_buttons">
    <a href="#" class="btn btn-info pull-left" data-toggle="modal" data-target="#add_qualification"><?php echo _l('new_qualification'); ?></a>
</div>
<div class="clearfix"></div>
<hr class="hr-panel-heading" />
<div class="clearfix"></div>
<?php render_datatable(array(
/*`id` int(11) PRIMARY KEY AUTO_INCREMENT,
    `school_university` varchar(255) NOT NULL, 
    `education_level` varchar(255) NOT NULL, 
    `from_date` date NOT NULL,
    `to_date` date NOT NULL,
    `skill` varchar(255) NOT NULL, 
    `education` varchar(255) NOT NULL, 
    `description` text NOT NULL,
    `staff_id` int(11) NOT NULL*/
    _l('school_university'),
    _l('from_date'),
    _l('to_date'),
    _l('education_level'),
    _l('control'),
    ),'qualification'); ?>
