<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
  
  <style>

.navbar-nav{
    display: block !important;
}
.navbar {
    
    flex-wrap: unset !important;

}

  </style>

<script type="text/javascript">
    AppHelper = {};
    AppHelper.baseUrl = "http://localhost:8012/codeigniter4";
    AppHelper.assetsDirectory = "http://localhost:8012/codeigniter4/assets/";
    AppHelper.settings = {};
    AppHelper.settings.firstDayOfWeek = "0" || 0;
    AppHelper.settings.currencySymbol = "$";
    AppHelper.settings.currencyPosition = "" || "left";
    AppHelper.settings.decimalSeparator = ".";
    AppHelper.settings.thousandSeparator = "";
    AppHelper.settings.noOfDecimals = ("" == "0") ? 0 : 2;
    AppHelper.settings.displayLength = "10";
    AppHelper.settings.dateFormat = "Y-m-d";
    AppHelper.settings.timeFormat = "small";
    AppHelper.settings.scrollbar = "jquery";
    AppHelper.settings.enableRichTextEditor = "0";
    AppHelper.settings.notificationSoundVolume = "0";
    AppHelper.settings.disableKeyboardShortcuts = "0";
    AppHelper.userId = "3";
    AppHelper.notificationSoundSrc = "http://localhost:8012/codeigniter4/files/system/notification.mp3";

    //push notification
    AppHelper.settings.enablePushNotification = "";
    AppHelper.settings.userEnableWebNotification = "1";
    AppHelper.settings.userDisablePushNotification = "0";
    AppHelper.settings.pusherKey = "";
    AppHelper.settings.pusherCluster = "";
    AppHelper.settings.pushNotficationMarkAsReadUrl = "http://localhost:8012/perfex_crm/admin/notifications/set_notification_status_as_read";
    AppHelper.https = "0";

    AppHelper.settings.disableResponsiveDataTableForMobile = "";
    AppHelper.settings.disableResponsiveDataTable = "";

    AppHelper.csrfTokenName = "rise_csrf_token";
    AppHelper.csrfHash = "2c45add3d5b971acd0f7175754a60343";

    AppHelper.settings.defaultThemeColor = "F2F2F2";

    AppHelper.settings.timepickerMinutesInterval = 5;

    AppHelper.settings.weekends = "";

    AppHelper.serviceWorkerUrl = "http://localhost:8012/codeigniter4/assets/js/sw/sw.js";

    AppHelper.uploadPastedImageLink = "http://localhost:8012/perfex_crm/admin/upload_pasted_image/save";

</script>    <script type="text/javascript">
    AppLanugage = {};
    AppLanugage.locale = "en";
    AppLanugage.localeLong = "en-US";

    AppLanugage.days = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
    AppLanugage.daysShort = ["Sun","Mon","Tue","Wed","Thu","Fri","Sat"];
    AppLanugage.daysMin = ["Su","Mo","Tu","We","Th","Fr","Sa"];

    AppLanugage.months = ["January","February","March","April","May","June","July","August","September","October","November","December"];
    AppLanugage.monthsShort = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];

    AppLanugage.today = "Today";
    AppLanugage.yesterday = "Yesterday";
    AppLanugage.tomorrow = "Tomorrow";

    AppLanugage.search = "Search";
    AppLanugage.noRecordFound = "No record found.";
    AppLanugage.print = "Print";
    AppLanugage.excel = "Excel";
    AppLanugage.printButtonTooltip = "Press escape when finished.";

    AppLanugage.fileUploadInstruction = "Drag-and-drop documents here <br /> (or click to browse...)";
    AppLanugage.fileNameTooLong = "Filename is too long.";

    AppLanugage.custom = "Custom";
    AppLanugage.clear = "Clear";

    AppLanugage.total = "Total";
    AppLanugage.totalOfAllPages = "Total of all pages";

    AppLanugage.all = "All";

    AppLanugage.preview_next_key = "Next (Right arrow key)";
    AppLanugage.preview_previous_key = "Previous (Left arrow key)";

    AppLanugage.filters = "Filters";

    AppLanugage.comment = "Comment";

    AppLanugage.undo = "Undo";

</script>
    <link rel='stylesheet' type='text/css' href='http://localhost:8012/codeigniter4/assets/bootstrap/css/bootstrap.min.css?v=3.3' /><link rel='stylesheet' type='text/css' href='http://localhost:8012/codeigniter4/assets/js/select2/select2.css?v=3.3' /><link rel='stylesheet' type='text/css' href='http://localhost:8012/codeigniter4/assets/js/select2/select2-bootstrap.min.css?v=3.3' /><link rel='stylesheet' type='text/css' href='http://localhost:8012/codeigniter4/assets/css/app.all.css?v=3.3' /><link rel='stylesheet' type='text/css' href='http://localhost:8012/codeigniter4/assets/css/custom-style.css?v=3.3' /><script type='text/javascript'  src='http://localhost:8012/codeigniter4/assets/js/app.all.js?v=3.3'></script>
        <script>

        var data = {};
        data[AppHelper.csrfTokenName] = AppHelper.csrfHash;
        $.ajaxSetup({
            data: data
        });
    </script>
        
        
    
</head>    <body class="">

        <script type='text/javascript'  src='http://localhost:8012/codeigniter4/assets/js/push_notification/pusher/pusher.min.js?v=3.3'></script>



<script type="text/javascript">
    //close navbar collapse panel on clicking outside of the panel
    $(document).click(function (e) {
        if (!$(e.target).is('#navbar') && isMobile()) {
            $('#navbar').collapse('hide');
        }
    });

    var notificationOptions = {};

    $(document).ready(function () {
        //load message notifications
        var messageOptions = {},
                messageIcon = "#message-notification-icon",
                notificationIcon = "#web-notification-icon";

        //check message notifications
        messageOptions.notificationUrl = "http://localhost:8012/perfex_crm/admin/messages/count_notifications";
        messageOptions.notificationStatusUpdateUrl = "http://localhost:8012/perfex_crm/admin/messages/update_notification_checking_status";
        messageOptions.checkNotificationAfterEvery = "60";
        messageOptions.icon = "mail";
        messageOptions.notificationSelector = $(messageIcon);
        messageOptions.isMessageNotification = true;

        checkNotifications(messageOptions);

        window.updateLastMessageCheckingStatus = function () {
            checkNotifications(messageOptions, true);
        };

        $('body').on('show.bs.dropdown', messageIcon, function () {
            messageOptions.notificationUrl = "http://localhost:8012/perfex_crm/admin/messages/get_notifications";
            checkNotifications(messageOptions, true);
        });




        //check web notifications
        notificationOptions.notificationUrl = "http://localhost:8012/perfex_crm/admin/notifications/count_notifications";
        notificationOptions.notificationStatusUpdateUrl = "http://localhost:8012/perfex_crm/admin/notifications/update_notification_checking_status";
        notificationOptions.checkNotificationAfterEvery = "60";
        notificationOptions.icon = "bell";
        notificationOptions.notificationSelector = $(notificationIcon);
        notificationOptions.notificationType = "web";
        notificationOptions.pushNotification = "";

        checkNotifications(notificationOptions); //start checking notification after starting the message checking 

        if (isMobile()) {
            //for mobile devices, load the notifications list with the page load
            notificationOptions.notificationUrlForMobile = "http://localhost:8012/perfex_crm/admin/notifications/get_notifications";
            checkNotifications(notificationOptions);
        }

        $('body').on('show.bs.dropdown', notificationIcon, function () {
            notificationOptions.notificationUrl = "http://localhost:8012/perfex_crm/admin/notifications/get_notifications";
            checkNotifications(notificationOptions, true);
        });

        $('body').on('click', "#reminder-icon", function () {
            $("#ajaxModal").addClass("reminder-modal");

            //if there has reminder form on task details page, opening from topbar will give error
            //to prevent this, on loading global reminders, remove task reminders content
            //and reload page after closing modal
            if ($("#task-reminders").length) {
                $("#task-reminders").html("");
            }
        });

        $("body").on("click", ".notification-dropdown a[data-act='ajax-modal'], #js-quick-add-task, #js-quick-add-multiple-task, #task-details-edit-btn", function () {
            if ($(".task-preview").length) {
                //remove task details view when it's already opened to prevent selector duplication
                $("#page-content").remove();
                $('#ajaxModal').on('hidden.bs.modal', function () {
                    location.reload();
                });
            }
        });

        $('[data-bs-toggle="tooltip"]').tooltip();
    });

</script>    <div id="js-init-chat-icon" class="init-chat-icon">
        <!-- data-type= open/close/unread -->
        <span id="js-chat-min-icon" data-type="open" class="chat-min-icon"><i data-feather="message-circle" class="icon-18"></i></span>
    </div>

    <div id="js-rise-chat-wrapper" class="rise-chat-wrapper hide"></div>

    <script type="text/javascript">
        $(document).ready(function () {

            chatIconContent = {
                "open": "<i data-feather='message-circle' class='icon-18'></i>",
                "close": "<span class='chat-close'>&times;</span>",
                "unread": ""
            };

            //we'll wait for 15 sec after clicking on the unread icon to see more notifications again.

            setChatIcon = function (type, count) {

                //don't show count if the data-prevent-notification-count is 1
                if ($("#js-chat-min-icon").attr("data-prevent-notification-count") === "1" && type === "unread") {
                    return false;
                }


                $("#js-chat-min-icon").attr("data-type", type).html(count ? count : chatIconContent[type]);

                if (type === "open") {
                    $("#js-rise-chat-wrapper").addClass("hide"); //hide chat box
                    $("#js-init-chat-icon").removeClass("has-message");
                } else if (type === "close") {
                    $("#js-rise-chat-wrapper").removeClass("hide"); //show chat box
                    $("#js-init-chat-icon").removeClass("has-message");
                } else if (type === "unread") {
                    $("#js-init-chat-icon").addClass("has-message");
                }

            };

            changeChatIconPosition = function (type) {
                if (type === "close") {
                    $("#js-init-chat-icon").addClass("move-chat-icon");
                } else if (type === "open") {
                    $("#js-init-chat-icon").removeClass("move-chat-icon");
                }
            };

            //is there any active chat? open the popup
            //otherwise show the chat icon only
            var activeChatId = getCookie("active_chat_id"),
                    isChatBoxOpen = getCookie("chatbox_open"),
                    $chatIcon = $("#js-init-chat-icon");


            $chatIcon.click(function () {
                $("#js-rise-chat-wrapper").html("");

                window.updateLastMessageCheckingStatus();

                var $chatIcon = $("#js-chat-min-icon");

                if ($chatIcon.attr("data-type") === "unread") {
                    $chatIcon.attr("data-prevent-notification-count", "1");

                    //after clicking on the unread icon, we'll wait 11 sec to show more notifications again.
                    setTimeout(function () {
                        $chatIcon.attr("data-prevent-notification-count", "0");
                    }, 11000);
                }

                var windowSize = window.matchMedia("(max-width: 767px)");

                if ($chatIcon.attr("data-type") !== "close") {
                    //have to reload
                    setTimeout(function () {
                        loadChatTabs();
                    }, 200);
                    setChatIcon("close"); //show close icon
                    setCookie("chatbox_open", "1");
                    if (windowSize.matches) {
                        changeChatIconPosition("close");
                    }
                } else {
                    //have to close the chat box
                    setChatIcon("open"); //show open icon
                    setCookie("chatbox_open", "");
                    setCookie("active_chat_id", "");
                    if (windowSize.matches) {
                        changeChatIconPosition("open");
                    }
                }

                if (window.activeChatChecker) {
                    window.clearInterval(window.activeChatChecker);
                }

                if (typeof window.placeCartBox === "function") {
                    window.placeCartBox();
                }
                
                feather.replace();

            });

            //open chat box
            if (isChatBoxOpen) {

                if (activeChatId) {
                    getActiveChat(activeChatId);
                } else {
                    loadChatTabs();
                }
            }

            var windowSize = window.matchMedia("(max-width: 767px)");
            if (windowSize.matches) {
                if (isChatBoxOpen) {
                    $("#js-init-chat-icon").addClass("move-chat-icon");
                }
            }




            $('body #js-rise-chat-wrapper').on('click', '.js-message-row', function () {
                getActiveChat($(this).attr("data-id"));
            });

            $('body #js-rise-chat-wrapper').on('click', '.js-message-row-of-team-members-tab', function () {
                getChatlistOfUser($(this).attr("data-id"), "team_members");
            });

            $('body #js-rise-chat-wrapper').on('click', '.js-message-row-of-clients-tab', function () {
                getChatlistOfUser($(this).attr("data-id"), "clients");
            });


        });

        function getChatlistOfUser(user_id, tab_type) {

            setChatIcon("close"); //show close icon

            appLoader.show({container: "#js-rise-chat-wrapper", css: "bottom: 40%; right: 35%;"});
            $.ajax({
                url: "http://localhost:8012/perfex_crm/admin/messages/get_chatlist_of_user",
                type: "POST",
                data: {user_id: user_id, tab_type: tab_type},
                success: function (response) {
                    $("#js-rise-chat-wrapper").html(response);
                    appLoader.hide();
                }
            });
        }

        function loadChatTabs(trigger_from_user_chat) {

            setChatIcon("close"); //show close icon

            setCookie("active_chat_id", "");
            appLoader.show({container: "#js-rise-chat-wrapper", css: "bottom: 40%; right: 35%;"});
            $.ajax({
                url: "http://localhost:8012/perfex_crm/admin/messages/chat_list",
                data: {
                    type: "inbox"
                },
                success: function (response) {
                    $("#js-rise-chat-wrapper").html(response);

                    if (!trigger_from_user_chat) {
                        $("#chat-inbox-tab-button a").trigger("click");
                    } else if (trigger_from_user_chat === "team_members") {
                        $("#chat-users-tab-button").find("a").trigger("click");
                    } else if (trigger_from_user_chat === "clients") {
                        $("#chat-clients-tab-button").find("a").trigger("click");
                    }
                    appLoader.hide();
                }
            });

        }


        function getActiveChat(message_id) {
            setChatIcon("close"); //show close icon

            appLoader.show({container: "#js-rise-chat-wrapper", css: "bottom: 40%; right: 35%;"});
            $.ajax({
                url: "http://localhost:8012/perfex_crm/admin/messages/get_active_chat",
                type: "POST",
                data: {
                    message_id: message_id
                },
                success: function (response) {
                    $("#js-rise-chat-wrapper").html(response);
                    appLoader.hide();
                    setCookie("active_chat_id", message_id);
                    $("#js-chat-message-textarea").focus();
                }
            });
        }

        window.prepareUnreadMessageChatBox = function (totalMessages) {
            setChatIcon("unread", totalMessages); //show close icon
        };


        window.triggerActiveChat = function (message_id) {
            getActiveChat(message_id);
        }

    </script>  




    <a class="sidebar-brand brand-logo" href="http://localhost:8012/perfex_crm/admin/dashboard"><img class="dashboard-image" src="http://localhost:8012/codeigniter4/files/system/_file63a56e9335aef-site-logo.png" /></a>
    <a class="sidebar-brand brand-logo-mini" href="http://localhost:8012/perfex_crm/admin/dashboard"><img class="dashboard-image" src="http://localhost:8012/codeigniter4/files/system/_file63a56e9337ddc-favicon.png" /></a>


</div><!-- sidebar menu end -->

<script type='text/javascript'>
    feather.replace();
</script>            <div class="page-container overflow-auto ">
                <div id="pre-loader">
                    <div id="pre-loade" class="app-loader"><div class="loading"></div></div>
                </div>
                <div class="scrollable-page main-scrollable-page">
                    <div id="page-content" class="page-wrapper clearfix">

    <div class="row">

        <div class="box">
            <div class="box-content message-button-list">
                <ul class="list-group ">
                    <a href="http://localhost:8012/perfex_crm/admin/messages/modal_form" class="list-group-item" title="Send message" >Compose</a> 

                    <a href="http://localhost:8012/perfex_crm/admin/messages/inbox" class="list-group-item">Inbox</a>
                    <a href="http://localhost:8012/perfex_crm/admin/messages/sent_items" class="list-group-item">Sent items</a>                </ul>
            </div>


            <div class="box-content message-view ps-3" >
                <div class="row">
                    <div class="col-sm-12 col-md-5">
                        <div id="message-list-box" class="card">
                            <div class="card-header p10 clearfix no-border">
                                <div class="float-start p5">
                                    <i data-feather='send' class='icon-16'></i> Sent items                                </div>
                                <div class="float-end">
                                    <input type="text" id="search-messages" class="datatable-search" placeholder="Search">
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table id="message-table" class="display no-thead no-padding clickable" cellspacing="0" width="100%">            
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-7">
                        <div id="message-details-section" class="card"> 
                            <div id="empty-message" class="text-center mb15 box">
                                <div class="box-content" style="vertical-align: middle; height: 100%"> 
                                    <div>Select a message to view</div>
                                    <i data-feather="mail" width="10rem" height="10rem" style="color:rgba(128, 128, 128, 0.1)"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>
<style type="text/css">
    .datatable-tools:first-child {
        display:  none;
    }
</style>

<script type="text/javascript">
    $(document).ready(function () {
        var autoSelectIndex = "";
        $("#message-table").appTable({
            source: 'http://localhost:8012/perfex_crm/admin/messages/list_data/sent_items',
            order: [[1, "desc"]],
            columns: [
                {title: 'Message'},
                {targets: [1], visible: false},
                {targets: [2], visible: false}
            ],
            onInitComplete: function () {
              
                if (autoSelectIndex) {
                    //automatically select the message
                    var $tr = $("[data-index=" + autoSelectIndex + "]").closest("tr");
                    if ($tr.length)
                        $tr.trigger("click");
                }

                var $message_list = $("#message-list-box"),
                  $empty_message = $("#empty-message");
                if ($empty_message.length && $message_list.length) {
                    $empty_message.height($message_list.height());
                }
            }
        });

        var messagesTable = $('#message-table').DataTable();
        $('#search-messages').keyup(function () {
            messagesTable.search($(this).val()).draw();
        });


        /*load a message details*/
        $("body").on("click", "tr", function () {
           
            //remove unread class
            $(this).find(".unread").removeClass("unread");

            //don't load this message if already has selected.
            if (!$(this).hasClass("active")) {
                var message_id = $(this).find(".message-row").attr("data-id");
                
                        reply = $(this).find(".message-row").attr("data-reply");
                       
                if (message_id) {
                    $("tr.active").removeClass("active");
                    $(this).addClass("active");
                    $.ajax({
                        url: "http://localhost:8012/perfex_crm/admin/messages/view_view/" + message_id + "/sent_items/" + reply,
                        dataType: "json",
                        success: function (result) {
                            if (result.success) {
                                $("#message-details-section").html(result.data);
                            } else {
                                appAlert.error(result.message);
                            }
                        }
                    });
                }

                //add index with tr for dlete the message
                $(this).addClass("message-container-" + $(this).find(".message-row").attr("data-index"));

            }
        });

    });
</script>                </div>
                
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="ajaxModal" role="dialog" aria-labelledby="ajaxModal" data-bs-backdrop="static" data-bs-keyboard="true" aria-hidden="true" data-bs-focus="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="ajaxModalTitle" data-title="RISE - Ultimate Project Manager and CRM"></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="ajaxModalContent">

            </div>
            <div id='ajaxModalOriginalContent' class='hide'>
                <div class="original-modal-body">
                    <div class="circle-loader"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>    

<!-- Modal -->
<div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModal" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 400px;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="confirmationModalTitle">Delete?</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="confirmationModalContent" class="modal-body">
                <div class="container-fluid">
                     Are you sure? You won't be able to undo this action!                </div>
            </div>
            <div class="modal-footer clearfix">
                <button id="confirmDeleteButton" type="button" class="btn btn-danger" data-bs-dismiss="modal"><i data-feather="trash-2" class="icon-16"></i> Delete</button>
                <button type="button" class="btn btn-default" data-bs-dismiss="modal"><i data-feather="x" class="icon-16"></i> Cancel</button>
            </div>
        </div>
    </div>
</div>        <link rel='stylesheet' type='text/css' href='http://localhost:8012/codeigniter4/assets/js/summernote/summernote.css?v=3.3' /><script type='text/javascript'  src='http://localhost:8012/codeigniter4/assets/js/summernote/summernote.min.js?v=3.3'></script><script type='text/javascript'  src='http://localhost:8012/codeigniter4/assets/js/summernote/lang/summernote-en-US.js?v=3.3'></script>        <div style='display: none;'>
            
            <script type='text/javascript'>
                feather.replace();

            </script>

           