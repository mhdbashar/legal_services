<?php $this->load->view('settings/modals/warnings_type_modal') ?>
<?php if (has_permission('hr_settings', '', 'create')) { ?><a href="#" class="btn btn-info pull-left"
                                                              data-toggle="modal"
                                                              data-target="#add_relation_type"><?php echo _l('add_warnings_type'); ?></a>
<?php } ?>
<div class="clearfix"></div>
<hr class="hr-panel-heading"/>
<div class="clearfix"></div>
<table class="table dt-table scroll-responsive" data-order-col="0" data-order-type="asc">
    <thead>
    <th><?php echo _l('#'); ?></th>
    <th><?php echo _l('name'); ?></th>
    <th><?php echo _l('options'); ?></th>

    </thead>
    <tbody>
    <!--start default statuses-->
    <?php foreach($warnings as $warning){ ?>
        <tr >
            <td>
                <?php echo $warning['id']; ?>
            </td>
            <td>
                <?php echo $warning['name_warnings']; ?>
            </td>
            <td>
              <?php echo icon_btn('#' , 'pencil-square-o', 'btn-default old', ['data-toggle' => 'modal', 'data-target' => '#update_type', 'data-id' => $warning['id'], 'data-old' => $warning['name_warnings'], 'onclick' => "edit('" . $warning['id'] . "')"]);?>
                <?php echo icon_btn('hr_profile/delete_type_warnings/'.$warning['id'] , 'remove', 'btn-danger _delete');?>

            </td>

        </tr>
    <?php } ?>
    <!--start custom statuses-->
    </tbody>
</table>

