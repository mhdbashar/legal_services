<?php hooks()->do_action('before_termination_email_templates');
$this->load->model('emails_model');
$lang = get_staff_default_language();

$this->db->where([
    'type'     => 'hr',
    'language' => $lang,
]);
$this->db->or_where('type', 'hr_warnings');

$hr_templates = $this->db->get(db_prefix() . 'emailtemplates')->result_array();

$hasPermissionEdit = has_permission('email_templates', '', 'edit');

?>
<div class="col-md-12">
    <h4 class="bold well email-template-heading">
        <?php echo _l('hr'); ?>
        <?php if($hasPermissionEdit){ ?>
            <a href="<?php echo admin_url('emails/disable_by_type/termination'); ?>" class="pull-right mleft5 mright25"><small><?php echo _l('disable_all'); ?></small></a>
            <a href="<?php echo admin_url('emails/enable_by_type/termination'); ?>" class="pull-right"><small><?php echo _l('enable_all'); ?></small></a>
        <?php } ?>

    </h4>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th><?php echo _l('email_templates_table_heading_name'); ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($hr_templates as $hr_template){ ?>
                <tr>
                    <td class="<?php if($hr_template['active'] == 0){echo 'text-throught';} ?>">
                        <a href="<?php echo admin_url('emails/email_template/'.$hr_template['emailtemplateid']); ?>"><?php echo $hr_template['name']; ?></a>
                        <?php if(ENVIRONMENT !== 'production'){ ?>
                            <br/><small><?php echo $hr_template['slug']; ?></small>
                        <?php } ?>
                        <?php if($hasPermissionEdit){ ?>
                            <a href="<?php echo admin_url('emails/'.($hr_template['active'] == '1' ? 'disable/' : 'enable/').$hr_template['emailtemplateid']); ?>" class="pull-right"><small><?php echo _l($hr_template['active'] == 1 ? 'disable' : 'enable'); ?></small></a>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>

</div>