<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" id="roboto-css"
          href="<?php echo site_url('assets/plugins/roboto/roboto.css'); ?>">
    <style>
        <?php if(is_rtl()) { ?>
        @font-face {
            font-family: 'ar';
            font-style: normal;
            font-weight: normal;
            src: local('ar'), url("../assets/css/Cairo-Regular.ttf") format('truetype');
        }
        <?php } ?>

        body {
            <?php echo is_rtl() ? "font-family: 'ar', serif;" : "font-family: Roboto, Geneva, sans-serif"; ?>
            font-size: 15px;
            <?php echo is_rtl() ? 'direction: rtl;' : ''; ?>
            overflow: hidden;
        }

        .bold, b, strong, h1, h2, h3, h4, h5, h6 {
            font-weight: 500;
        }

        .wrapper {
            margin: 0 auto;
            display: block;
            background: #f0f0f0;
            width: 700px;
            border: 1px solid #e4e4e4;
            padding: 20px;
            border-radius: 4px;
            margin-top: 50px;
            text-align: center;
        }

        .wrapper h1 {
            text-align: center;
            font-size: 27px;
            color: red;
            margin-top: 0px;
        }

        .wrapper .upgrade_now {
        <?php echo is_rtl() ? "font-family: 'ar', serif;" : "font-family: Roboto, Geneva, sans-serif"; ?>
            text-transform: uppercase;
            background: #82b440;
            color: #fff;
            padding: 15px 25px;
            border-radius: 3px;
            text-decoration: none;
            text-align: center;
            border: 0px;
            outline: 0px;
            cursor: pointer;
            font-size: 15px;
        }

        .wrapper .upgrade_now:hover, .wrapper .upgrade_now:active {
            background: #73a92d;
        }

        .wrapper .upgrade_now:disabled {
            cursor: not-allowed;
            pointer-events: none;
            box-shadow: none;
            opacity: .65;
        }

        .upgrade_now_wrapper {
            margin: 0 auto;
            width: 100%;
            text-align: left;
            margin-top: 35px;
        }

        .note {
            color: #636363;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <h1><?php echo _l('migration_lang_1'); ?></h1>
    <p><?php echo _l('migration_lang_2',
            [
                wordwrap($this->config->item('migration_version'), 1, '.', true),
                wordwrap($this->current_db_version, 1, '.', true),
            ]); ?></p>
    <p class="bold"><?php echo _l('migration_lang_3'); ?></p>
    <div class="upgrade_now_wrapper">
        <div style="text-align:center">
            <?php echo form_open($this->config->site_url($this->uri->uri_string()), array('id' => 'upgrade_db_form')); ?>
            <input type="hidden" name="upgrade_database" value="true">
            <button type="submit" id="submit_btn" onclick="upgradeDB(); return false;"
                    class="upgrade_now"><?php echo _l('migration_lang_4'); ?></button>
            <?php echo form_close(); ?>
        </div>
        <br/>
        <p style="text-align:center;">
            <small class="note"><?php echo _l('migration_lang_5'); ?></small>
        </p>
        <?php
        if ($copyData = get_last_upgrade_copy_data()) {
            if ($copyData->version == $this->config->item('migration_version')) { ?>
                <hr/>
                <h3><?php echo _l('migration_lang_6'); ?></h3>
                <p style="line-height:20px;">
                    <?php echo _l('migration_lang_7'); ?>
                </p>
                <p style="line-height:20px;">
                    <?php echo _l('migration_lang_8', $copyData->path); ?>
                </p>
                <?php echo _l('migration_lang_9', _delete_temporary_files_older_then() / 60); ?>
                <p>
                    <?php echo _l('migration_lang_10',
                        [
                            basename($copyData->path),
                            FCPATH,
                        ]); ?>
                </p>
                <small class="note"> <?php echo _l('migration_lang_11'); ?></small>
                <?php
            }
        }
        ?>
    </div>
</div>
<script>
    function upgradeDB() {
        document.getElementById('submit_btn').disabled = true;
        document.getElementById('submit_btn').innerHTML = "<?php echo _l('migration_lang_12'); ?>";
        document.getElementById("upgrade_db_form").submit();
    }
</script>
</body>
</html>
