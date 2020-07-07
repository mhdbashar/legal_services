<!DOCTYPE html>

<head>
    <title>Meeting </title>
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
            direction:rtl;
        }

        .selectpicker {
            height: 34px;
            border-radius: 4px;
        }
    </style>

    <nav id="nav-tool" class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="#"><?php echo _l('meeting'); ?> </a>
            </div>
            <div id="navbar">
                <form class="navbar-form navbar-right" id="meeting_form">
                    <div class="form-group">
                        <input type="text" name="display_name" id="display_name" value="" maxLength="100"
                            placeholder="<?php echo _l('name'); ?>" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <input type="text" name="meeting_number" id="meeting_number" value="" maxLength="11"
                            style="width:150px" placeholder="<?php echo _l('meeting_id'); ?>" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <input type="text" name="meeting_pwd" id="meeting_pwd" value="" style="width:150px"
                            maxLength="32" placeholder="<?php echo _l('password'); ?>" class="form-control">
                    </div>

                    <!-- <div class="form-group">
                        <select id="meeting_role" class="selectpicker">
                      
                            <option value=0><?php echo _l('user'); ?></option>
                         
                        <option value=5>Assistant</option>
                        </select>
                    </div> -->
                    <!-- <div class="form-group">
                        <select id="meeting_lang" class="selectpicker dropdown">
                              <option value="en-US"><?php echo _l('english'); ?></option>
                            <option value="de-DE"><?php echo _l('german'); ?></option>
                            <option value="es-ES"><?php echo _l('spanish'); ?></option>
                            <option value="fr-FR"><?php echo _l('french'); ?></option>
                            <option value="jp-JP"><?php echo _l('japanese'); ?></option>
                            <option value="pt-PT"><?php echo _l('portuguese'); ?></option>
                            <option value="ru-RU"><?php echo _l('russian'); ?></option>
                            <option value="zh-CN"><?php echo _l('chinese'); ?></option>
                            <option value="zh-TW"><?php echo _l('chinese'); ?></option>
                            <option value="ko-KO"><?php echo _l('korean'); ?></option>
                        </select>
                    </div> -->

                    <button type="submit" class="btn btn-primary" id="join_meeting"><?php echo _l('join'); ?></button>
                    <button type="submit" class="btn btn-primary" id="clear_all"><?php echo _l('clear'); ?></button>

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

  










