function add_hr_template(rel_type, rel_id) {
    $('#modal-wrapper').load(admin_url + 'hr/contracts/modal', {
        slug: 'new',
        rel_type: rel_type,
        rel_id: rel_id,
    }, function () {
        if ($('#TemplateModal').is(':hidden')) {
            $('#TemplateModal').modal({
                backdrop: 'static',
                show: true
            });
        }
        appValidateForm($('#template-form'), {
            name: 'required'
        });
        tinymce.remove('#content');
        init_editor('#content');
    });
}
function delete_hr_template(wrapper, rel_type, id) {
    if (confirm_delete()) {
        $.post(admin_url + 'hr/contracts/delete_hr_template/' + id).done(function (response) {
            response = JSON.parse(response);

            if (response.success === true || response.success == 'true') {
                if (rel_type === 'proposals') {
                    $(wrapper).parents('.proposal-templates-wrapper').html("");
                } else if (rel_type === 'hr_contracts') {
                    $(wrapper).parents('.contract-templates-wrapper').html("");
                }

                get_hr_templates(rel_type);
            }
        })
    }
}
// Hr Templates Js
function get_hr_templates(rel_type, rel_id) {
    if (rel_type === 'proposals') {
        $('#proposal-templates').load(admin_url + 'templates', {
            rel_type: rel_type,
            rel_id: rel_id
        });
    } else if (rel_type === 'hr_contracts') {
        $('#contract-templates').load(admin_url + 'templates', {
            rel_type: rel_type,
            rel_id: rel_id
        });
    }
}
function edit_hr_template(rel_type, id, rel_id) {
    $('#modal-wrapper').load(admin_url + 'hr/contracts/modal', {
        slug: 'edit',
        id: id,
        rel_type: rel_type,
        rel_id: rel_id,
    }, function () {
        if ($('#TemplateModal').is(':hidden')) {
            $('#TemplateModal').modal({
                backdrop: 'static',
                show: true
            });
        }
        appValidateForm($('#template-form'), {
            name: 'required'
        });
        tinymce.remove('#content');
        init_editor('#content');
    });
}