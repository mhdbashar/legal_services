<?php

defined('BASEPATH') or exit('No direct script access allowed');


function render_js_variables(){

    echo '<script>';

    echo 'var site_url = "' . site_url() . '";';
    echo 'var API_KEY = "' . get_option('zoom_api_key') . '";';
    echo 'var API_SECRET = "' . get_option('zoom_secret_key') . '";';

    echo '</script>';
}
