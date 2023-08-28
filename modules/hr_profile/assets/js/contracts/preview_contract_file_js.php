<script>

    //contract preview file
    function preview_file_staff(invoker) {
        'use strict';

        var id = $(invoker).attr('id');
        var rel_id = $(invoker).attr('rel_id');
        view_hrmstaff_file(id, rel_id);
    }

    //function view hrm_file
    function view_hrmstaff_file(id, rel_id) {
        'use strict';

        $('#contract_file_data').empty();
        $("#contract_file_data").load(admin_url + 'hr_profile/hrm_file_contract/' + id + '/' + rel_id, function (response, status, xhr) {
            if (status == "error") {
                alert_float('danger', xhr.statusText);
            }
        });
    }

    var contract_id = '<?php echo $contracts->id_contract; ?>';

    var _templates = [];

    var editor_settings = {
        selector: 'div.editable',
        inline: true,
        theme: 'inlite',
        relative_urls: false,
        remove_script_host: false,
        inline_styles: true,
        verify_html: false,
        cleanup: false,
        apply_source_formatting: false,
        valid_elements: '+*[*]',
        valid_children: "+body[style], +style[type]",
        file_browser_callback: elFinderBrowser,
        table_default_styles: {
            width: '100%'
        },
        fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
        pagebreak_separator: '<p pagebreak="true"></p>',
        plugins: [
            'advlist pagebreak autolink autoresize lists link image charmap hr',
            'searchreplace visualblocks visualchars code',
            'media nonbreaking table contextmenu',
            'paste textcolor colorpicker'
        ],
        autoresize_bottom_margin: 50,
        insert_toolbar: 'image media quicktable | bullist numlist | h2 h3 | hr',
        selection_toolbar: 'save_button bold italic underline superscript | forecolor backcolor link | alignleft aligncenter alignright alignjustify | fontselect fontsizeselect h2 h3',
        contextmenu: "image media inserttable | cell row column deletetable | paste pastetext searchreplace | visualblocks pagebreak charmap | code",
        setup: function (editor) {

            editor.addCommand('mceSave', function () {
                save_contract_content(true);
            });

            editor.addShortcut('Meta+S', '', 'mceSave');

            editor.on('MouseLeave blur', function () {
                if (tinymce.activeEditor.isDirty()) {
                    save_contract_content();
                }
            });

            editor.on('MouseDown ContextMenu', function () {
                if (!is_mobile() && !$('.left-column').hasClass('hide')) {
                    contract_full_view();
                }
            });

            editor.on('blur', function () {
                $.Shortcuts.start();
            });

            editor.on('focus', function () {
                $.Shortcuts.stop();
            });

        }
    }

    if (_templates.length > 0) {
        editor_settings.templates = _templates;
        editor_settings.plugins[3] = 'template ' + editor_settings.plugins[3];
        editor_settings.contextmenu = editor_settings.contextmenu.replace('inserttable', 'inserttable template');
    }

    if (is_mobile()) {

        editor_settings.theme = 'modern';
        editor_settings.mobile = {};
        editor_settings.mobile.theme = 'mobile';
        editor_settings.mobile.toolbar = _tinymce_mobile_toolbar();

        editor_settings.inline = false;
        window.addEventListener("beforeunload", function (event) {
            if (tinymce.activeEditor.isDirty()) {
                save_contract_content();
            }
        });
    }

    tinymce.init(editor_settings);


    function insert_merge_field(field) {
        var key = $(field).text();
        tinymce.activeEditor.execCommand('mceInsertContent', false, key);
    }

    function contract_full_view() {
        $('.left-column').toggleClass('hide');
        $('.right-column').toggleClass('col-md-7');
        $('.right-column').toggleClass('col-md-12');
        $(window).trigger('resize');
    }


    function save_contract_content(manual) {
        var editor = tinyMCE.activeEditor;
        var data = {};
        data.contract_id = contract_id;
        data.content = editor.getContent();
        $.post(admin_url + 'hr_profile/save_hr_contract_data', data).done(function (response) {
            response = JSON.parse(response);
            if (typeof (manual) != 'undefined') {

                // Show some message to the user if saved via CTRL + S
                alert_float('success', response.message);

            }
            // Invokes to set dirty to false
            editor.save();
        }).fail(function (error) {
            var response = JSON.parse(error.responseText);
            alert_float('danger', response.message);
        });
    }

    function add_node() {
        if ($("#description_id").val() == '') {
            alert_float('danger', 'description');
        } else {
            var data = {};
            data.contract_id = contract_id;
            data.content = $("#description_id").val();
            $.post(admin_url + 'hr_profile/add_note', data).done(function (response) {
                response = JSON.parse(response);
                $('#tbody-notes').append(`
            <tr id="note-${response.id}">
                <td width="80%">
                   ${response.content}
                </td>
                <td>
                    <a href="#" class="btn btn-default btn-icon" onclick="get_update_note(${response.id});return false;"><i class="fa fa-pencil-square-o"></i></a>
                    <a href="#" onclick="delete_note(${response.id});return false;" class="btn btn-danger btn-icon "><i class="fa fa-remove"></i></a>
                </td>
            </tr>
        `);
                $("#description_id").val('');
                alert_float('success', 'added successfuly');
            })
        }
    }

    function delete_note(id) {
        if (confirm_delete()) {
            var data = {};
            $.post(admin_url + 'hr_profile/delete_note/' + id, data).done(function (response) {
                if (response) {
                    alert_float('success', 'delete successfuly');
                    $(`#note-${id}`).html('');
                } else {
                    alert_float('danger', 'somthing went rong');
                }
            })
        }
    }

    function update_note(id) {
        if ($("#description_id").val() == '') {
            alert_float('danger', 'description');
        } else {
            var data = {};
            data.contract_id = contract_id;
            data.content = $("#description_id").val();
            $.post(admin_url + 'hr_profile/update_note/' + id, data).done(function (response) {
                if (response) {
                    alert_float('success', 'updated successfuly');
                    $(`#note-${id}`).remove();
                    $('#tbody-notes').append(`
            <tr id="note-${id}">
                <td width="80%">
                   ${$("#description_id").val()}
                </td>
                <td>
                    <a href="#" class="btn btn-default btn-icon"  onclick="get_update_note(${id});return false;"><i class="fa fa-pencil-square-o"></i></a>
                    <a href="#" onclick="delete_note(${id});return false;" class="btn btn-danger btn-icon "><i class="fa fa-remove"></i></a>
                </td>
            </tr>
        `);
                    $("#description_id").val('');
                    $("#button_note").html(``);
                    $("#button_note").html(`
                        <button onclick="add_node()" type="button" class="btn btn-info mtop15 mbot15">إضافة ملاحظة</button>
                    `);
                } else {
                    alert_float('danger', 'somthing went rong');
                }
            })
        }
    }

    function get_update_note(id) {
        $.post(admin_url + 'hr_profile/get_note/' + id).done(function (response) {
            response = JSON.parse(response);
            if (response) {
                $("#description_id").val(response.content);
                $("#button_note").html(``);
                $("#button_note").html(`
                        <button onclick="update_note(${id})" type="button" class="btn btn-info mtop15 mbot15">حفظ</button>
                `);
            } else {
                alert_float('danger', 'somthing went rong');
            }
        })
    }

    function add_comment() {
        if ($("#comment_content_id").val() == '') {
            alert_float('danger', 'description');
        } else {
            var data = {};
            data.contract_id = contract_id;
            data.content = $("#comment_content_id").val();
            $.post(admin_url + 'hr_profile/add_comment', data).done(function (response) {
                response = JSON.parse(response);
                $('#tbody-comments').append(`
            <tr id="comment-${response.id}">
                <td width="80%">
                   ${response.content}
                </td>
                <td>
                    <a href="#" class="btn btn-default btn-icon" onclick="get_update_comment(${response.id});return false;"><i class="fa fa-pencil-square-o"></i></a>
                    <a href="#" onclick="delete_comment(${response.id});return false;" class="btn btn-danger btn-icon "><i class="fa fa-remove"></i></a>
                </td>
            </tr>
        `);
                $("#comment_content_id").val('');
                alert_float('success', 'added successfuly');
            })
        }
    }

    function delete_comment(id) {
        if (confirm_delete()) {
            var data = {};
            $.post(admin_url + 'hr_profile/delete_comment/' + id, data).done(function (response) {
                if (response) {
                    alert_float('success', 'delete successfuly');
                    $(`#comment-${id}`).html('');
                } else {
                    alert_float('danger', 'somthing went rong');
                }
            })
        }
    }

    function update_comment(id) {
        if ($("#comment_content_id").val() == '') {
            alert_float('danger', 'description');
        } else {
            var data = {};
            data.contract_id = contract_id;
            data.content = $("#comment_content_id").val();
            $.post(admin_url + 'hr_profile/update_comment/' + id, data).done(function (response) {
                if (response) {
                    alert_float('success', 'updated successfuly');
                    $(`#comment-${id}`).remove();
                    $('#tbody-comments').append(`
            <tr id="comment-${id}">
                <td width="80%">
                   ${$("#comment_content_id").val()}
                </td>
                <td>
                    <a href="#" class="btn btn-default btn-icon"  onclick="get_update_comment(${id});return false;"><i class="fa fa-pencil-square-o"></i></a>
                    <a href="#" onclick="delete_comment(${id});return false;" class="btn btn-danger btn-icon "><i class="fa fa-remove"></i></a>
                </td>
            </tr>
        `);
                    $("#comment_content_id").val('');
                    $("#button_comment").html(``);
                    $("#button_comment").html(`
                        <button onclick="add_comment()" type="button" class="btn btn-info mtop15 mbot15">إضافة تعليق</button>
                    `);
                } else {
                    alert_float('danger', 'somthing went rong');
                }
            })
        }
    }

    function get_update_comment(id) {
        $.post(admin_url + 'hr_profile/get_comment/' + id).done(function (response) {
            response = JSON.parse(response);
            if (response) {
                $("#comment_content_id").val(response.content);
                $("#button_comment").html(``);
                $("#button_comment").html(`
                        <button onclick="update_comment(${id})" type="button" class="btn btn-info mtop15 mbot15">حفظ</button>
                `);
            } else {
                alert_float('danger', 'somthing went rong');
            }
        })
    }

    Dropzone.autoDiscover = false;

    if ($('#contract-attachments-form').length > 0) {
        new Dropzone("#contract-attachments-form", appCreateDropzoneOptions({
            success: function (file, response) {
                $('#hr_contract_attachments').html('');
                $('#hr_contract_attachments').append(response);
                alert_float('success', 'updated successfuly');
            }
        }));
    }


    function delete_contract_attachment(wrapper, id) {
        'use strict';

        if (confirm_delete()) {
            $.get(admin_url + 'hr_profile/delete_contract_attachment_file/' + id, function (response) {
                if (response.success == true) {
                    $(wrapper).parents('.contract-attachment-wrapper').remove();

                    var totalAttachmentsIndicator = $('.attachments-indicator');
                    var totalAttachments = totalAttachmentsIndicator.text().trim();
                    if (totalAttachments == 1) {
                        totalAttachmentsIndicator.remove();
                    } else {
                        totalAttachmentsIndicator.text(totalAttachments - 1);
                    }
                } else {
                    alert_float('danger', response.message);
                }
            }, 'json');
        }
        return false;
    }

    function get_templates(rel_type, rel_id) {
        if (rel_type === 'hr_contracts') {
            $('#hr_contract-templates').load(admin_url + 'hr_profile/templates', {
                rel_type: rel_type,
                rel_id: rel_id
            });
        }
    }
    function insert_template(wrapper, rel_type, id) {
        requestGetJSON(admin_url + 'hr_profile/templates/index/' + id).done(function (response) {
            var data = response.data;
            tinymce.activeEditor.execCommand('mceInsertContent', false, data.content);
            if (rel_type == 'hr_contracts') {
                $('a[aria-controls="contract"]').click()
            }
            tinymce.activeEditor.focus();
        });
    }

    function add_template_renew(id) {
        $('#modal-renew').load(admin_url + 'hr_profile/modal_renew/' + id, function () {
            if ($('#renew_contract_modal').is(':hidden')) {
                $('#renew_contract_modal').modal({
                    backdrop: 'static',
                    show: true
                });
            }
        });
    }

    function add_renew(id) {
        if ($("#new_end_date").val() == '' || $("#new_start_date").val() == '') {
            alert_float('danger', 'description');
        } else {
            var data = {};
            data.contract_id = contract_id;
            data.new_start_date = $("#new_start_date").val();
            data.new_end_date = $("#new_end_date").val();

            $.post(admin_url + 'hr_profile/add_renew', data).done(function (response) {
                $('#renew_contract_modal').modal('hide');
                $(`#hr-contract-renews`).html('');
                $(`#hr-contract-renews`).append(response);
            });

        }

    }
    function delete_renewal(id) {
        if (confirm_delete()) {
            var data = {};
            $.post(admin_url + 'hr_profile/delete_renewal/' + id).done(function (response) {
                if (response) {
                    alert_float('success', 'delete successfuly');
                    $(`#renewl-${id}`).remove();
                } else {
                    alert_float('danger', 'somthing went rong');
                }
            })
        }
    }


</script>