<?php
defined('BASEPATH') or exit('No direct script access allowed');

$enabled = get_option('babil_multi_theme_clients'); ?>

<div class="form-group">
    <label for="babil_multi_theme_clients" class="control-label clearfix">
        <?= _l('babil_multi_theme_settings'); ?>
    </label>
    <hr>
    <div class="radio radio-primary radio-inline">
        <input type="radio" id="y_opt_1_babil_multi_theme_clients_enabled" name="settings[babil_multi_theme_clients]" value="1" <?= ($enabled == '1') ? ' checked' : '' ?>>
        <label for="y_opt_1_babil_multi_theme_clients_enabled">
            <?= _l('settings_yes'); ?>
        </label>
    </div>
    <div class="radio radio-primary radio-inline">
        <input type="radio" id="y_opt_2_admin-multi_theme_enabled" name="settings[babil_multi_theme_clients]" value="0" <?= ($enabled == '0') ? ' checked' : '' ?>>
        <label for="y_opt_2_admin-multi_theme_enabled">
            <?= _l('settings_no'); ?>
        </label>
    </div>
</div>