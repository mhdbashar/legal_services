<?php defined('BASEPATH') or exit('No direct script access allowed');?>
<div class="panel_s section-heading section-projects">
    <div class="panel-body">
        <h4 class="no-margin section-text"><?php echo _l('البريد الوارد والصادر'); ?></h4>
    </div>
</div>
<div class="panel_s">
    <div class="panel-body">
        <div class="row mbot15">
            <div class="col-md-12">

                <div style="padding: 10px;">
                    <?php if (has_contact_permission('messages')) {?>
                    <a style="margin-left:5px ;" href="<?php echo site_url('Messages/messagescu'); ?>"
                        class="btn btn-info pull-left  new"><?php echo _l('رسالة جديدة'); ?></a>
                    <a style="margin-left:5px ;" href="<?php echo site_url('Messages/sent_items'); ?>"
                        class="btn btn-info pull-left "><?php echo _l(' البريد الصادر'); ?></a>
                    <?php }?>
                    <?php if (has_contact_permission('customer_see_email_only') || (has_contact_permission('messages'))) {?>
                    <a style="margin-left:5px ;" href="<?php echo site_url('Messages/inbox'); ?>"
                        class="btn btn-info pull-left "><?php echo _l(' البريد الوارد'); ?></a>
                    <?php }?>
                    <div class="clearfix"></div>
                    <hr class="hr-panel-heading" />
                </div>
            </div>
            <div class="clearfix"></div>


        </div>
        <hr />
        <table class="table dt-table" data-order-col="1" data-order-type="desc">
            <thead>
                <tr>
                    <th class="th-project-name"><?php echo _l('الرقم'); ?></th>



                    <th class="th-project-start-date"><?php echo _l('المرسل'); ?></th>


                    <th class="th-project-start-date"><?php echo _l('الموضوع'); ?> </th>



                </tr>
            </thead>
            <tbody>

                <?php foreach ($messages as $message) {?>
                <tr>

                    <td><?php echo $message['id']; ?></td>
                    <td>
                  <?php

    $member = $model->GetSender($message['from_user_id']);
    ?>
                  <?php echo $member->firstname . ' ' . $member->lastname; ?>
                     </td>
                    <td data-order="<?php echo $message['subject']; ?>"><a
                            href="<?php echo site_url('messages/view_view/' . $message['id']) ?>"><?php echo $message['subject']; ?></a>
                    </td>




                </tr>
                <?php }?>
            </tbody>
        </table>
    </div>
</div>