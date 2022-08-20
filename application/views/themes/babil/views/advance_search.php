<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="panel_s" dir="rtl">
    <div class="panel-body">
        <?php echo form_open(site_url('knowledge_base/advance_searched/0'), ['method' => 'POST', 'id' => 'advance-search']); ?>
        <div class="form-group">
            <?php $country = get_kb_main_groups(); ?>
            <label for="country" class="control-label"><?php echo _l('إختر الدولة'); ?></label>
            <select class="selectpicker custom_select_arrow" id="country" name="country" onchange="get_main_group()"
                    data-width="100%" data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                <!--                <option selected></option>-->
                <?php foreach ($country as $groups) { ?>
                    <option value="<?php echo $groups->groupid; ?>"<?php if ($groups->groupid == 1) echo 'selected' ?>><?php echo $groups->name; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <?php $groups = kb_childe_group(1) ?>
            <label for="main_group" class="control-label"><?php echo _l('إختر القسم'); ?></label>
            <select class="selectpicker custom_select_arrow" onchange="get_custom_fields()" id="main_group"
                    name="main_group" data-width="100%"
                    data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>" required>
                <!--                <option selected></option>-->
                <?php foreach ($groups as $group) { ?>
                    <option value="<?php echo $group->groupid; ?>"><?php echo $group->name; ?></option>
                <?php } ?>
            </select>
        </div>
        <!--        <div class="form-group">-->
        <!--            <label for="custom_fields" class="control-label">-->
        <?php //echo _l('إختر الحقل'); ?><!--</label>-->
        <!--            <select class="selectpicker custom_select_arrow" id="custom_fields"  name="custom_fields" data-width="100%" data-none-selected-text="-->
        <?php //echo _l('dropdown_non_selected_tex'); ?><!--">-->
        <!--            </select>-->
        <!--        </div>-->
        <div id="custom_fields"></div>
        <div class="form-group">
            <!--        <label for="search" class="control-label">-->
            <?php //echo _l('الجملة المراد البحث عنها'); ?><!--</label>-->
            <!--        <div class="input-group">-->
            <!--            <input type="search" id="search" name="search" placeholder="-->
            <?php //echo _l('أدخل ثلاث كلمات على الأقل للحصول على نتائج جيدة'); ?><!--" class="form-control kb-search-input" value="">-->
            <!--            <span class="input-group-btn">-->
            <!--                <button onclick="get_search()" type="submit" class="btn btn-success kb-search-button">-->
            <?php //echo _l('kb_search'); ?><!--</button>-->
            <!--            </span>-->
            <!--            <i class="glyphicon glyphicon-search form-control-feedback kb-search-icon"></i>-->
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-success"><h4>بحث</h4></button>
            <button type="button" class="btn btn-secondary" onclick="empty_searche()"><h4>مسح عوامل البحث</h4></button>
        </div>
        <?php echo form_close(); ?>
    </div>


    <div id="list"></div>
    <div id="loader"></div>
</div>
</div>
<style>
    @-webkit-keyframes spin {
        0% {
            -webkit-transform: rotate(0deg);
        }
        100% {
            -webkit-transform: rotate(360deg);
        }
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }

    @-webkit-keyframes animatebottom {
        from {
            bottom: -100px;
            opacity: 0
        }
        to {
            bottom: 0px;
            opacity: 1
        }
    }

    @keyframes animatebottom {
        from {
            bottom: -100px;
            opacity: 0
        }
        to {
            bottom: 0;
            opacity: 1
        }
    }

    .control-label, label {
        font-weight: 400;
        font-size: 20px;
        color: #4a4a4a;
    }

    .bootstrap-select .dropdown-toggle .filter-option {
        position: static;
        top: 0;
        left: 0;
        float: left;
        height: 100%;
        width: 100%;
        text-align: left;
        overflow: hidden;
        -webkit-box-flex: 0;
        -webkit-flex: 0 1 auto;
        -ms-flex: 0 1 auto;
        flex: 0 1 auto;
        font-weight: 400;
        font-size: 17px;
        color: #4a4a4a;
    }

    .bootstrap-select .dropdown-toggle .filter-option-inner-inner {
        overflow: hidden;
        font-weight: 400;
        font-size: 17px;
        color: #4a4a4a;
    }

    .form-control .kb-search-input {
        overflow: hidden;
        font-weight: 400;
        font-size: 17px;
        color: #4a4a4a;
    }
</style>

<script>
    $('#main_group').ready(function () {
        get_custom_fields();
    });
    $('#custom_fields').change(function () {
        $('#search').val('');
    });
    //$('#search').keyup(function () {
    //    var text = $(this).val();
    //    var custom_id = $('#custom_fields').val();
    //    var type = $('#main_group').val();
    //
    //    //console.log(va);
    //    if (text.length > 3) {
    //        apc_search_delay(function () {
    //            $.ajax({
    //                url: '<?php //echo site_url("Knowledge_base/get_search_results_ajax/"); ?>//',
    //                type: 'POST',
    //                data: {
    //                    text: text,
    //                    custom_id: custom_id,
    //                    type: type
    //                },
    //                beforeSend: function () {
    //                    $('#loader').html('');
    //                    $('#loader').append('<div class="loader" style="position: absolute;\n' +
    //                        '        left: 50%;\n' +
    //                        '        top: 50%;\n' +
    //                        '        z-index: 1;\n' +
    //                        '        width: 120px;\n' +
    //                        '        height: 120px;\n' +
    //                        '        margin: -76px 0 0 -76px;\n' +
    //                        '        border: 16px solid #f3f3f3;\n' +
    //                        '        border-radius: 50%;\n' +
    //                        '        border-top: 16px solid #3498db;\n' +
    //                        '        -webkit-animation: spin 2s linear infinite;\n' +
    //                        '        animation: spin 2s linear infinite;"></div>');
    //                },
    //                success: function (data) {
    //                    $('#list').html('');
    //                    $('#list').append(`<div class="mtop10 tc-content kb-article-content">`);
    //                    response = JSON.parse(data);
    //                    $.each(response, function (key, value) {
    //                        // if (custom_id != 0)
    //                        $('#list').append(`<li class="mtop5 list-group-item"><a href="${value['link']}" target="_blank"><h4>${value['name']}</h4></a><h5 style="color: rgb(0,0,0)">${value['title']}</h5><p style="color: rgb(0,0,0)">${value['description']}</p></li>`);
    //                        // else
    //                        //     $('#list').append(`<li class="mtop5 list-group-item"><a href="${value['link']}" target="_blank"><h4>${value['name']}</h4></a></li>`);
    //                    });
    //                    $('#list').append(`</div>`);
    //                    if(response.length == 0){
    //                        $('#list').append(`<h4>لا يوجد نتائج</h4>`);
    //                    }
    //                },
    //                complete: function (jqXHR, textStatus) {
    //                    $('#loader').html('');
    //                }
    //            });
    //        }, 1000);
    //    } else {
    //        //close_src_panel();
    //    }
    //});
    var apc_search_delay = (function () {
        var timer = 0;
        return function (callback, ms) {
            clearTimeout(timer);
            timer = setTimeout(callback, ms);
        };
    })();

    function get_main_group() {
        $('#search').val('');
        var country = $('#country').val();
        $('#custom_fields').html('');
        $('#main_group').html('');
        $('#main_group').selectpicker("refresh");
        $('#custom_fields').selectpicker("refresh");
        $.ajax({
            url: '<?php echo site_url("Knowledge_base/get_main_group_ajax/"); ?>' + country,
            type: 'POST',
            success: function (data) {
                $('#main_group').html('');
                response = JSON.parse(data);
                // $('#main_group').append(`<option value=""></option>`);
                $.each(response, function (key, value) {
                    $('#main_group').append(`<option value="${value['groupid']}">${value['name']}</option>`);
                    $('#main_group').selectpicker("refresh");
                });
                $('#main_group').selectpicker("refresh");
            }
        });
    }

    function get_custom_fields() {
        $('#search').val('');
        var custom_id = $('#main_group').val();
        $('#custom_fields').html('');
        $.ajax({
            url: '<?php echo site_url("Knowledge_base/get_custom_fields_ajax/"); ?>' + custom_id,
            type: 'POST',
            success: function (data) {
                $('#custom_fields').html('');
                response = JSON.parse(data);
                $.each(response, function (key, value) {
                    if (custom_id == 2) {
                        if (value['id'] == 4) {
                            $('#custom_fields').append(`
                        <div class="form-group">
                        <label for="${value['id']}" class="control-label">${value['name']}</label>
                        <br>
                            <tr>
                                <td>
                                    <div class="radio radio-primary radio-inline">
                                    <input type="radio" name="${value['id']}"  id="${value['id']}" value="ساري" checked>
                                    <label for="${value['id']}">ساري</label>
                                    </div>
                                    <div class="radio radio-primary radio-inline">
                                    <input type="radio" name="${value['id']}"  id="${value['id']}" value="غير ساري">
                                    <label for="${value['id']}"> غير ساري </label>
                                    </div>
                                </td>
                            </tr>
                        </div>
                        `);
                        } else if (value['id'] == 5) {
                            $('#custom_fields').append(`
                        <div class="form-group">
                        <label for="${value['id']}" class="control-label">${value['name']}</label>
                        <br>
                            <tr>
                                <td>
                                    <div class="radio radio-primary radio-inline">
                                    <input type="radio" name="${value['id']}"  id="${value['id']}" value="جرى عليه تعديل" checked>
                                    <label for="${value['id']}">جرى عليه تعديل</label>
                                    </div>
                                    <div class="radio radio-primary radio-inline">
                                    <input type="radio" name="${value['id']}"  id="${value['id']}" value="لم يجرى عليه">
                                    <label for="${value['id']}"> لم يجرى عليه تعديل </label>
                                    </div>
                                </td>
                            </tr>
                        </div>
                        `);
                        } else {
                            $('#custom_fields').append(`
                        <div class="form-group">
                        <label for="${value['id']}" class="control-label">${value['name']}</label>
                        <input type="text" id="${value['id']}" name="${value['id']}"  class="form-control kb-search-input" value="">
                        </div>
                        `);
                        }
                    }
                });
                $('#custom_fields').append(`
                    <div class="form-group">
                    <label for="search_text" class="control-label">الكلمات المراد البحث عنها</label>
                    <input type="text" id="search_text" name="search_text"  class="form-control kb-search-input">
                    </div>
                `);
            }
        });
    }

    function get_search() {
        var text = $('#search').val();
        var custom_id = $('#custom_fields').val();
        var type = $('#main_group').val();
        $.ajax({
            url: '<?php echo site_url("Knowledge_base/get_search_results_ajax/"); ?>',
            type: 'POST',
            data: {
                text: text,
                custom_id: custom_id,
                type: type
            },
            success: function (data) {
                $('#list').html('');
                $('#list').append(`<div class="mtop10 tc-content kb-article-content">`);
                response = JSON.parse(data);
                $.each(response, function (key, value) {
                    // if (custom_id != 0)
                    $('#list').append(`<li class="mtop5 list-group-item"><a href="${value['link']}" target="_blank"><h4>${value['name']}</h4></a><h5 style="color: rgb(0,0,0)">${value['title']}</h5><p style="color: rgb(0,0,0)">${value['description']}</p></li>`);
                    // else
                    //     $('#list').append(`<li class="mtop5 list-group-item"><a href="${value['link']}" target="_blank"><h4>${value['name']}</h4></a></li>`);
                });
                $('#list').append(`</div>`);
            }
        });
    }

    function search() {
        alert('dakhd');
    }
    function empty_searche() {
        for (var i=1;i<50;i++){
            if(i==4 || i==5)continue;
            $(`#${i}`).val('');
        }
        $(`#search_text`).val('');
    }
</script>