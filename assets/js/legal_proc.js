
function new_proc() {
    $('#legal_proc').modal('show');
    $('#legal_proc .edit-title').addClass('hide');
}

function get_subcat() {
    $('#subcat_id').html('');
    id = $('#cat_id').val();
    $.ajax({
        url: admin_url + 'LegalServices/LegalServices_controller/getChildCatModules/' + id,
        success: function (data) {
            response = JSON.parse(data);
            $.each(response, function (key, value) {
                $('#subcat_id').append('<option value="' + value['id'] + '">' + value['name'] + '</option>');
            });
        }
    });
}