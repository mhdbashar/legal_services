function get_subcat(list_id, id) {
    $('.div_subcat'+list_id+' #subcat_id').html('<option value="" selected disabled></option>');
    $.ajax({
        url: admin_url + 'LegalServices/LegalServices_controller/getChildCatModules/' + id,
        success: function (data) {
            response = JSON.parse(data);
            $.each(response, function (key, value) {
                $('.div_subcat'+list_id+' #subcat_id').append('<option value="' + value['id'] + '">' + value['name'] + '</option>');
            });
            $('.div_subcat'+list_id+' #subcat_id').selectpicker('refresh');
        }
    });
}

appValidateForm($('#add_list_form'), {
    cat_id: 'required',
});
