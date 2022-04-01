<?php
defined('BASEPATH') or exit('No direct script access allowed');
function google_client()
{
    $CI = &get_instance();
    $client = new Google_Client();
    $client_sitting = array("web" => array(
        "client_id" => "$CI->__google_sheets_ClientId",
        "project_id" => "$CI->__google_sheets_ProjectId",
        "auth_uri" => "https://accounts.google.com/o/oauth2/auth",
        "token_uri" => "https://oauth2.googleapis.com/token",
        "auth_provider_x509_cert_url" => "https://www.googleapis.com/oauth2/v1/certs",
        "client_secret" => "$CI->_google_sheets_ClientSecret",
        "redirect_uris" => [$CI->_google_sheetsAppRedirectUri]));
    $client->setAuthConfig($client_sitting);
    $client->addScope(Google_Service_Drive::DRIVE);
    $client->setRedirectUri(admin_url('googlesheets/login'));
    $credentials = $CI->Drive_model->get(get_staff_user_id());
    $client->setApprovalPrompt('force');
    $client->setAccessType("offline");
    if (is_array($credentials)) {
        unset($credentials['staff_id']);
        $access_token = $credentials;
        $client->setAccessToken($access_token);
        if ($client->isAccessTokenExpired()) {
            log_message("error", "is expired");
            $refresh_token = $client->getRefreshToken();
            $client->fetchAccessTokenWithRefreshToken($refresh_token);
            if ($client->getAccessToken()) {
                $CI->Drive_model->update($client->getAccessToken(), get_staff_user_id());
                return $client;
            } else {
                redirect(admin_url('googlesheets/logout'));
            }

        }
    }
    redirect(admin_url('googlesheets'));

}
