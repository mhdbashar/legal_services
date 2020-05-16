<?php

defined('BASEPATH') or exit('No direct script access allowed');


function render_js_variables(){

    echo '<script>';

    echo 'var site_url = "' . site_url() . '";';
    echo '</script>';

}