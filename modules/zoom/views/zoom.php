<!DOCTYPE html>

<head>
    <title>Meeting</title>
    <meta charset="utf-8" />
    <link type="text/css" rel="stylesheet" href="<?= base_url() ?>/modules/zoom/assets/css/bootstrap.css" />
    <link type="text/css" rel="stylesheet" href="<?= base_url() ?>/modules/zoom/assets/css/react-select.css" />
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

</head>

<body>
    <style>
        body {
            padding-top: 50px;
        }

        .selectpicker {
            height: 34px;
            border-radius: 4px;
        }
    </style>

    <nav id="nav-tool" class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">Meeting </a>
            </div>
            <div id="navbar">
                <form class="navbar-form navbar-right" id="meeting_form">
                    <div class="form-group">
                        <input type="text" name="display_name" id="display_name" value="1.7.7#CDN" maxLength="100"
                            placeholder="Name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <input type="text" name="meeting_number" id="meeting_number" value="5134592470" maxLength="11"
                            style="width:150px" placeholder="Meeting Number" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <input type="text" name="meeting_pwd" id="meeting_pwd" value="NllqQmE5R01tSEpvTXM3b2ZRaVFCUT09" style="width:150px"
                            maxLength="32" placeholder="Meeting Password" class="form-control">
                    </div>

                    <div class="form-group">
                        <select id="meeting_role" class="selectpicker">
                               <option value=1>Host</option>
              
                         
<!--                            <option value=5>Assistant</option>-->
                        </select>
                    </div>
                    <div class="form-group">
                        <select id="meeting_lang" class="selectpicker dropdown">
                            <option value="en-US">English</option>
                            <option value="de-DE">German Deutsch</option>
                            <option value="es-ES">Spanish Español</option>
                            <option value="fr-FR">French Français</option>
                            <option value="jp-JP">Japanese 日本語</option>
                            <option value="pt-PT">Portuguese Portuguese</option>
                            <option value="ru-RU">Russian Русский</option>
                            <option value="zh-CN">Chinese 简体中文</option>
                            <option value="zh-TW">Chinese 繁体中文</option>
                            <option value="ko-KO">Korean 한국어</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary" id="join_meeting">Join</button>
                    <button type="submit" class="btn btn-primary" id="clear_all">Clear</button>

                </form>
            </div>
            <!--/.navbar-collapse -->
        </div>
    </nav>

    <?php render_js_variables(); ?>

    <script src="<?= base_url() ?>/modules/zoom/assets/js/react.min.js"></script>
    <script src="<?= base_url() ?>/modules/zoom/assets/js/react-dom.min.js"></script>
    <script src="<?= base_url() ?>/modules/zoom/assets/js/redux.min.js"></script>
    <script src="<?= base_url() ?>/modules/zoom/assets/js/redux-thunk.min.js"></script>
    <script src="<?= base_url() ?>/modules/zoom/assets/js/jquery.min.js"></script>
    <script src="<?= base_url() ?>/modules/zoom/assets/js/lodash.min.js"></script>

    <script src="<?= base_url() ?>/modules/zoom/assets/js/zoom-meeting-1.7.7.min.js"></script>
           <script src="<?= base_url() ?>/modules/zoom/assets/js/tool.js"></script>
       <script src="<?= base_url() ?>/modules/zoom/assets/js/index.js"></script>
</body>

</html>

  










