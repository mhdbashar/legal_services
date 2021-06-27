<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <?php echo form_open_multipart(
            (!isset($tab['update_url'])
                ? $this->uri->uri_string() . '?group=' . $tab['slug'] . ($this->input->get('tab') ? '&active_tab=' . $this->input->get('tab') : '')
                : $tab['update_url']),
            ['id' => 'settings-form', 'class' => isset($tab['update_url']) ? 'custom-update-url' : '']
        );
        ?>
        <div class="row">
            <?php if ($this->session->flashdata('debug')) {
                ?>
                <div class="col-lg-12">
                    <div class="alert alert-warning">
                        <?php echo $this->session->flashdata('debug'); ?>
                    </div>
                </div>
            <?php } ?>
            <div class="col-md-3">
                <ul class="nav navbar-pills navbar-pills-flat nav-tabs nav-stacked">
                    <?php
                    $i = 0;
                    foreach ($tabs as $group) {
                        ?>
                        <li class="settings-group-<?php echo $group['slug']; ?><?php echo ($i === 0) ? ' active' : '' ?>">
                            <a href="<?php echo admin_url('settings?group=' . $group['slug']); ?>" data-group="<?php echo $group['slug']; ?>">
                                <?php echo $group['name']; ?>
                                <?php if (isset($group['badge'], $group['badge']['value']) && !empty($group['badge'])) {?>
                                    <span class="badge pull-right
                     <?=isset($group['badge']['type']) &&  $group['badge']['type'] != '' ? "bg-{$group['badge']['type']}" : 'bg-info' ?>"
                     <?=(isset($group['badge']['type']) &&  $group['badge']['type'] == '') ||
                     isset($group['badge']['color']) ? "style='background-color: {$group['badge']['color']}'" : '' ?>>
                  <?= $group['badge']['value'] ?>
                  </span>
                                <?php } ?>
                            </a>
                        </li>
                        <?php $i++;
                    }
                    ?>
                </ul>
                <div class="panel_s">
                    <div class="panel-body">
                        <a href="<?php echo admin_url('settings?group=update'); ?>"
                           class="settings-group-system-update<?php if ($this->input->get('group') == 'update') {
                               echo 'bold';
                           } ?>">
                            <?php echo _l('settings_update'); ?>
                        </a>
                        <!-- <?php //if (is_admin()) {
                        ?>
                     <hr class="hr-10" />
                     <a href="<?php //echo admin_url('settings?group=info'); ?>" class="settings-group-system-info<?php //if ($this->input->get('group') == 'info') {
                        //echo 'bold';
                        //} ?>">
                       System/Server Info
                     </a>
                     <?php
                        //} ?> -->
                        <?php if (is_admin()) {
                            ?>
                            <hr class="hr-10"/>
                            <a href="<?php echo admin_url('settings?group=license'); ?>"
                               class="<?php if ($this->input->get('group') == 'license') {
                                   echo 'bold';
                               } ?>">
                                <?php echo _l('license_key'); ?>
                            </a>
                            <?php
                        } ?>
                        <div class="btn-bottom-toolbar text-right">
                            <button id="submit_office_name" type="submit" class="btn btn-info">
                                <?php echo _l('settings_save'); ?>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="panel_s">
                    <div class="panel-body">
                        <?php hooks()->do_action('before_settings_group_view', $tab); ?>
                        <?php $this->load->view($tab['view']) ?>
                        <?php hooks()->do_action('after_settings_group_view', $tab); ?>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <?php echo form_close(); ?>
        <div class="btn-bottom-pusher"></div>
    </div>
</div>
<div id="new_version"></div>
<?php init_tail(); ?>
<script>
    $(function(){
        var slug = "<?php echo $tab['slug']; ?>";
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            var settingsForm = $('#settings-form');

            if(settingsForm.hasClass('custom-update-url')) {
                return;
            }

            var tab = $(this).attr('href').slice(1);
            settingsForm.attr('action','<?php echo site_url($this->uri->uri_string()); ?>?group='+slug+'&active_tab='+tab);
        });

        $('input[name="settings[email_protocol]"]').on('change',function(){
            if($(this).val() == 'mail'){
                $('.smtp-fields').addClass('hide');
            } else {
                $('.smtp-fields').removeClass('hide');
            }
        });

        $('.sms_gateway_active input').on('change',function(){
            if($(this).val() == '1') {
                $('body .sms_gateway_active').not($(this).parents('.sms_gateway_active')[0]).find('input[value="0"]').prop('checked',true);
            }
        });

        <?php if ($tab['slug'] == 'pusher') {
        if (get_option('desktop_notifications') == '1') {
        ?>
        // Let's check if the browser supports notifications
        if (!("Notification" in window)) {
            $('#pusherHelper').html('<div class="alert alert-danger">Your browser does not support desktop notifications, please disable this option or use more modern browser.</div>');
        } else if(Notification.permission == "denied") {
            $('#pusherHelper').html('<div class="alert alert-danger">Desktop notifications not allowed in browser settings, search on Google "How to allow desktop notifications for <?php echo $this->agent->browser(); ?>"</div>');
        }
        <?php } ?>
        <?php if (get_option('pusher_realtime_notifications') == '0') {
        ?>
        $('input[name="settings[desktop_notifications]"]').prop('disabled',true);
        <?php } ?>
        <?php } ?>

        $('input[name="settings[pusher_realtime_notifications]"]').on('change',function(){
            if($(this).val() == '1'){
                $('input[name="settings[desktop_notifications]"]').prop('disabled',false);
            } else {
                $('input[name="settings[desktop_notifications]"]').prop('disabled',true);
                $('input[name="settings[desktop_notifications]"][value="0"]').prop('checked',true);
            }
        });

        $('.test_email').on('click', function() {
            var email = $('input[name="test_email"]').val();
            if (email != '') {
                $(this).attr('disabled', true);
                $.post(admin_url + 'emails/sent_smtp_test_email', {
                    test_email: email
                }).done(function(data) {
                    window.location.reload();
                });
            }
        });

        $('#update_app').on('click',function(e){
            e.preventDefault();
            $('input[name="settings[purchase_key]"]').parents('.form-group').removeClass('has-error');
            var purchase_key = $('input[name="settings[purchase_key]"]').val();
            var latest_version = $('input[name="latest_version"]').val();
            var upgrade_function = $('input[name="upgrade_function"]:checked').val();
            var update_errors;
            if(purchase_key != ''){
                var ubtn = $(this);
                ubtn.html('<?php echo _l('wait_text'); ?>');
                ubtn.addClass('disabled');
                $.post(admin_url+'auto_update',{
                    purchase_key:purchase_key,
                    latest_version:latest_version,
                    auto_update:true,
                    upgrade_function:upgrade_function
                }).done(function(){
                    window.location.reload();
                }).fail(function(response){
                    update_errors = JSON.parse(response.responseText);
                    $('#update_messages').html('<div class="alert alert-danger"></div>');
                    for (var i in update_errors) {
                        $('#update_messages .alert').append('<p>' + update_errors[i] + '</p>');
                    }
                    ubtn.removeClass('disabled');
                    ubtn.html($('.update_app_wrapper').data('original-text'));
                });
            } else {
                $('input[name="settings[purchase_key]"]').parents('.form-group').addClass('has-error');
            }
        });

        <?php if($this->input->get('group') == 'general'){ ?>
        $('#submit_office_name').on('click', function (e) {
            if ($("input[name='settings[office_name_in_center]']").length) {
                var office_name_in_center = $("input[name='settings[office_name_in_center]']").val();
                e.preventDefault();
            } else {
                console.log("Not exist!");
            }
            $.ajax({
                url: '<?php echo site_url($this->uri->uri_string()); ?>/get_office_name',
                type: 'POST',
                dataType: 'json',
                data: {office_name_in_center: office_name_in_center},
                error: function (e) {
                    alert('عذراً! يرجى إعادة المحاولة...لا يوجد قيمة مفتاح مرتبطة بهذا الاسم');
                },
                success: function (data) {
                    if (data.status == true) {
                        $(window).off('beforeunload');
                        $("#settings-form").unbind('submit').submit();
                    } else if (data.status == false) {
                        $("input[name='settings[office_name_in_center]']").css('border', '2px solid red');
                    }
                }
            });
        });
        <?php } ?>
    });
</script>
<?php if ($tab['slug'] == 'company') { ?>
    <script type="text/javascript">
        function get_city() {
            var invoice_company_city = $("[name^='settings[company_country]']");
            $.ajax({
                url: "<?php echo admin_url('Countries/build_dropdown_cities'); ?>",
                data: {country: invoice_company_city.val()},
                type: "POST",
                success: function (data) {
                    $("#city").html(data);
                }
            });
        }
    </script>
<?php } ?>
<?php hooks()->do_action('settings_group_end', $tab); ?>
</body>
</html>