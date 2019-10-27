
let lang = "english";
let dateType = "AD";
let isHijri = "off";
let hijriPages = "";
let adjust = "0";

$.ajax({
    type: 'Get',
    url: admin_url + 'My_custom_controller/get_date_options',
    async: false,
    success: function(data) {

        isHijri = JSON.parse(data).isHijri;
        lang = JSON.parse(data).lang;
        dateType = JSON.parse(data).mode;
        hijriPages = JSON.parse(data).hijri_pages;
    },

});


var current_url = window.location.href;
var daminURL= admin_url;
var this_page = current_url.replace(daminURL,'');

function isJson(data){
    try {
        JSON.parse(data);
    }catch (e) {
        return false;
    }
    return true;
}

function search_url(hijriPages, url){
    var i = 0;
    if(isJson(hijriPages)){
        $.each(JSON.parse(hijriPages), function (index, page) {
            if(url.search(page) != -1){
                i++
            }
        });
    }

    return i;
}

if(search_url(hijriPages,this_page) != 0){
    if((dateType == 'hijri') && (isHijri == "on") ) {
        if(true){

            function appDatepicker(e) {
                initHijrDatePicker();
            }

            function initHijrDatePicker() {
                let dateobj = document.getElementsByClassName('datepicker');
                let datetimeobj = document.getElementsByClassName('datetimepicker');

                $.each(datetimeobj, function (k, v) {


                    $(this).hijriDatePicker({
                        locale: "ar-sa",
                        hijriFormat:"iYYYY-iMM-iDD hh:mm",
                        //dayViewHeaderFormat: "MMMM YYYY",
                        //hijriDayViewHeaderFormat: "iMMMM iYYYY",
                        showSwitcher: false,
                        allowInputToggle: true,
                        showTodayButton: false,
                        useCurrent: true,
                        isRTL: false,
                        keepOpen: false,
                        hijri: true,
                        debug: true,
                        showClear: true,
                        showTodayButton: true,
                        showClose: true
                    });
                });
                $.each(dateobj, function (k, v) {
                    $(this).hijriDatePicker({
                        locale: "ar-sa",
                        //format: "DD-MM-YYYY",
                        //hijriFormat:"iYYYY-iMM-iDD",
                        //dayViewHeaderFormat: "MMMM YYYY",
                        //hijriDayViewHeaderFormat: "iMMMM iYYYY",
                        showSwitcher: false,
                        allowInputToggle: true,
                        showTodayButton: false,
                        useCurrent: true,
                        isRTL: false,
                        keepOpen: false,
                        hijri: true,
                        debug: true,
                        showClear: true,
                        showTodayButton: true,
                        showClose: true
                    });
                });
            }

            function initHijrDatePickerDefault() {

                $("#hijri-date-input").hijriDatePicker();
            }
        }
// When the user clicks anywhere outside of the modal, close it
        $(".datepicker").on("blur", function(e) {
            var addon = $(this).parent().children('.input-group-addon');
           $($(this)[0].nextSibling).toggle(false);
            addon.removeAttr('style');
        });
        $(".datepicker").on("click", function(e) {
            $($(this)[0].nextSibling).toggle(true);
        });
        $(".datetimepicker").on("blur", function(e) {
            $($(this)[0].nextSibling).toggle(false);
        });
        $(".datetimepicker").on("click", function(e) {
            $($(this)[0].nextSibling).toggle(true);
        });
    }
}else{

}

var hijri_page = window.location.href;
hijri_page = hijri_page.replace(admin_url,'');

if(hijri_page == 'settings?group=Hijri'){

    $(document).ready(function(){

        var isHijriVal = isHijri; // from database
        var Hijrichange = "off";
        var checked= false;
        if(isHijriVal == "on"){
            document.getElementById('hijri_check').checked =true;
            $(".toggle").removeClass('btn btn-light off');
            $(".toggle").addClass('btn btn-primary');
            $("#adjust_div").show();
            $("#tbl_div").show();


        }else{
            $("#adjust_div").hide();
            $("#tbl_div").hide();
        }

        $("#hijri_check").on('change', function () {
            checked = document.getElementById("hijri_check").checked;
            if(checked){
                Hijrichange ="on";
            }else {
                Hijrichange = "off";
            }

            if(Hijrichange == "on"){
                $("#adjust_div").show();
                $("#tbl_div").show();
            }else{
                $("#adjust_div").hide();
                $("#tbl_div").hide();
            }

        });
        var arr =[];
        if(hijriPages != []){
            arr = JSON.parse(hijriPages);
        }

        var i=0;
        if (arr && arr.length != 0) {
            $.each(arr, function( index, value ) {
                $('#addr'+index).html("<td>"+ (index+1) +"</td><td><input name='link"+index+"' type='text' value='"+value+"'  class='form-control input-md'  /> </td>");

                $('#tab_logic').append('<tr id="addr'+(index+1)+'"></tr>');
                i = index+1;
            });

        } else {
            $('#addr'+i).html("<td>"+ (i+1) +"</td><td><input name='link"+i+"' type='text' placeholder='Link' class='form-control input-md'  /> </td>");
            $('#tab_logic').append('<tr id="addr'+(i+1)+'"></tr>');
            i=1;
        }



        $("#add_row").click(function(){
            $('#addr'+i).html("<td>"+ (i+1) +"</td><td><input name='link"+i+"' type='text' placeholder='Link' class='form-control input-md'  /> </td>");

            $('#tab_logic').append('<tr id="addr'+(i+1)+'"></tr>');
            i++;
        });
        $("#delete_row").click(function(){
            if(i>1){
                $("#addr"+(i-1)).html('');
                i--;
            }
        });

    });
    $(document).on('click',"#btn_add_adjust", function () {

        var month = $('#month_adj').val();
        var year = $('#year_adj').val();
        $.ajax({
            type: 'Get',
            url: admin_url + 'My_custom_controller/add_adjust_form',
            data: {
                add_month : month,
                add_year : year,
            },
            success: function(data) {
                $('#add_form_adj').append(data);

                $("#btn_add_adjust").attr('disabled','disabled');
            },

        });

    });

    $(document).on('click',"#add_adjust_action", function () {

        $(this).attr('disabled','disabled');

        var month = $('#month_adj').val();
        var year = $('#year_adj').val();
        var target_value = $('#target_adjust').val();
        $.ajax({
            type: 'Get',
            url: admin_url + 'My_custom_controller/set_hijri_adjust',
            data: {
                add_month : month,
                add_year : year,
                add_value: target_value,
            },
            success: function(data) {
                var res_data = JSON.parse(data);
                $('#new_adjustement').append(res_data.new);
                $('#txt_adj').val(res_data.adjdata);
                $('#adjust_data').val(res_data.adjdata);



            },

        });

    });

    $(document).on('click',"#cancel_btn", function () {
        $(this).parents('#form_div').hide();
        $("#btn_add_adjust").attr('disabled',false);

    });

    $(document).on('click',"#delete_btn", function () {
        $(this).parents('#delete_div').hide();
        var month = $(this).data('month');
        var year = $(this).data('year');

        $.ajax({
            type: 'Get',
            url: admin_url + 'My_custom_controller/delete_hijri_adjust',
            data: {
                del_month : month,
                del_year : year,
            },
            success: function(data) {
                var res_data = JSON.parse(data);
                $('#new_adjustement').append(res_data.new);
                $('#txt_adj').val(res_data.adjdata);
                $('#adjust_data').val(res_data.adjdata);
            },

        });
    });

    $(document).on('click',"#delete_his_btn", function () {
        var month = $(this).data('month');
        var year = $(this).data('year');

        $.ajax({
            type: 'Get',
            url: admin_url + 'My_custom_controller/delete_hijri_adjust',
            data: {
                del_month : month,
                del_year : year,
            },
            success: function(data) {
                var res_data = JSON.parse(data);
                $('#txt_adj').val(res_data.adjdata);
                $('#adjust_data').val(res_data.adjdata);
            },

        });
        $('#delete_his_div').hide();
    });
}