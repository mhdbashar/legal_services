<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_528 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
    }
    public function up()
    {

        add_option('settings[regular_durations_reminder_notification_before]', '5');

        $this->db->query("INSERT INTO `tblemailtemplates` (`type`, `slug`, `language`, `name`, `subject`, `message`, `fromname`, `fromemail`, `plaintext`, `active`, `order`) VALUES
('regular_duration', 'regular-duration-deadline-notification', 'english', 'Regular duration reminder', 'Regular duration reminder', '<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">Dear {staff}</span></div>
<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">This is a reminder that the following regular duration will expire soon:</span></div>
<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\"><strong>Subject:</strong> {regular_duration_subject}</span></div>
<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\"><strong>Description:</strong> {regular_duration_description}</span></div>
<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\"><strong>Date Start:</strong> {regular_duration_datestart}</span></div>
<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\"><strong>Date End:</strong> {regular_duration_dateend}</span></div>
<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">Please contact us for more information.</span></div>
<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">Kind Regards,</span></div>
<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">{email_signature}</span></div>', '{companyname} | CRM', '', 0, 1, 1);");

        $this->db->query("INSERT INTO `tblemailtemplates` (`type`, `slug`, `language`, `name`, `subject`, `message`, `fromname`, `fromemail`, `plaintext`, `active`, `order`) VALUES
('regular_duration', 'regular-duration-deadline-notification', 'arabic', 'Regular duration reminder', 'Regular duration reminder', '<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">Dear {staff}</span></div>
<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">This is a reminder that the following regular duration will expire soon:</span></div>
<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\"><strong>Subject:</strong> {regular_duration_subject}</span></div>
<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\"><strong>Description:</strong> {regular_duration_description}</span></div>
<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\"><strong>Date Start:</strong> {regular_duration_datestart}</span></div>
<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\"><strong>Date End:</strong> {regular_duration_dateend}</span></div>
<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">Please contact us for more information.</span></div>
<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">Kind Regards,</span></div>
<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">{email_signature}</span></div>', '{companyname} | CRM', '', 0, 1, 1);");


        $this->db->query("INSERT INTO `tblemailtemplates` (`type`, `slug`, `language`, `name`, `subject`, `message`, `fromname`, `fromemail`, `plaintext`, `active`, `order`) VALUES
('procuration', 'procuration-deadline-notification', 'english', 'procuration reminder', 'procuration reminder', '<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">Dear {staff}</span></div>
<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">This is a reminder that the following procuration will expire soon:</span></div>
<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\"><strong>Subject:</strong> {procuration_subject}</span></div>
<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\"><strong>Description:</strong> {procuration_description}</span></div>
<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\"><strong>Date Start:</strong> {procuration_datestart}</span></div>
<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\"><strong>Date End:</strong> {procuration_dateend}</span></div>
<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">Please contact us for more information.</span></div>
<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">Kind Regards,</span></div>
<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">{email_signature}</span></div>', '{companyname} | CRM', '', 0, 1, 1);");


        $this->db->query("INSERT INTO `tblemailtemplates` (`type`, `slug`, `language`, `name`, `subject`, `message`, `fromname`, `fromemail`, `plaintext`, `active`, `order`) VALUES
('procuration', 'procuration-deadline-notification', 'arabic', 'procuration reminder', 'procuration reminder', '<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">Dear {staff}</span></div>
<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">This is a reminder that the following procuration will expire soon:</span></div>
<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\"><strong>Subject:</strong> {procuration_subject}</span></div>
<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\"><strong>Description:</strong> {procuration_description}</span></div>
<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\"><strong>Date Start:</strong> {procuration_datestart}</span></div>
<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\"><strong>Date End:</strong> {procuration_dateend}</span></div>
<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">Please contact us for more information.</span></div>
<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">Kind Regards,</span></div>
<div style=\"text-align: left;\"><span style=\"font-size: 12pt;\">{email_signature}</span></div>', '{companyname} | CRM', '', 0, 1, 1);");


    }
    }