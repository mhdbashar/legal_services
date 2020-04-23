<?php
defined('BASEPATH') or exit('No direct script access allowed');
init_head();
?>
<div id="wrapper" class="desktop_chat">
  <div id="frame">
    <div class="main_loader_init" id="main_loader_init">
      <div></div>
      <div></div>
      <div></div>
    </div>
    <div id="sidepanel">
      <div id="profile">
        <div class="wrap">
          <?php echo staff_profile_image($current_user->staffid, array('img', 'img-responsive', 'staff-profile-image-small', 'pull-left'), 'small', ['id' => 'profile-img']); ?>
          <p>
            <?php echo get_staff_full_name(); ?>
            <div id="status-options" class="">
              <ul>
                <li id="status-online" class="active"><span class="status-circle"></span>
                  <p><?= _l('chat_status_online'); ?></p>
                </li>
                <li id="status-away"><span class="status-circle"></span>
                  <p><?= _l('chat_status_away'); ?></p>
                </li>
                <li id="status-busy"><span class="status-circle"></span>
                  <p><?= _l('chat_status_busy'); ?></p>
                </li>
                <li id="status-offline"><span class="status-circle"></span>
                  <p><?= _l('chat_status_offline'); ?></p>
                </li>
              </ul>
            </div>
          </p>
        </div>
      </div>
      <div class="connection_field">
        <i class="fa fa-wifi blink"></i>
      </div>
      <div id="search" style="width: <?= is_admin() ? '85%' : '100%'; ?>">
        <label for=""><svg class="fa-search" viewBox="0 0 24 24">
            <path d="M10,13C9.65,13.59 9.36,14.24 9.19,14.93C6.5,15.16 3.9,16.42 3.9,17V18.1H9.2C9.37,18.78 9.65,19.42 10,20H2V17C2,14.34 7.33,13 10,13M10,4A4,4 0 0,1 14,8C14,8.91 13.69,9.75 13.18,10.43C12.32,10.75 11.55,11.26 10.91,11.9L10,12A4,4 0 0,1 6,8A4,4 0 0,1 10,4M10,5.9A2.1,2.1 0 0,0 7.9,8A2.1,2.1 0 0,0 10,10.1A2.1,2.1 0 0,0 12.1,8A2.1,2.1 0 0,0 10,5.9M15.5,12C18,12 20,14 20,16.5C20,17.38 19.75,18.21 19.31,18.9L22.39,22L21,23.39L17.88,20.32C17.19,20.75 16.37,21 15.5,21C13,21 11,19 11,16.5C11,14 13,12 15.5,12M15.5,14A2.5,2.5 0 0,0 13,16.5A2.5,2.5 0 0,0 15.5,19A2.5,2.5 0 0,0 18,16.5A2.5,2.5 0 0,0 15.5,14Z" />
          </svg></i></label>
        <input type="text" id="search_field" placeholder="<?php echo _l('chat_search_chat_members'); ?>" data-container="body" data-toggle="tooltip" data-placement="top" title="<?php echo _l('chat_search'); ?>" />
      </div>
      <?=
        (is_admin())
          ?
          '<div class="announcement" id="announcement">
      <div class="dropdown">
      <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown"><svg class="i_settings" fill="#ffffff" viewBox="0 0 24 24">
    <path d="M18 14H20V17H23V19H20V22H18V19H15V17H18V14M12 3C17.5 3 22 6.58 22 11C22 11.58 21.92 12.14 21.78 12.68C20.95 12.25 20 12 19 12C15.69 12 13 14.69 13 18L13.08 18.95L12 19C10.76 19 9.57 18.82 8.47 18.5C5.55 21 2 21 2 21C4.33 18.67 4.7 17.1 4.75 16.5C3.05 15.07 2 13.14 2 11C2 6.58 6.5 3 12 3Z"/>
  </svg></button>
      <ul class="dropdown-menu">
      <li class="i_announcement"><a href="javascript:void(0)"><svg class="announcement_svg_icon" viewBox="0 0 24 24">
      <path d="M13,10H11V6H13V10M13,12H11V14H13V12M22,4V16A2,2 0 0,1 20,18H6L2,22V4A2,2 0 0,1 4,2H20A2,2 0 0,1 22,4M20,4H4V17.2L5.2,16H20V4Z"/>
      </svg>' . _l('chat_message_announcement_text') . '</a></li>
      <li class="i_groups"><a href="javascript:void(0)"><svg class="create_group" viewBox="0 0 24 24">
    <path d="M13 11A3 3 0 1 0 10 8A3 3 0 0 0 13 11M13 7A1 1 0 1 1 12 8A1 1 0 0 1 13 7M17.11 10.86A5 5 0 0 0 17.11 5.14A2.91 2.91 0 0 1 18 5A3 3 0 0 1 18 11A2.91 2.91 0 0 1 17.11 10.86M13 13C7 13 7 17 7 17V19H19V17S19 13 13 13M9 17C9 16.71 9.32 15 13 15C16.5 15 16.94 16.56 17 17M24 17V19H21V17A5.6 5.6 0 0 0 19.2 13.06C24 13.55 24 17 24 17M8 12H5V15H3V12H0V10H3V7H5V10H8Z"/>
</svg>' . _l('chat_message_groups_text') . '</a></li>
      </ul>
      </div>
      </div>'
          : '';
      ?>
      <ul class="nav nav-tabs chat_nav">
        <li class="active staff" style="<?= (!isClientsEnabled()) ? 'width:50%;' : ''; ?> "><svg class="i_chat_navigaton" viewBox="0 0 24 24">
            <path d="M13.07 10.41A5 5 0 0 0 13.07 4.59A3.39 3.39 0 0 1 15 4A3.5 3.5 0 0 1 15 11A3.39 3.39 0 0 1 13.07 10.41M5.5 7.5A3.5 3.5 0 1 1 9 11A3.5 3.5 0 0 1 5.5 7.5M7.5 7.5A1.5 1.5 0 1 0 9 6A1.5 1.5 0 0 0 7.5 7.5M16 17V19H2V17S2 13 9 13 16 17 16 17M14 17C13.86 16.22 12.67 15 9 15S4.07 16.31 4 17M15.95 13A5.32 5.32 0 0 1 18 17V19H22V17S22 13.37 15.94 13Z" />
          </svg><a data-toggle="tab" href="#staff"><?= _l('chat_staff_text');  ?></a></li>
        <li class="groups events_disabled" style="<?= (!isClientsEnabled()) ? 'width:50%;' : ''; ?> "><svg class="i_chat_navigation" viewBox="0 0 24 24">
            <path d="M12,5.5A3.5,3.5 0 0,1 15.5,9A3.5,3.5 0 0,1 12,12.5A3.5,3.5 0 0,1 8.5,9A3.5,3.5 0 0,1 12,5.5M5,8C5.56,8 6.08,8.15 6.53,8.42C6.38,9.85 6.8,11.27 7.66,12.38C7.16,13.34 6.16,14 5,14A3,3 0 0,1 2,11A3,3 0 0,1 5,8M19,8A3,3 0 0,1 22,11A3,3 0 0,1 19,14C17.84,14 16.84,13.34 16.34,12.38C17.2,11.27 17.62,9.85 17.47,8.42C17.92,8.15 18.44,8 19,8M5.5,18.25C5.5,16.18 8.41,14.5 12,14.5C15.59,14.5 18.5,16.18 18.5,18.25V20H5.5V18.25M0,20V18.5C0,17.11 1.89,15.94 4.45,15.6C3.86,16.28 3.5,17.22 3.5,18.25V20H0M24,20H20.5V18.25C20.5,17.22 20.14,16.28 19.55,15.6C22.11,15.94 24,17.11 24,18.5V20Z" />
          </svg><a data-toggle="tab" class="events_disabled" href="#groups"><?= _l('chat_groups_text');  ?></a></li>
        <?php if (isClientsEnabled()) : ?>
          <li class="crm_clients"><svg class="i_chat_navigation" viewBox="0 0 24 24">
              <path d="M16.36 12.76C18.31 13.42 20 14.5 20 16V21H4V16C4 14.5 5.69 13.42 7.65 12.76L8.27 14L8.5 14.5C7 14.96 5.9 15.62 5.9 16V19.1H10.12L11 14.03L10.06 12.15C10.68 12.08 11.33 12.03 12 12.03C12.67 12.03 13.32 12.08 13.94 12.15L13 14.03L13.88 19.1H18.1V16C18.1 15.62 17 14.96 15.5 14.5L15.73 14L16.36 12.76M12 5C10.9 5 10 5.9 10 7C10 8.1 10.9 9 12 9C13.1 9 14 8.1 14 7C14 5.9 13.1 5 12 5M12 11C9.79 11 8 9.21 8 7C8 4.79 9.79 3 12 3C14.21 3 16 4.79 16 7C16 9.21 14.21 11 12 11Z" />
            </svg><a data-toggle="tab" class="events_disabled" href="#crm_clients"><?= _l('chat_lang_clients'); ?></a></li>
        <?php endif; ?>
      </ul>
      <div class="tab-content">
        <div id="staff" class="tab-pane fade in active">
          <div id="contacts">
            <div id="bottom-bar">
              <button id="switchTheme">
                <svg class="theme_icon" viewBox="0 0 24 24">
                  <path d="M19,3H14V5H19V18L14,12V21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3M10,18H5L10,12M10,3H5C3.89,3 3,3.89 3,5V19A2,2 0 0,0 5,21H10V23H12V1H10V3Z" />
                </svg>
                <span>
                  <div class="dropdown" id="theme_options">
                    <a href="#" class="dropbtn"><?php echo _l('chat_theme_name'); ?></a>
                    <div class="dropdown-content">
                      <a id="light" onClick="chatSwitchTheme('light')" href="#"><?php echo _l('chat_theme_options_light'); ?></a>
                      <a id="dark" onClick="chatSwitchTheme('dark')" href="#"><?php echo _l('chat_theme_options_dark'); ?></a>
                    </div>
                  </div>
                </span></button>
              <button id="settings">
                <svg class="theme_icon" viewBox="0 0 24 24">
                  <path d="M11 24H13V22H11V24M7 24H9V22H7V24M15 24H17V22H15V24M20 2H4C2.9 2 2 2.9 2 4V22L6 18H20C21.11 18 22 17.11 22 16V4C22 2.9 21.11 2 20 2M20 16H6L4 18V4H20" />
                </svg><span><?= _l('settings'); ?></span></button>
            </div>
            <ul class="chat_contacts_list">
              <li class="contact">
                <!-- Contacts list -->
              </li>
            </ul>
          </div>
        </div>
        <div id="groups" class="tab-pane fade">
          <div id="groups_container">
            <ul class="chat_groups_list">
            </ul>
            <div id="bottom-bar">
              <button id="add_group_btn">
                <svg viewBox="0 0 24 24">
                  <path d="M13 11A3 3 0 1 0 10 8A3 3 0 0 0 13 11M13 7A1 1 0 1 1 12 8A1 1 0 0 1 13 7M17.11 10.86A5 5 0 0 0 17.11 5.14A2.91 2.91 0 0 1 18 5A3 3 0 0 1 18 11A2.91 2.91 0 0 1 17.11 10.86M13 13C7 13 7 17 7 17V19H19V17S19 13 13 13M9 17C9 16.71 9.32 15 13 15C16.5 15 16.94 16.56 17 17M24 17V19H21V17A5.6 5.6 0 0 0 19.2 13.06C24 13.55 24 17 24 17M8 12H5V15H3V12H0V10H3V7H5V10H8Z" />
                </svg>
                <span><?= _l('chat_message_groups_text'); ?></span></button>
            </div>
          </div>
        </div>
        <?php if (isClientsEnabled()) : ?>
          <div id="crm_clients" class="tab-pane fade">
            <div id="clients_container">
              <ul class="chat_clients_list">
              </ul>
              <div id="bottom-bar">
                <button id="clients_show">
                  <svg viewBox="0 0 24 24">
                    <path d="M11 9C11 10.66 9.66 12 8 12C6.34 12 5 10.66 5 9C5 7.34 6.34 6 8 6C9.66 6 11 7.34 11 9M14 20H2V18C2 15.79 4.69 14 8 14C11.31 14 14 15.79 14 18M7 9C7 9.55 7.45 10 8 10C8.55 10 9 9.55 9 9C9 8.45 8.55 8 8 8C7.45 8 7 8.45 7 9M4 18H12C12 16.9 10.21 16 8 16C5.79 16 4 16.9 4 18M22 12V14H13V12M22 8V10H13V8M22 4V6H13V4Z" />
                  </svg>
                  <span><?= _l('chat_lang_show_clients'); ?></span></button>
                <div class="clients_settings dropup">
                  <button class="btn btn-default dropdown-toggle" type="button" id="dropDownOptions" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <svg class="c_settings" data-toggle="tooltip" title="<?= _l('chat_clients_bottom_options'); ?>" viewBox="0 0 24 24">
                      <path d="M10.04,20.4H7.12C6.19,20.4 5.3,20 4.64,19.36C4,18.7 3.6,17.81 3.6,16.88V7.12C3.6,6.19 4,5.3 4.64,4.64C5.3,4 6.19,3.62 7.12,3.62H10.04V20.4M7.12,2A5.12,5.12 0 0,0 2,7.12V16.88C2,19.71 4.29,22 7.12,22H11.65V2H7.12M5.11,8C5.11,9.04 5.95,9.88 7,9.88C8.03,9.88 8.87,9.04 8.87,8C8.87,6.96 8.03,6.12 7,6.12C5.95,6.12 5.11,6.96 5.11,8M17.61,11C18.72,11 19.62,11.89 19.62,13C19.62,14.12 18.72,15 17.61,15C16.5,15 15.58,14.12 15.58,13C15.58,11.89 16.5,11 17.61,11M16.88,22A5.12,5.12 0 0,0 22,16.88V7.12C22,4.29 19.71,2 16.88,2H13.65V22H16.88Z" />
                    </svg>
                  </button>
                  <ul class="dropdown-menu animated fadeIn" aria-labelledby="dropDownOptions">
                    <li><a href="javascript:void(0)" id="showOnlineContacts"><i class="fa fa-circle" aria-hidden="true"></i><?= _l('chat_only_online_clients'); ?></a></li>
                    <li><a href="javascript:void(0)" id="resetContacts"><i class="fa fa-refresh" aria-hidden="true"></i><?= _l('chat_reload_clients_list'); ?></a></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>

    <div class="content">
      <div id="sharedFiles">
        <i class="fa fa-times-circle-o" aria-hidden="true"></i>
        <div class="history_slider">
          <!-- Message and files history -->
        </div>
      </div>
      <div class="chat_group_options">
        <!-- Group options  -->
      </div>
      <div class="contact-profile">
        <svg onclick="chatBackMobile()" data-toggle="tooltip" title="Back" class="chat_back_mobile" viewBox="0 0 24 24">
          <path d="M20,11V13H8L13.5,18.5L12.08,19.92L4.16,12L12.08,4.08L13.5,5.5L8,11H20Z" />
        </svg>
        <img src="" class="img img-responsive staff-profile-image-small pull-left" alt="" />
        <p></p>
        <i class="fa fa-volume-up user_sound_icon" data-toggle="tooltip" title="<?= _l('chat_sound_notifications'); ?>"></i>
        <div class="social-media mright15">
          <svg data-toggle="tooltip" data-container="body" title="<?php echo _l('chat_shared_files'); ?>" data-placement="left" class="fa fa-share-alt" id="shared_user_files" viewBox="0 0 24 24">
            <path d="M13.5,8H12V13L16.28,15.54L17,14.33L13.5,12.25V8M13,3A9,9 0 0,0 4,12H1L4.96,16.03L9,12H6A7,7 0 0,1 13,5A7,7 0 0,1 20,12A7,7 0 0,1 13,19C11.07,19 9.32,18.21 8.06,16.94L6.64,18.36C8.27,20 10.5,21 13,21A9,9 0 0,0 22,12A9,9 0 0,0 13,3" />
          </svg>
          <a href="" id="fa-skype" data-toggle="tooltip" data-container="body" class="mright5" title="<?php echo _l('chat_call_on_skype'); ?>"><i class="fa fa-skype" aria-hidden="true"></i></a>
          <a href="" id="fa-facebook" target="_blank" class="mright5"><i class="fa fa-facebook" aria-hidden="true"></i></a>
          <a href="" id="fa-linkedin" target="_blank" class="mright5"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
        </div>
      </div>
      <div class="messages" onscroll="loadMessages(this)">
        <svg class="message_loader" viewBox="0 0 50 50">
          <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
        </svg>
        <span class="userIsTyping bounce" id="">
          <img src="<?php echo module_dir_url('prchat', 'assets/chat_implements/userIsTyping.gif'); ?>" />
        </span>
        <ul>
        </ul>
      </div>
      <div class="group_messages" onscroll="loadGroupMessages(this)">
        <svg class="message_group_loader" viewBox="0 0 50 50">
          <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
        </svg>
        <div class="chat_group_messages">
          <ul>
          </ul>
        </div>
      </div>
      <?php if (isClientsEnabled()) : ?>
        <div class="client_messages" id="">
          <svg class="message_loader" viewBox="0 0 50 50">
            <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
          </svg>
          <span class="userIsTyping bounce" id="">
            <img src="<?php echo module_dir_url('prchat', 'assets/chat_implements/userIsTyping.gif'); ?>" />
          </span>
          <div class="chat_client_messages">
            <!-- Client messages -->
            <ul>
            </ul>
          </div>
        </div>
      <?php endif; ?>
      <!-- Groups -->
      <form hidden enctype="multipart/form-data" name="fileForm" method="post" onsubmit="uploadFileForm(this);return false;">
        <input type="file" class="file" name="userfile" required />
        <input type="submit" name="submit" class="save" value="save" />
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
      </form>
      <form method="post" enctype="multipart/form-data" name="pusherMessagesForm" id="pusherMessagesForm" onsubmit="return false;">
        <div class="message-input">
          <div class="wrap">
            <textarea type="text" disabled name="msg" class="chatbox ays-ignore" placeholder="<?= _l('chat_type_a_message'); ?>"></textarea>
            <input type="hidden" class="ays-ignore from" name="from" value="" />
            <input type="hidden" class="ays-ignore to" name="to" value="" />
            <input type="hidden" class="ays-ignore typing" name="typing" value="false" />
            <input type="hidden" class="ays-ignore" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
            <i class="fa fa-file-image-o attachment fileUpload" data-container="body" data-toggle="tooltip" title="<?php echo _l('chat_file_upload'); ?>" aria-hidden="true"></i>
            <svg class="search_messages" viewBox="0 0 24 24">
              <path d="M15.5,12C18,12 20,14 20,16.5C20,17.38 19.75,18.21 19.31,18.9L22.39,22L21,23.39L17.88,20.32C17.19,20.75 16.37,21 15.5,21C13,21 11,19 11,16.5C11,14 13,12 15.5,12M15.5,14A2.5,2.5 0 0,0 13,16.5A2.5,2.5 0 0,0 15.5,19A2.5,2.5 0 0,0 18,16.5A2.5,2.5 0 0,0 15.5,14M5,3H19C20.11,3 21,3.89 21,5V13.03C20.5,12.23 19.81,11.54 19,11V5H5V19H9.5C9.81,19.75 10.26,20.42 10.81,21H5C3.89,21 3,20.11 3,19V5C3,3.89 3.89,3 5,3M7,7H17V9H7V7M7,11H12.03C11.23,11.5 10.54,12.19 10,13H7V11M7,15H9.17C9.06,15.5 9,16 9,16.5V17H7V15Z" />
            </svg>
            <input type="hidden" class="ays-ignore has_newmessages" id="" value="false" />
            <button class="submit enterBtn" name="enterBtn"><svg class="fa-paper-plane" fill="#ffffff" viewBox="0 0 24 24">
                <path d="M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22A10,10 0 0,1 2,12A10,10 0 0,1 12,2M8,7.71V11.05L15.14,12L8,12.95V16.29L18,12L8,7.71Z" /></svg></button>
          </div>
        </div>
      </form>
      <!-- Groups -->
      <form hidden enctype="multipart/form-data" name="groupFileForm" id="groupFileForm" method="post" onsubmit="uploadGroupFileForm(this);return false;">
        <input type="file" class="file" name="userfile" required />
        <input type="submit" name="submit" class="save" value="save" />
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
      </form>
      <form hidden method="post" enctype="multipart/form-data" name="groupMessagesForm" id="groupMessagesForm" onsubmit="return false;">
        <div class="message-input group_msg_input">
          <div class="wrap">
            <textarea type="text" name="g_message" class="group_chatbox ays-ignore mention" placeholder="<?= _l('chat_type_a_message_mention'); ?>"></textarea>
            <input type="hidden" class="ays-ignore from" name="from" value="" />
            <input type="hidden" class="ays-ignore typing" name="typing" value="false" />
            <input type="hidden" class="ays-ignore" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
            <i class="fa fa-file-image-o attachment groupFileUpload" data-container="body" data-toggle="tooltip" title="<?php echo _l('chat_file_upload'); ?>" aria-hidden="true"></i>
            <button class="submit enterGroupBtn" name="enterGroupBtn"><svg class="fa-paper-plane" fill="#ffffff" viewBox="0 0 24 24">
                <path d="M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22A10,10 0 0,1 2,12A10,10 0 0,1 12,2M8,7.71V11.05L15.14,12L8,12.95V16.29L18,12L8,7.71Z" /></svg></button>
          </div>
        </div>
      </form>
      <!-- Clients -->
      <form hidden enctype="multipart/form-data" name="clientFileForm" id="clientFileForm" method="post" onsubmit="uploadClientFileForm(this);return false;">
        <input type="file" class="file" name="userfile" required />
        <input type="submit" name="submit" class="save" value="save" />
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
      </form>
      <form hidden method="post" enctype="multipart/form-data" name="clientMessagesForm" id="clientMessagesForm" onsubmit="return false;">
        <div class="message-input client_msg_input">
          <div class="wrap">
            <textarea type="text" name="client_message" class="client_chatbox ays-ignore" placeholder="<?= _l('chat_type_a_message'); ?>"></textarea>
            <input type="hidden" class="ays-ignore from" name="from" value="staff_" />
            <input type="hidden" class="ays-ignore to" name="to" value="client_" />
            <input type="hidden" class="ays-ignore typing" name="typing" value="false" />
            <input type="hidden" class="ays-ignore" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
            <i class="fa fa-file-image-o attachment clientFileUpload" data-container="body" data-toggle="tooltip" title="<?php echo _l('chat_file_upload'); ?>" aria-hidden="true"></i>
            <svg class="search_client_messages" viewBox="0 0 24 24">
              <path d="M15.5,12C18,12 20,14 20,16.5C20,17.38 19.75,18.21 19.31,18.9L22.39,22L21,23.39L17.88,20.32C17.19,20.75 16.37,21 15.5,21C13,21 11,19 11,16.5C11,14 13,12 15.5,12M15.5,14A2.5,2.5 0 0,0 13,16.5A2.5,2.5 0 0,0 15.5,19A2.5,2.5 0 0,0 18,16.5A2.5,2.5 0 0,0 15.5,14M5,3H19C20.11,3 21,3.89 21,5V13.03C20.5,12.23 19.81,11.54 19,11V5H5V19H9.5C9.81,19.75 10.26,20.42 10.81,21H5C3.89,21 3,20.11 3,19V5C3,3.89 3.89,3 5,3M7,7H17V9H7V7M7,11H12.03C11.23,11.5 10.54,12.19 10,13H7V11M7,15H9.17C9.06,15.5 9,16 9,16.5V17H7V15Z" />
            </svg>
            <input type="hidden" class="ays-ignore invisibleUnread" value="" />
            <button class="submit enterClientBtn" name="enterClientBtn"><svg class="fa-paper-plane" fill="#ffffff" viewBox="0 0 24 24">
                <path d="M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22A10,10 0 0,1 2,12A10,10 0 0,1 12,2M8,7.71V11.05L15.14,12L8,12.95V16.29L18,12L8,7.71Z" /></svg></button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <div class="modal_container"></div>
  <?php init_tail(); ?>
  <!-- Include chat settings file -->
  <?php require('modules/prchat/assets/module_includes/chat_settings.php'); ?>

  <!-- Include chat settings file -->
  <?php require('modules/prchat/assets/module_includes/chat_statuses.php'); ?>

  <!-- Include various mutual functions file -->
  <?php require('modules/prchat/assets/module_includes/mutual_and_helper_functions.php'); ?>

  <script>
    'use strict';
    if (localStorage.chat_theme_name) {
      $('body').addClass('chat_' + localStorage.chat_theme_name);
    }

    window.addEventListener('online', handleConnectionChange);
    window.addEventListener('offline', handleConnectionChange);

    monitorWindowActivity();

    /*---------------* Main first thing get users/staff from database *---------------*/
    var users = $.get(prchatSettings.usersList);

    var offsetPush = 0;
    var groupOffsetPush = 0;
    var endOfScroll = false;
    var groupEndOfScroll = false;
    var friendUsername = '';
    var unreadMessages = '';
    var pusherKey = "<?= get_option('pusher_app_key') ?>";
    var appCluster = "<?= get_option('pusher_cluster') ?>";
    var staffFullName = "<?= get_staff_full_name(); ?>";
    var userSessionId = "<?= get_staff_user_id(); ?>";
    var isAdmin = app.user_is_admin;
    var staffCanCreateGroups = "<?= get_option('chat_members_can_create_groups'); ?>";
    var checkforNewMessages = prchatSettings.getUnread;
    var chat_desktop_notifications_enabled = "<?php echo get_option('chat_desktop_messages_notifications') ?>";
    chat_desktop_notifications_enabled = (chat_desktop_notifications_enabled == '0') ? false : true;
    var user_chat_status = "<?= get_user_chat_status(); ?>";

    if (staffCanCreateGroups === '0' && !isAdmin) {
      $('#add_group_btn').remove();
    }

    /*---------------* Handles input form sending *---------------*/
    $('#frame').on('click', '.fileUpload', function() {
      $('#frame').find('form[name="fileForm"] input:first').click();
    });

    $('#frame').on('click', '.groupFileUpload', function() {
      $('#frame').find('form[name="groupFileForm"] input:first').click();
    });

    $('#frame').on('change', 'input[type=file]', function() {
      $(this).parent('form').submit();
    });

    // Handles file form upload  for staff to staff
    function uploadFileForm(form) {
      var formData = new FormData();
      var fileForm = $(form).children('input[type=file]')[0].files[0];
      var sentTo = $('li.contact.active').attr('id');
      var token_name = $(form).children('input[name=csrf_token_name]').val();
      var formId = $(form).attr('id');

      formData.append('userfile', fileForm);
      formData.append('send_to', sentTo);
      formData.append('send_from', userSessionId);
      formData.append('csrf_token_name', token_name);

      $.ajax({
        type: 'POST',
        url: prchatSettings.uploadMethod,
        data: formData,
        dataType: 'json',
        processData: false,
        contentType: false,
        beforeSend: function() {
          if ($('.chat-module-loader').length == 0) {
            $('.content').prepend('<div class="chat-module-loader"><div></div><div></div><div></div></div>');
          } else {
            $('.content .chat-module-loader').fadeIn();
          }
          var Regex = new RegExp('\[~%:\()@]');
          if (Regex.test(fileForm.name)) {
            alert_float('warning', '<?php echo _l('chat_permitted_files') ?>');
            $('.content .chat-module-loader').remove();
            return false;
          }
        },
        success: function(r) {
          if (!r.error) {
            var uploadSend = $.Event("keypress", {
              which: 13
            });
            var basePath = "<?php echo base_url('modules/prchat/uploads/'); ?>";
            $('#frame textarea.chatbox').val(basePath + r.upload_data.file_name);
            setTimeout(function() {
              if ($('#frame textarea.chatbox').trigger(uploadSend)) {
                alert_float('info', 'File ' + r.upload_data.file_name + ' sent.');
                $('.content .chat-module-loader').fadeOut();
              }
            }, 100);
            getSharedFiles(userSessionId, sentTo);
          } else {
            $('.content .chat-module-loader').fadeOut();
            alert_float('danger', r.error);
          }
        }
      });
      $('form#' + formId).trigger("reset");
    }

    /*---------------* Check for messages history and append to main chat window *---------------*/
    function loadMessages(el) {
      var pos = $(el).scrollTop();
      var id = $(el).attr("id");
      var to = $('#contacts ul li.contact').children('a.active_chat').attr('id');
      var from = userSessionId;

      if (pos == 0 && offsetPush >= 10) {
        $('#frame .messages').find('.message_loader').show();

        $.get(prchatSettings.getMessages, {
            from: from,
            to: to,
            offset: offsetPush,
          })
          .done(function(message) {
            message = JSON.parse(message);
            if (Array.isArray(message) == false) {
              endOfScroll = true;
              $('#frame .messages').find('.message_loader').hide();
              if ($(el).hasScrollBar() && endOfScroll == true) {
                prchat_setNoMoreMessages();
              }
            } else {
              offsetPush += 10;
            }
            $(message).each(function(i, value) {

              if (message[i].time_sent !== undefined && message[i].time_sent !== 'undefined') {
                var previous_time = moment(message[i].time_sent).format('YYYY-MM-DD HH');

                if (message[i + 1] !== undefined) {
                  var current_time = moment(message[i + 1].time_sent).format('YYYY-MM-DD HH');
                }
              }

              value.message = emojify.replace(value.message);
              var element = $('.messages#id_' + to).find('ul');
              if (value.is_deleted == 1) {
                value.message = '<span>' + prchatSettings.messageIsDeleted + '</span>';
              } else {
                value.message = emojify.replace(value.message);
              }

              if (value.reciever_id == from) {
                element.prepend('<li class="replies"><img class="friendProfilePic" src="' + fetchUserAvatar(value.sender_id, value.user_image) + '" data-toggle="tooltip" data-container="body" data-placement="right" title="' + value.time_sent_formatted + '"/><p class="friend">' + value.message + '</p></li>');
              } else {
                element.prepend('<li class="sent" id="' + value.id + '"><img class="myProfilePic" src="' + fetchUserAvatar(value.sender_id, value.user_image) + '" data-toggle="tooltip" data-container="body" data-placement="left" title="' + value.time_sent_formatted + '"/><p class="you" id="msg_' + value.id + '">' + value.message + '</p></li>');
                <?php if ($chat_delete_option == '1' || is_admin()) :  ?>
                  if (value.is_deleted == 0) {
                    $('#msg_' + value.id).tooltipster({
                      content: $("<span id='" + value.id + "' class='prchat_message_delete' ontouchstart='delete_chat_message(this)' onClick='delete_chat_message(this)'>" + prchatSettings.deleteChatMessage + "</span>"),
                      interactive: true,
                      side: 'left'
                    });
                  }
                <?php endif; ?>
              }
              if (message[i + 1] !== undefined) {
                if (previous_time !== current_time) {
                  $('<span class="middleDateTime">' + moment(value.time_sent).format('llll') + '</span>').prependTo($('.messages ul li#' + value.id).parents('ul'));
                }
              }
            });
            if (endOfScroll == false) {
              $(el).scrollTop(200);
              $('#frame .messages').find('.message_loader').hide();
            }
          });
        activateLoader();
      }
    }

    /*---------------* Put prchatSettings.debug for debug mode for Pusher *---------------*/
    if (prchatSettings.debug) {
      try {
        Pusher.log = function(message) {
          if (window.console && window.console.log) {
            window.console.log(message);
          }
        };
      } catch (e) {
        if (e instanceof ReferenceError) {
          alert_float('danger', e);
        }
      }
    }


    /*---------------* Init pusher library, and register *---------------*/
    var pusher = new Pusher(pusherKey, {
      authEndpoint: prchatSettings.pusherAuthentication,
      authTransport: 'jsonp',
      'cluster': appCluster,
      disableStats: true,
      auth: {
        headers: {
          'X-CSRF-Token': (typeof csrfData == 'undefined') ? '' : csrfData.formatted.csrf_token_name, // CSRF token
        }
      }
    });

    /*---------------* Pusher Trigger accessing channel *---------------*/
    var presenceChannel = pusher.subscribe('presence-mychanel');
    var chat_status = pusher.subscribe('user_changed_chat_status');
    var groupChannels = pusher.subscribe('group-chat');

    pusher.config.unavailable_timeout = 5000;
    pusher.connection.bind('state_change', function(states) {
      var prevState = states.previous;
      var currState = states.current;
      var conn_tracker = $('.connection_field');
      if (currState == 'unavailable') {
        conn_tracker.fadeIn();
        conn_tracker.children('i.fa-wifi').fadeIn();
        conn_tracker.css('background', '#f03d25');
      } else if (currState == 'connected') {
        if (conn_tracker.is(':visible')) {
          conn_tracker.children('i.fa-wifi').removeClass('blink');
          conn_tracker.css('background', '#04cc04', function() {
            conn_tracker.fadeOut(2000);
          });
        }
      }
    });

    /*---------------* Pusher Trigger subscription succeeded *---------------*/
    presenceChannel.bind('pusher:subscription_succeeded', function(members) {
      chatMemberUpdate(members);
      var redirect_staff_id = localStorage.staff_to_redirect;
      users.then(function() {
        if (localStorage.touchClientsTab) {
          $('li.crm_clients a').click();
          localStorage.touchClientsTab = '';
        }
        if (redirect_staff_id != '') {
          $('.chat_nav li.staff a').trigger('click');
          $('#contacts a#' + redirect_staff_id).trigger('click');
          localStorage.staff_to_redirect = '';
        } else {
          setTimeout(function() {
            if (!window.matchMedia("only screen and (max-width: 735px)").matches) {
              $('#frame #sidepanel ul.nav.nav-tabs li.staff.active a').click();
            }
          }, 600);
        }
      });
    });

    /*---------------* Pusher Trigger user connected *---------------*/
    presenceChannel.bind('pusher:member_added', function(member) {
      addChatMember(member);
      if (member.info.status == '') {
        member.info.status = 'online';
      }
      if (member.info.status != '') {
        var userPlaceholder = $('body').find('.chat_contacts_list li a#' + member.id + ' .wrap img');
        userPlaceholder.attr('title', strCapitalize(member.info.status)).attr('data-original-title', strCapitalize(member.info.status));
        userPlaceholder.removeClass();
        userPlaceholder.addClass('imgFriend ' + member.info.status + '');
        $('body').find('.chat_contacts_list li a#' + member.id + ' .wrap span').removeClass().addClass(member.info.status);
      }

      if (member.info.justLoggedIn) {
        var message_selector = $('#contacts .contact a#' + member.id).find('.wrap .meta .preview');
        var old_message_content = message_selector.html();
        message_selector.html('<strong class="contact_role">' + member.info.name + "<?php echo _l('chat_user_is_online'); ?>" + '</strong>');
        setTimeout(function() {
          message_selector.html(old_message_content);
        }, 7000);
        $.notify('', {
          'title': app.lang.new_notification,
          'body': member.info.name + ' ' + prchatSettings.hasComeOnlineText,
          'requireInteraction': true,
          'icon': $('#header').find('img').attr('src'),
          'tag': 'user-join-' + member.id,
          'closeTime': app.options.dismiss_desktop_not_after != "0" ? app.options.dismiss_desktop_not_after * 1000 : null
        });
      }
    });

    /*---------------* Pusher Trigger user logout *---------------*/
    presenceChannel.bind('pusher:member_removed', function(members) {
      removeChatMember(members);
    });

    var pendingRemoves = [];
    /*---------------* New chat members tracking / removing *---------------*/
    function addChatMember(member) {
      var pendingRemoveTimeout = pendingRemoves[member.id];
      $('a#' + member.id + ' .wrap span').addClass('online').removeClass('offline');
      if (presenceChannel.members.count > 0) {
        if (!$('.liveUsers').length) {
          $("#menu .menu-item-prchat span.menu-text").append('<span class="liveUsers badge menu-badge bg-info" data-toggle="tooltip" title="' + prchatSettings.onlineUsersMenu + '">' + (' ' + presenceChannel.members.count - 1) + '</span>');
        } else {
          $('.liveUsers').html(presenceChannel.members.count - 1);
        }
      }
      if (member.info.justLoggedIn == true) {
        appendMemberToTop(member.id);
      } else {
        if ($('#contacts li.contact#' + member.id).find('.unread-notifications').attr('data-badge') != 0) {
          appendMemberToTop(member.id);
        }
      }
      if (pendingRemoveTimeout) {
        clearTimeout(pendingRemoveTimeout);
      }
    }

    /*---------------* New chat members tracking / removing *---------------*/
    function removeChatMember(members) {
      pendingRemoves[members.id] = setTimeout(function() {
        if (presenceChannel.members.count > 0) {
          $('.liveUsers').remove();
          $("#menu .menu-item-prchat span.menu-text").append('<span class="liveUsers badge menu-badge bg-info" data-toggle="tooltip" title="' + prchatSettings.onlineUsersMenu + '">' + (presenceChannel.members.count - 1) + '</span>');
        }
        $('a#' + members.id + ' .wrap span').addClass('online').removeClass('offline');
        chatMemberUpdate(members);
      }, 5000);
    }

    /*---------------* Append member to top of sidebar after logged in *---------------*/
    function appendMemberToTop(member) {
      var $cloned = $('#contacts li.contact#' + member).clone();
      $('#contacts li.contact#' + member).remove();
      $cloned.prependTo('#contacts ul')
    }

    /*---------------* Bind the 'send-event' & update the chat box message log *---------------*/
    presenceChannel.bind('send-event', function(data) {

      if (data.global) {
        data.message = "<?= '<strong>' . _l('chat_message_announce') . '</strong>'; ?>" + data.message;
      }
      $('#frame .messages').find('span.userIsTyping').fadeOut(500);
      if (data.last_insert_id) {
        $('.messages').find('li.sent .you#' + userSessionId).attr('id', 'msg_' + data.last_insert_id)
        $('.messages').find('li.sent#' + userSessionId).attr('id', data.last_insert_id)
      }
      <?php if ($chat_delete_option == '1' || is_admin()) :  ?>
        $('li#' + data.last_insert_id + ' #msg_' + data.last_insert_id).tooltipster({
          content: $("<span id='" + data.last_insert_id + "' class='prchat_message_delete' ontouchstart='delete_chat_message(this)' onClick='delete_chat_message(this)'>" + prchatSettings.deleteChatMessage + "</span>"),
          interactive: true,
          side: 'left'
        });
      <?php endif; ?>

      if (presenceChannel.members.me.id == data.to && data.from != presenceChannel.members.me.id) {
        $('.has_newmessages').val('true').attr('id', data.from);
        data.message = createTextLinks_(emojify.replace(data.message));
        $('.messages#id_' + data.from + ' ul').append('<li class="replies"><img class="friendProfilePic" src="' + fetchUserAvatar(data.from, data.sender_image) + '"/><p class="friend">' + data.message + '</p></li>');
        $('#contacts .contact a#' + data.from).find('.wrap .meta .preview').html(data.message);
        $('#contacts .contact a#' + data.from).find('.wrap .meta .pull-right.time_ago').html(moment().format('hh:mm A'));

        if (user_chat_status != 'busy' && user_chat_status != 'offline') {
          initUserSound(data);
        }

        if ($('.messages').hasScrollBar()) {
          scroll_event();
        }
      }

      if (presenceChannel.members.me.id == data.to) {
        scroll_event();
        var old_data = emojify.replace(data.message);
        data.message = escapeHtml(data.message);

        var firstname = presenceChannel.members.members[data.from].name.replace(/ .*/, '');

        if (data.message.includes('class="prchat_convertedImage"')) {
          data.message = '<p class="tb">' + firstname + ' ' + '<?php echo _l('chat_new_file_uploaded'); ?></p>';
        }

        if (data.message.includes('data-lity target="blank" href')) {
          data.message = '<p class="tb">' + firstname + ' ' + '<?php echo _l('chat_new_link_shared'); ?></p>';
        }

        var truncated_message = '';
        if (old_data.includes('emoji') && !old_data.includes('href')) {
          $('#contacts .contact a#' + data.from).find('.wrap .meta .preview').html(old_data);
          scroll_event();
          return false;
        }

        if (!data.message.includes('class="tb"')) {
          truncated_message = data.message.trunc(36);
        } else {
          truncated_message = data.message.trunc(46);
        }

        if ($(window).width() > 733) {
          $('#contacts .contact a#' + data.from).find('.unread-notifications').hide();
        }
        $('#contacts .contact a#' + data.from).find('.wrap .meta .preview').html(truncated_message);
      }

    });

    /*---------------* Detect when a user is typing a message *---------------*/
    presenceChannel.bind('typing-event', function(data) {
      if (
        presenceChannel.members.me.id == data.to &&
        data.from != presenceChannel.members.me.id &&
        data.message == 'true'
      ) {
        $('#frame .messages')
          .find('span.userIsTyping#' + data.from)
          .fadeIn(500);
      } else if (
        presenceChannel.members.me.id == data.to &&
        data.from != presenceChannel.members.me.id &&
        data.message == 'null'
      ) {
        $('#frame .messages')
          .find('span.userIsTyping#' + data.from)
          .fadeOut(500);
      }
    });

    /*---------------* Trigger notification popup increment and live notification *---------------*/
    presenceChannel.bind('notify-event', function(data) {
      if (chat_desktop_notifications_enabled) {
        if (data.from !== userSessionId && data.to == userSessionId) {
          if (user_chat_status != 'busy' && user_chat_status != 'offline') {
            $.notify('', {
              'title': data.from_name,
              'body': data.message,
              'requireInteraction': false,
              'icon': fetchUserAvatar(data.from, data.sender_image),
              'tag': 'user-message-' + data.from,
              'closeTime': app.options.dismiss_desktop_not_after != "0" ? app.options.dismiss_desktop_not_after * 1000 : null
            });
          }
        }
      }

      if ($(window).width() < 733) {
        if (presenceChannel.members.me.id == data.to && data.from != presenceChannel.members.me.id) {
          var notiBox = $('body').find('li.contact#' + data.from + ' a#' + data.from);
          if (!$(notiBox).hasClass("active_chat")) {
            $(notiBox).find('img').addClass('shaking');
            var notification = parseInt($(notiBox).find('.unread-notifications#' + data.from).attr('data-badge'));
            var badge = $(notiBox).find('.unread-notifications#' + data.from);
            badge.attr('data-badge', notification + 1);
            $(notiBox).find('.unread-notifications#' + data.from).show();
          }
          delay(function() {
            $(notiBox).find('img').removeClass('shaking');
          }, 600);
        }
      }
    });

    /*---------------* On click send message button trigger post message *---------------*/
    $('body').on('click', '.enterBtn, .enterGroupBtn, .enterClientBtn, .fa-paper-plane', function(e) {
      var eventEnter = $.Event("keypress", {
        which: 13
      });

      var targetName = '';
      if (e.currentTarget.getAttribute('name') !== null) {
        targetName = e.currentTarget.getAttribute('name');
      }
      // Groups
      if (targetName == '') {
        targetName = e.currentTarget.parentNode.getAttribute('name')
      }
      if (targetName == 'enterBtn') {
        $('#frame').find('.chatbox').trigger(eventEnter);
        $('.chatbox').focus();
      } else if (targetName == 'enterGroupBtn') {
        $('#frame').find('.group_chatbox').trigger(eventEnter);
        $('.group_chatbox').focus();
      } else if (targetName == 'enterClientBtn') {
        $('#frame').find('.client_chatbox').trigger(eventEnter);
        $('.client_chatbox').focus();
      }
    });

    /*---------------* chatMemberUpdate() place & update users on user page, unread messages notifications *---------------*/
    function chatMemberUpdate() {
      users.then(function(data) {
        var offlineUser = '';
        var onlineUser = '';
        data = JSON.parse(data);
        if (Object.keys(data).length > 1) {
          $('#frame .nav.nav-tabs li.groups, #frame .nav.nav-tabs li.groups a, #frame .nav.nav-tabs li.crm_clients a').removeClass('events_disabled');
        } else {
          $('.content .messages').html('<h3 class="text-center">No staff users with valid permissions found, try adding new users or (Grant Chat Access) to existing staff users.<br><br> To manage staff user permissions for chat navigate in sidemenu <strong>Setup->Staff</strong> select specific staff member and click Permissions and scroll down to Chat Module to assign chat access permissions, or disable In chat view show only users with chat permissions (also applies on client side) option in <strong>Setup->Settings->Perfex Chat Settings</strong><br><br> Administrators will not need any permissions.</h3>');
          $('.message-input').remove();
          return false;
        }
        $('.chatbox').prop('disabled', '');
        $.each(data, function(user_id, value) {
          if (value.role == null) {
            value.role = '<?= _l("als_staff"); ?>';
          }
          if (value.staffid != presenceChannel.members.me.id) {
            var user = presenceChannel.members.get(value.staffid);

            if (value.message == undefined) value.message = prchatSettings.sayHiText + ' ' + strCapitalize(value.firstname + ' ' + value.lastname);

            if (value.time_sent_formatted == undefined) value.time_sent_formatted = '';

            var user_status = (value.status != undefined || value.status == '') ? value.status : 'online';

            var translated_status = '';
            for (var status in chat_user_statuses) {
              if (status == user_status) {
                translated_status = chat_user_statuses[status];
              }
            }
            if (user != null) {
              onlineUser += '<li class="contact" id="' + value.staffid + '" data-toggle="tooltip" data-container="body" title="<?php echo _l('chat_user_active_now'); ?>">';
              onlineUser += '<a href="#' + value.staffid + '" id="' + value.staffid + '" class="on"><div class="wrap"><span class="online ' + user_status + '"></span>';
              onlineUser += '<img data-toggle="tooltip" title="' + translated_status + '" src="' + fetchUserAvatar(value.staffid, value.profile_image) + '" class="imgFriend ' + user_status + '" />';
              onlineUser += '<div class="meta"><p role="' + value.role + '" class="name">' + strCapitalize(value.firstname + ' ' + value.lastname) + '</p>';
              onlineUser += '<social_info skype="' + value.skype + '" facebook="' + value.facebook + '" linkedin="' + value.linkedin + '"></social_info>';
              onlineUser += '<p class="preview">' + value.message + '</p><p class="pull-right time_ago">' + value.time_sent_formatted + '</p></div></div>';
              onlineUser += '<span class="unread-notifications" id="' + value.staffid + '" data-badge="0"></span></a></li>';

              if (presenceChannel.members.count > 0) {
                $('.liveUsers').remove();
                $("#menu .menu-item-prchat span.menu-text").append('<span class="liveUsers badge menu-badge bg-info" data-toggle="tooltip" title="' + prchatSettings.onlineUsersMenu + '">' + (' ' + presenceChannel.members.count - 1) + '</span>');
              }
            } else {
              offlineUser += '<li class="contact" id="' + value.staffid + '"';
              var lastLoginText = '';
              if (value.last_login) {
                lastLoginText = moment(value.last_login, "YYYYMMDD h:mm:ss").fromNow();
              } else {
                lastLoginText = 'Never';
              }
              offlineUser += ' data-toggle="tooltip" data-container="body" title="<?php echo _l('chat_last_seen'); ?>: ' + lastLoginText + '">';
              offlineUser += '<a href="#' + value.staffid + '" id="' + value.staffid + '" class="off"><div class="wrap"><span class="offline"></span>';
              offlineUser += '<img data-toggle="tooltip" title="' + strCapitalize('offline') + '" src="' + fetchUserAvatar(value.staffid, value.profile_image) + '" class="imgFriend" /><div class="meta"><p role="' + value.role + '" class="name">' + strCapitalize(value.firstname + ' ' + value.lastname) + '</p>';
              offlineUser += '<p class="preview">' + value.message + '</p><p class="pull-right time_ago">' + value.time_sent_formatted + '</p><social_info skype="' + value.skype + '" facebook="' + value.facebook + '" linkedin="' + value.linkedin + '"></social_info>';
              offlineUser += '</div></div><span class="unread-notifications" id="' + value.staffid + '" data-badge="0"></span></a></li>';
            }
          }
        });
        $('#frame #contacts ul').html('');
        $('#frame #contacts ul').prepend(onlineUser + offlineUser);

        var newUnreadMessages = JSON.parse(checkforNewMessages);
        if (!checkforNewMessages.includes('false')) {
          $.each(newUnreadMessages, function(i, sender) {
            notifications = $('#contacts li a#' + sender.sender_id).find('.unread-notifications#' + sender.sender_id);
            if (notifications.length) {
              notifications.attr('data-badge', sender.count_messages);
              notifications.show();
            }
          });
        }
        return false;
      });
    }

    /*---------------* Trigger click on user & create chat box and check for messages *---------------*/
    $('#frame #contacts .chat_contacts_list').on("click", "li.contact a", function(event) {
      animateContent();
      var obj = $(this);
      var id = obj.attr('id').replace('id_', '');
      var contact_selector = $('#contacts a#' + id);

      // Handle unread messages
      if ($('.has_newmessages').attr('id') == id && $('.has_newmessages').val() == 'true' ||
        $(this).find('.unread-notifications#' + id).attr('data-badge') > 0) {
        updateLatestMessages(id);
      }

      $('.has_newmessages').val('false').attr('id', '');

      $('.group_members_inline').remove();

      var currentSoundMembers = JSON.parse(localStorage.getItem("soundDisabledMembers"));
      (currentSoundMembers.includes(id)) ?
      $('.user_sound_icon').removeClass('fa-volume-up').addClass('fa-volume-off'): $('.user_sound_icon').removeClass('fa-volume-off').addClass('fa-volume-up');


      var contact_image = $('#frame .contact-profile img.staff-profile-image-small');
      if (contact_image.is(':hidden')) {
        contact_image.show();
      }
      endOfScroll = false;
      offsetPush = 0;
      $('#frame .chatbox').val('');

      $('#contacts li a').removeClass('active_chat');

      $('#contacts .contact').removeClass('active');

      contact_selector.parent('.contact').addClass('active');

      $(this).addClass('active_chat');

      if (contact_selector.parent('.contact').find('.tb')) {
        contact_selector.parent('.contact').find('.tb').css({
          'font-weight': 'normal',
          'color': 'rgba(153, 153, 153, 1)'
        });
      }

      createChatBox(obj);

      if ($('#search_field').val() !== '') {
        clearSearchValues();
      }

      if ($(this).find('.unread-notifications#' + id).attr('data-badge') > 0) {
        updateUnreadMessages($(this));
        setTimeout(function() {
          obj.find('.unread-notifications#' + id).attr('data-badge', '0').hide();
        }, 1000);
      }
    });

    /*---------------* Creating chat box from the html template to the DOM *---------------*/
    var createChatBoxRequest = null;

    function createChatBox(obj) {
      $('.messages ul').html('');
      var id = obj.attr('href');
      var fullName = obj.find('.meta').children('p:first-child').text();
      var contactRole = obj.find('.meta').children('p:first-child').attr('role');

      var contact_id = id.replace("#", "");
      id = id.replace("#", "id_");
      $('.messages').find('span.userIsTyping').attr('id', contact_id);

      $('#frame .content .contact-profile p').html(fullName + '<br><a target="_blank" href="' + site_url + 'admin/profile/' + contact_id + '"><small class="contact_role"></small></a>');
      $('#frame .content .contact-profile .user_sound_icon').attr('data-sound_user_id', contact_id);
      $('.group_members_inline').remove();

      checkContactRole(contactRole);

      var currentActiveChatWindow = obj.hasClass('active');

      var dfd = $.Deferred();
      var promise = dfd.promise();

      if (!currentActiveChatWindow) {
        if (createChatBoxRequest) {
          createChatBoxRequest.abort();
        }

        createChatBoxRequest = $.get(prchatSettings.getMessages, {
            from: userSessionId,
            to: contact_id,
            offset: 0,
            limit: 20
          })
          .done(function(r) {
            offsetPush = 10;

            r = JSON.parse(r);

            var message = r;

            offsetPush += 10;
            dfd.resolve(message);

          }).always(function() {
            if ($("#no_messages").length) {
              $("#no_messages").remove();
            }
            createChatBoxRequest = null;
          });
      } else {
        dfd.resolve([]);
      }

      /*---------------* After users are fetched from database -> continue with loading *---------------*/
      promise.then(function(message) {
        var sliderimg = obj.find('img').prop("currentSrc");
        $('#frame .content .contact-profile img').prop("src", sliderimg);

        $('#pusherMessagesForm').attr('id', id);
        $('.messages#' + id).parent('.content').find('.to:hidden').val(id.replace("id_", ""));
        $('.messages#' + id).parent('.content').find('.from:hidden').val(userSessionId);

        $(message).each(function(i, value) {

          var previous_time = moment(message[i].time_sent).format('YYYY-MM-DD HH');
          if (message[i + 1] !== undefined) {
            var current_time = moment(message[i + 1].time_sent).format('YYYY-MM-DD HH');
          }

          if (value.message.startsWith("<?= _l('chat_message_announce'); ?>")) {
            value.message = '<strong class="italic">' + value.message + '</strong>';
          }

          if (value.is_deleted == 1) {
            value.message = '<span>' + prchatSettings.messageIsDeleted + '</span>';
          } else {
            value.message = emojify.replace(value.message);
          }

          if (value.sender_id == userSessionId) {
            $('.messages ul').prepend('<li class="sent" id="' + value.id + '"><img data-toggle="tooltip" data-container="body" data-placement="left" title="' + value.time_sent_formatted + '" class="myProfilePic" src="' + fetchUserAvatar(userSessionId, value.user_image) + '"/><p class="you" id="msg_' + value.id + '">' + value.message + '</p></li>');

            if (previous_time !== current_time) {
              $('<span class="middleDateTime">' + moment(value.time_sent).format('llll') + '</span>').prependTo($('.messages ul li#' + value.id).parents('ul'));
            }

            <?php if ($chat_delete_option == '1' || is_admin()) :  ?>
              if (value.is_deleted == 0) {
                $('#msg_' + value.id).tooltipster({
                  content: $("<span id='" + value.id + "' class='prchat_message_delete' ontouchstart='delete_chat_message(this)' onClick='delete_chat_message(this)'>" + prchatSettings.deleteChatMessage + "</span>"),
                  interactive: true,
                  side: 'left'
                });
              }
            <?php endif; ?>

          } else {
            $('.messages ul').prepend('<li class="replies"><img data-toggle="tooltip" data-container="body" data-placement="right" title="' + value.time_sent_formatted + '" class="friendProfilePic" src="' + fetchUserAvatar(value.sender_id, value.user_image) + '"/><p  class="friend">' + value.message + '</p></li>');
          }
        });
        $('.group_members_inline').remove();
      });
      fillSocialIconsData(obj);
      $('.messages').attr('id', id);

      activateLoader(promise);

      $.when(promise.then())
        .then(function() {
          if ($(".messages").hasScrollBar() && $(window).width() > 733) {
            scroll_event();
            $('.message-input textarea.chatbox').focus();
          } else if ($(window).width() < 733) {
            // Due to mobile devices bug and loading time
            scroll_event();
            scroll_event();
          } else {
            // One last check for mobile devices
            scroll_event();
          }
        });

      $('.contact #' + id + ' .from').val(presenceChannel.members.me.id);

      $('.contact #' + id + ' .to').val(obj.attr('href'));

      getSharedFiles(userSessionId, contact_id);

      $('#frame .nav.nav-tabs li.groups, #frame .nav.nav-tabs li.groups a, #frame .nav.nav-tabs li.crm_clients a').removeClass('events_disabled');
      $('.user_sound_icon').show();
      return false;
    }

    /*--------------------  * send message & typing event to server  * ------------------- */
    $("#frame").on('keypress', 'textarea.chatbox', function(e) {
      var form = $(this).parents('form');
      var imgPath = $('#sidepanel #profile .wrap img').prop('currentSrc');

      var input_from = $(this).next().next().next();


      if (e.which == 13) {
        e.preventDefault();
        var message = $.trim($(this).val());
        if (message == '' || internetConnectionCheck() === false) {
          return false;
        }

        message = createTextLinks_(emojify.replace(message));

        $('#contacts .contact.active').find('.wrap .meta .preview').html('<?php echo _l('chat_message_you'); ?>' + ' ' + message);
        $('.messages ul').append('<li class="sent" id="' + userSessionId + '"><img class="myProfilePic" src="' + imgPath + '"/><p class="you" id="' + userSessionId + '">' + message + '</p></li>');

        input_from.val('false');

        // send event 
        var formData = form.serializeArray();

        $.post(prchatSettings.serverPath, formData);
        $(this).val('');
        $(this).focus();
        scroll_event();

      } else if (!$(this).val() || (input_from.val() == 'null' && $(this).val())) {
        // typing event 
        input_from.val('true');
        $.post(prchatSettings.serverPath, form.serialize());
      }
    });

    /*---------------* Update user lastes message into dabatase *---------------*/
    function updateLatestMessages(id) {
      $.post(prchatSettings.updateUnread, {
        id: id
      }).done(function(r) {
        if (r != 'true') {
          return false;
        }
        return true;
      });
    }

    /*---------------* Updating unread messages trigger and notification trigger *---------------*/
    function updateUnreadMessages(member_id) {
      var timeOut = 2000;
      member_id = $(member_id).attr('id');
      setTimeout(function() {
        if (member_id) {
          updateLatestMessages(member_id);
          $('.unread-notifications#' + member_id).hide();
          return true;
        }
      }, timeOut)
    }

    /*---------------* Additional checks for chatbox and unread message update control *---------------*/
    $('#frame').on("click", "textarea.chatbox, div.messages", function() {

      var member_id = $('#sidepanel li.active a.active_chat').attr('id');

      if ($('.has_newmessages').attr('id') == member_id && $('.has_newmessages').val() == 'true') {
        updateLatestMessages(member_id);
        $('.has_newmessages').val('false');
      }
    });

    /*---------------* prevent showing dots if user is not typing *---------------*/
    $("#frame").on("focus", ".chatbox, .messages", function() {
      $('.messages').find('span.userIsTyping').fadeOut(500);
      if ($('.tb')) {
        $('.tb').css({
          'font-weight': 'normal',
          'color': 'rgba(153, 153, 153, 1)'
        });
      }
    });

    /*---------------* Switch user chat theme *---------------*/
    function chatSwitchTheme(theme_name) {
      $.post(prchatSettings.switchTheme, {
        theme_name: theme_name
      }).done(function(r) {
        if (r.success !== false) {
          localStorage.chat_theme_name = theme_name;
          location.reload();
        }
      });
    }

    /*---------------* Search members *---------------*/
    $("#frame #search #search_field").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#frame #contacts ul li").filter(function() {
        $(this).toggle($(this).children('a').find('p.name').text().toLowerCase().indexOf(value) > -1);
      });
    });

    /*---------------* On focus out clear out input field and show all members if not found in searchbox *---------------*/
    function clearSearchValues() {
      $('#frame #search_field').val('');
      $("#contacts ul li").filter(function() {
        $(this).css('display', 'block');
        $('#profile').click();
      });
    }

    $('#frame').keyup('#search_field', function(e) {
      if (e.keyCode === 27) {
        clearSearchValues();
      }
    });
    (jQuery);

    /*---------------* Fill Social Iconds with data *---------------*/
    function fillSocialIconsData(obj) {
      var social_info_attributes = $(obj).find('social_info');

      var socialMedia = [{
          type: 'skype',
          value: social_info_attributes[0].attributes.skype.value,
          link: 'skype:' + social_info_attributes[0].attributes.skype.value + '?call'
        },
        {
          type: 'facebook',
          value: social_info_attributes[0].attributes.facebook.value,
          link: 'http://www.facebook.com/' + social_info_attributes[0].attributes.facebook.value
        },
        {
          type: 'linkedin',
          value: social_info_attributes[0].attributes.linkedin.value,
          link: 'http://www.linkedin.com/in/' + social_info_attributes[0].attributes.linkedin.value
        },
      ];

      for (var i in socialMedia) {
        var element = $('#frame').find('.contact-profile #fa-' + socialMedia[i].type);
        socialMedia[i].value == '' ?
          element.hide() :
          element.attr('href', socialMedia[i].link).show()
      }
    }

    /*---------------* Delete own messages function *---------------*/
    function delete_chat_message(msg_id) {
      msg_id = $(msg_id).attr('id');
      var contact_id = $('#contacts ul li').children('a.active_chat').attr('id');
      var paragraph = "<p class='you message_was_deleted' id='" + msg_id + "'><span></span></p>";
      var selector = $(".messages li#" + msg_id);

      $.post(prchatSettings.deleteMessage, {
        id: msg_id,
        contact_id: contact_id
      }).done(function(response) {
        if (response == 'true') {
          $('.tooltipster-base').hide();
          selector.find("p#msg_" + msg_id).remove();
          selector.append(paragraph);
          selector.find("p.you.message_was_deleted#" + msg_id + ' span').html(prchatSettings.messageIsDeleted).removeClass('tooltipstered');
          getSharedFiles(userSessionId, contact_id);
        } else {
          alert_float('danger', '<?php echo _l('chat_error_float'); ?>');
        }
      });
    }

    /*---------------* Check contact/staff role and append *---------------*/
    function checkContactRole(contactRole) {
      if (contactRole == '0') {
        $('#frame .content .contact-profile p small').html("<?= _l('chat_role_administrator'); ?>")
      } else {
        $('#frame .content .contact-profile p small').html(contactRole)
      }
    }

    /*---------------* Init current chat loader synchronized with messages append *---------------*/
    function activateLoader(promise = null, client = false) {
      if (promise !== null) {
        var initLoader = (client) ? $('#frame .client_messages') : $('#frame .messages');
        if (initLoader.is(':visible')) {
          if (initLoader.find('.message_loader').show()) {
            promise.then(function() {
              initLoader.find('.message_loader').hide();
            });
          };
        }
      }
    }

    /*---------------* Get current chat shared files *---------------*/
    function getSharedFiles(own_id, contact_id) {
      $.post(prchatSettings.getSharedFiles, {
        own_id: own_id,
        contact_id: contact_id
      }).done(function(data) {
        $('.history_slider').html('');
        $('.history_slider').html(JSON.parse(data));
      })
    }


    /*---------------* Truncate text message to user view left sidebar *---------------*/
    String.prototype.trunc = String.prototype.trunc ||
      function(n) {
        return (this.length > n) ? this.substr(0, n - 1) + '&hellip;' : this;
      };

    /*---------------* Scroll bottom *---------------*/
    function scroll_event() {
      var m = $('.messages'),
        gm = $('.group_messages'),
        cm = $('.client_messages');
      if (m.is(':visible') && m.hasScrollBar()) m.scrollTop(m[0].scrollHeight);
      if (gm.is(':visible') && gm.hasScrollBar()) gm.scrollTop(gm[0].scrollHeight);
      if (cm.is(':visible') && cm.hasScrollBar()) cm.scrollTop(cm[0].scrollHeight);
    }

    /*---------------* For mobile devices vh ports adjust for better UX *---------------*/
    var vh = window.innerHeight * 0.01;
    document.documentElement.style.setProperty("--vh", vh + "px");

    window.addEventListener("resize", function() {
      var vh = window.innerHeight * 0.01;
      document.documentElement.style.setProperty("--vh", vh + "px");
    });

    /*---------------* Theme events  *---------------*/
    $('#bottom-bar').on('click', '#switchTheme', function() {
      $('.dropdown-content').toggle(10);
    });

    /*---------------* Check if staff has permissions for settings  *---------------*/
    $('#settings').on('click', function() {
      <?php if (staff_can('view', 'settings')) : ?>
        window.location = "<?php echo admin_url('settings?group=prchat-settings'); ?>";
      <?php else : ?>
        alert_float('warning', "<?php echo _l('chat_settings_permission'); ?>");
      <?php endif; ?>
    });

    var isUserMobile = window.matchMedia("only screen and (max-width: 735px)").matches;
    /*---------------* Shared files on lick icon hide div with shared items  *---------------*/
    $('#sharedFiles').on('click', 'i.fa-times-circle-o', function() {
      $('#sharedFiles').css({
        'right': '-360px',
        'width': '360px'
      }, 10, 'linear').hide(1000);
    });

    /*---------------* On click event for shared files  *---------------*/
    $('#shared_user_files').on('click', function() {
      ($('#sharedFiles').css('right') == '-360px') ?
      $('#sharedFiles').show().animate({
        'right': '0',
        'width': (isUserMobile) ? '100%' : '360px'
      }, 10, 'linear'): $('#sharedFiles').css({
        'right': '-360px',
        'width': (isUserMobile) ? '360px' : '0px'
      }, 10, 'linear').hide(500);
    });
    /*---------------* Event click tracker for shared files   *---------------*/
    $(".messages, .group_messages, .chat_client_messages, #contacts, textarea, #header, #menu").on('click', function() {
      ($('#sharedFiles').is(':visible'))
      $('#sharedFiles').css({
        'right': '-360px',
        'width': '360px'
      }, 10, 'linear').hide(500);

      $('.chat_group_options, #status-options').removeClass('active')
      $('.chat_group_options').css({
        'right': '-360px',
        'width': '360px'
      }, 10, 'linear').hide(500);
    });

    /*---------------* Modal create announcement handler  *---------------*/
    $(function() {

      $('#frame .dropdown .i_announcement').on('click', function() {
        $('.modal_container').load(prchatSettings.chatAnnouncement, function(res) {
          if ($('.modal-backdrop.fade').hasClass('in')) {
            $('.modal-backdrop.fade').remove();
          }
          $('#chat_custom_modal').modal({
            show: true
          });
        });
      });

    })
    /*---------------* Modal create group handler  *---------------*/
    $('#frame .dropdown .i_groups, #frame #sidepanel #add_group_btn').on('click', function() {
      $('.modal_container').load(prchatSettings.chatGroups, function(res) {
        if ($('.modal-backdrop.fade').hasClass('in')) {
          $('.modal-backdrop.fade').remove();
        }
        if ($('#chat_groups_custom_modal').is(':hidden')) {
          $('#chat_groups_custom_modal').modal({
            show: true
          });
        }
      });
    });


    /*---------------* Some cached variables for group chat  *---------------*/
    var chat_group_messages = $('#frame .content .group_messages .chat_group_messages');
    var chat_client_messages = $('#frame .content .client_messages .chat_client_messages');
    var chat_contact_profile_img = $('#frame .content .contact-profile img');
    var chat_social_media = $('#frame .content .social-media');
    var chat_content_messages = $('#frame .content .messages');
    var chat_content_client_messages = $('#frame .content .client_messages');

    var changeSearchField = function() {
      $('#search #search_clients_field').attr('id', 'search_field');
      $('#search #search_field').attr('placeholder', "<?= _l('chat_search_chat_members'); ?>");
      $('.chat_contacts_list li').show();
    };

    /*---------------* Click event for staff users sidebar  *---------------*/
    $('#frame #sidepanel .staff').click(function() {
      // hide groups form
      $('#frame form[name=groupMessagesForm],#frame form[name=clientMessagesForm], #frame .groupOptions').hide();

      $('#frame .chat_group_options.active').hide().removeClass('active').css({
        'right': '-360px',
        'width': '360px'
      });
      $('#frame form[name=pusherMessagesForm]').show();
      $('.client_data').remove();

      if ($('.group_members_inline').remove()) {

        chat_contact_profile_img.show();
        chat_contact_profile_img.next().show();
        chat_contact_profile_img.next().next().show();
        chat_social_media.show();
        chat_content_messages.show();

      }
      if (!optionsSelector.hasClass('active')) {
        optionsSelector.css('display', '');
      }

      clientsListCheck();

      changeSearchField();

      $('.group_members_inline').remove();
      if (!window.matchMedia("only screen and (max-width: 735px)").matches) {
        $('#frame #contacts ul li').first().children('a').first().click();
      }
    });


    /*---------------* Click event for groups sidebar  *---------------*/
    $('#frame #sidepanel .groups').click(function() {

      // Hide staff chatbox form
      $('#frame form[name=pusherMessagesForm], #frame form[name=clientMessagesForm]').hide();

      $('#sharedFiles').hide().css({
        'right': '-360px',
        'width': '360px'
      });

      $(this).removeClass('flashit');
      $('.client_data').remove();

      chat_group_messages.html('');
      chat_group_messages.append('<ul></ul>');

      // show groups form
      $('#frame .content .group_messages, #frame form[name=groupMessagesForm]').show();

      chat_content_messages.hide();
      chat_content_client_messages.hide();
      chat_contact_profile_img.hide();
      chat_contact_profile_img.next().hide();
      chat_contact_profile_img.next().next().hide();

      if (!window.matchMedia("only screen and (max-width: 735px)").matches) {
        $('#frame ul.chat_groups_list li.active a').click();
      }

      var group_id = $('#frame ul.chat_groups_list li.active').attr('id');

      getGroupMessages(group_id);

      appendOptionsBar();

      clientsListCheck();

      changeSearchField();
      if ($('.chat_groups_list li').length == 0) {
        $('.contact-profile .groupOptions, .contact-profile .social-media').hide();
      }
      if (group_id == undefined) {
        $('.message_group_loader').hide();
      }
    });
  </script>

  <!-- Include chat groups file -->
  <?php require('modules/prchat/assets/module_includes/groups.php'); ?>

  <?php
  if (isClientsEnabled()) {
    require('modules/prchat/assets/module_includes/crm_clients.php');
  }
  ?>

  <!-- Include chat sound settings file -->
  <?php require('modules/prchat/assets/module_includes/chat_sound_settings.php'); ?>