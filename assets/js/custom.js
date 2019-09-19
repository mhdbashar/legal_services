
let lang = "english";
let dateType = "AD";
let isHijri = "off";
let hijriPages = "";
let adjust = "0";
// console.log(datetimeobj);
// let h = new HijriDate();
// console.log(h.int());

$.ajax({
    type: 'Get',
    url: admin_url + 'My_custom_controller/get_date_options',
    async: false,
    // data: ['<?php echo get_instance()->security->get_csrf_token_name();?> : <?php echo get_instance()->security->get_csrf_hash(); ?>'],
    success: function(data) {
        // console.log(JSON.parse(data).lang)
        isHijri = JSON.parse(data).isHijri;
        // console.log(isHijri);
        lang = JSON.parse(data).lang;
        dateType = JSON.parse(data).mode;
        // comment = JSON.parse(comment);
        hijriPages = JSON.parse(data).hijri_pages;
        // adjust = JSON.parse(data).adjust;
        // success(comment)
        console.log(dateType)
    },

});

// console.log(adjust);
var current_url = window.location.href;
var daminURL= admin_url;
var this_page = current_url.replace(daminURL,'');
// this_page =this_page.replace('/','\\/');   // to solve backslash in database
function isJson(data){
    try {
        JSON.parse(data);
    }catch (e) {
        return false;
    }
    return true;
}

console.log(isJson(hijriPages));
function search_url(hijriPages, url){
    var i = 0;
    if(isJson(hijriPages)){
        $.each(JSON.parse(hijriPages), function (index, page) {
            if(url.search(page) != -1){
                i++
            }
            // console.log(page);
        });
    }

    return i;
}
console.log(search_url(hijriPages,this_page),hijriPages,this_page);

if(search_url(hijriPages,this_page) != 0){
    if((dateType == 'hijri') && (isHijri == "on") ) {
        // console.log(dateType);
        function appDatepicker(e) {
            // console.log(app.options.date_format);
            let obj = document.getElementsByClassName('datepicker');
            let datetimeobj = document.getElementsByClassName('datetimepicker');
            let icon = document.getElementsByClassName('calendar-icon');
            let isDatetime = false;

            // console.log(dateType);
            $.each(obj, function (k, v) {
                // console.log($(this).parent().find('.calendar-icon')[0]);
                let icon = $(this).parent().find('.calendar-icon')[0]

                v.onclick = icon.onclick = function () {
                    // picker.setHijriMode('h');
                    isDatetime = false;
                    pickDate(event, isDatetime);
                    picker.setLanguage(lang);
                    if (dateType == 'hijri') {
                        picker.setHijriMode(true);
                    } else {
                        picker.setHijriMode(false);
                    }

                    picker.onPicked = function () {


                        let elgd = document.getElementById(v.id);
                        // elgd.value=picker.getPickedDate().getDateString();

                        let date = picker.getPickedDate();
                        // console.log(elgd.value.split('ميلادي')[0]);

                        // let formattedDaten = HijriDate.toNDigit(date.getDate(),2)+'-'+
                        //     HijriDate.toNDigit(date.getMonth()+1,2)+'-'+
                        //     HijriDate.toNDigit(date.getFullYear(),4);
                        let formattedDaten = HijriDate.toNDigit(date.getFullYear(), 4) + '-' +
                            HijriDate.toNDigit(date.getMonth() + 1, 2) + '-' +
                            HijriDate.toNDigit(date.getDate(), 2);
                        // console.log(formattedDaten)
                        elgd.value = formattedDaten;
                        // elgd.value = formattedDaten+' '+ $('#mytime').val();


                        // if(dateType == 'hijri'){
                        //
                        // }else{
                        //     var date = elgd.value;
                        //     Date.parse(date.split('ميلادي')[0]);
                        // }

                        // let elhd=document.getElementById('deadline');
                        // if(picker.getPickedDate() instanceof Date){
                        //     elgd.value=picker.getPickedDate().getDateString();
                        //     // elhd.value=picker.getOppositePickedDate().getDateString()
                        // }else{
                        //     // elhd.value=picker.getPickedDate().getDateString();
                        //     elgd.value=picker.getOppositePickedDate().getDateString()
                        // }
                    };

                }
            });

            $.each(datetimeobj, function (k, v) {
                // console.log($(this).parent().find('.calendar-icon')[0]);
                let icon = $(this).parent().find('.calendar-icon')[0]

                v.onclick = icon.onclick = function () {
                    // picker.setHijriMode('h');
                    isDatetime = true;
                    pickDate(event, isDatetime);
                    picker.setLanguage(lang);
                    if (dateType == 'hijri') {
                        picker.setHijriMode(true);
                    } else {
                        picker.setHijriMode(false);
                    }

                    picker.onPicked = function () {


                        let elgd = document.getElementById(v.id);
                        // elgd.value=picker.getPickedDate().getDateString();

                        let date = picker.getPickedDate();
                        // console.log(elgd.value.split('ميلادي')[0]);

                        // let formattedDaten = HijriDate.toNDigit(date.getDate(),2)+'-'+
                        //     HijriDate.toNDigit(date.getMonth()+1,2)+'-'+
                        //     HijriDate.toNDigit(date.getFullYear(),4);
                        let formattedDaten = HijriDate.toNDigit(date.getFullYear(), 4) + '-' +
                            HijriDate.toNDigit(date.getMonth() + 1, 2) + '-' +
                            HijriDate.toNDigit(date.getDate(), 2);
                        // console.log(formattedDaten)
                        // elgd.value = formattedDaten;
                        elgd.value = formattedDaten + ' ' + $('#mytime').val();
                        // console.log(elgd.value)


                        // if(dateType == 'hijri'){
                        //
                        // }else{
                        //     var date = elgd.value;
                        //     Date.parse(date.split('ميلادي')[0]);
                        // }

                        // let elhd=document.getElementById('deadline');
                        // if(picker.getPickedDate() instanceof Date){
                        //     elgd.value=picker.getPickedDate().getDateString();
                        //     // elhd.value=picker.getOppositePickedDate().getDateString()
                        // }else{
                        //     // elhd.value=picker.getPickedDate().getDateString();
                        //     elgd.value=picker.getOppositePickedDate().getDateString()
                        // }
                    };

                }
            });


            'use strict';
            let picker = new Datepicker();
            let pickElm = picker.getElement();
            let pLeft = 200;
            let pWidth = 300;
            pickElm.style.position = 'absolute';
            pickElm.style.left = pLeft + 'px';
            pickElm.style.top = '172px';
            pickElm.style.zIndex = 99999;
            picker.attachTo(document.body);


            function openSidebar() {
                document.getElementById("mySidebar").style.display = "block"
            }

            function closeSidebar() {
                document.getElementById("mySidebar").style.display = "none"
            }

            function dropdown(el) {
                if (el.className.indexOf('expanded') == -1) {
                    el.className = el.className.replace('collapsed', 'expanded');
                } else {
                    el.className = el.className.replace('expanded', 'collapsed');
                }
            }

            function selectLang(el) {
                el.children[0].checked = true;
                picker.setLanguage(el.children[0].value);
            }

            function setFirstDay(fd) {
                picker.setFirstDayOfWeek(fd)
            }

            function setYear() {
                let el = document.getElementById('valYear');
                picker.setFullYear(el.value)
            }

            function setMonth() {
                let el = document.getElementById('valMonth');
                picker.setMonth(el.value)
            }

            function updateWidth(el) {
                pWidth = parseInt(el.value);
                if (!fixWidth()) {
                    document.getElementById('valWidth').value = pWidth;
                    picker.setWidth(pWidth)
                }
            }

            function pickDate(ev, isDatetime) {
                ev = ev || window.event;
                let el = ev.target || ev.srcElement;
                pLeft = ev.pageX;
                fixWidth();
                pickElm.style.top = ev.pageY + 'px';
                picker.setHijriMode(el.id == 'hijrDate');

                if (isDatetime) {
                    var today = new Date();
                    var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
                    var full_time = time.toLocaleString('en-US', {hour: 'numeric', minute: 'numeric', hour12: true})

                    // to avoid any problem if there any modal
                    $(document).off('focusin.modal');
                    //////////////////////////////////

                    var x = document.createElement('div');
                    x.setAttribute("id", "dev_time");
                    x.style.width = "100%";
                    x.style.backgroundColor = "white";
                    // x.style.zIndex = 99999;
                    // x.style.marginLeft ="25%";

                    t = document.createElement('input');
                    t.style.width = "50%";
                    t.style.marginLeft = "25%";
                    t.style.marginTop = "2%";
                    t.style.marginBottom = "2%";
                    t.style.border = "none";
                    // t.style.backgroundColor ="transparent";
                    // t.style.zIndex = 9999999;
                    // t.style.webkitAppearance="none";
                    // t.style.color="transparent";
                    t.setAttribute("type", "time");
                    t.setAttribute("id", "mytime");
                    t.setAttribute("value", full_time);
                    t.setAttribute("step", "2");

                    // t.css(
                    //     '-webkit-clear-button':'display'
                    // );

                    // console.log(full_time);
                    if (document.getElementById("mytime")) {
                        // console.log(isDatetime+'gfhfg');

                        var timeChild = document.getElementById("mytime");
                        timeChild.parentNode.removeChild(timeChild);
                    }


                    document.getElementsByClassName('zulns-datepicker')[0].appendChild(x);
                    document.getElementsByClassName('zulns-datepicker')[0].lastChild.appendChild(t);

                } else {
                    if (document.getElementById("mytime")) {
                        // console.log(isDatetime+'gfhfg');

                        var timeChild = document.getElementById("mytime");
                        timeChild.parentNode.removeChild(timeChild);
                    }
                }


                picker.show();
                el.blur()
            }

            function gotoToday() {
                picker.today()
            }

            function setTheme() {
                let el = document.getElementById('txtTheme');
                let n = parseInt(el.value);
                if (!isNaN(n)) picker.setTheme(n);
                else picker.setTheme(el.value)
            }

            function newTheme() {
                picker.setTheme()
            }

            function fixWidth() {
                let docWidth = document.body.offsetWidth;
                let isFixed = false;
                if (pLeft + pWidth > docWidth) pLeft = docWidth - pWidth;
                if (docWidth >= 992 && pLeft < 200) pLeft = 200;
                else if (docWidth < 992 && pLeft < 0) pLeft = 0;
                if (pLeft + pWidth > docWidth) {
                    pWidth = docWidth - pLeft;
                    picker.setWidth(pWidth);
                    document.getElementById('valWidth').value = pWidth;
                    document.getElementById('sliderWidth').value = pWidth;
                    isFixed = true
                }
                pickElm.style.left = pLeft + 'px';
                return isFixed
            }
        }
    }
}else{
    console.log('noooooooo')

}

var hijri_page = window.location.href;
hijri_page = hijri_page.replace(admin_url,'');

if(hijri_page == 'settings?group=Hijri'){
    console.log(hijri_page)
// $(document).on('click', '.flip-button', function () {
//
// })
//     var url = admin_url + 'My_custom_controller/set_option'
//     $('settings-form').attr('action', url);
//     function toggleStatus() {
//         console.log( 'sdjhfjksdhkf' );
//         // if ($('#toggleElement').is(':checked')) {
//         //     $('#idOfTheDIV :input').attr('disabled', true);
//         // } else {
//         //     $('#idOfTheDIV :input').removeAttr('disabled');
//         // }
//     }


    $(document).ready(function(){

        var isHijriVal = isHijri; // from database
        var Hijrichange = "off";
        var checked= false;
        console.log( isHijriVal );
        if(isHijriVal == "on"){
            // $("#hijri_check").attr('checked') = "checked";
            document.getElementById('hijri_check').checked =true;
            // console.log($("input[name=hijri_adjust]"));
            //
            // var radios = $("input[name=hijri_adjust]");
            // $.each(radios,function(v,radio){
            //
            //     if(radio.value == adjust){
            //         radio.checked = true
            //     }
            // })
            //
            // console.log($("input[name=hijri_adjust][value="+1+"]"));

            // console.log(document.getElementById('hijri_check').checked =true );
            $(".toggle").removeClass('btn btn-light off');
            $(".toggle").addClass('btn btn-primary');
            $("#adjust_div").show();
            $("#tbl_div").show();


        }else{

            // document.getElementById("tbl_div").disabled = true;
            // var nodes = document.getElementById("tbl_div").getElementsByTagName('*');
            // for(var i = 0; i < nodes.length; i++){
            //     nodes[i].disabled = true;
            // }
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

                // document.getElementById("tbl_div").disabled = true;
                // var nodes = document.getElementById("tbl_div").getElementsByTagName('*');
                // for(var i = 0; i < nodes.length; i++){
                //     nodes[i].disabled = true;
                // }
                $("#adjust_div").hide();
                $("#tbl_div").hide();
            }

        });

        console.log(hijriPages);
        var arr =[];
        if(hijriPages != []){
            arr = JSON.parse(hijriPages);//['sdsd','ddd','swwwwwsd','seeeeeesd'];
            console.log('notejn')
        }

        var i=0;
        if (arr && arr.length != 0) {
            $.each(arr, function( index, value ) {
                // console.log( index + ": " + value );
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
    // $('#year_adj').hide();
    
    $("#btn_add_adjust").click(function(){
        console.log('btn_add_adjust')
        var month = $('#month_adj').val();
        var year = $('#year_adj').val();
        // $('#year_adj').show();
        $.ajax({
                type: 'Get',
                url: admin_url + 'My_custom_controller/add_adjust_form',
                // async: false,
                data: {
                    add_month : month,
                    add_year : year,
                },
                success: function(data) {
                    $('#add_form_adj').append(data);
                    console.log(document.getElementById('add_adjust_action'));

                    // $(document).on('click',"#add_adjust_action", function () {
                    //     console.log('add_adjust_action')
                    //     // var month = $('#month_adj').val();
                    //     // var year = $('#year_adj').val();
                    //     // var target_value = $('#target_adjust').val();
                    //     // $.ajax({
                    //     //     type: 'Get',
                    //     //     url: admin_url + 'My_custom_controller/set_hijri_adjust',
                    //     //     // async: false,
                    //     //     data: {
                    //     //         add_month : month,
                    //     //         add_year : year,
                    //     //         add_value: target_value,
                    //     //     },
                    //     //     success: function(data) {
                    //     //
                    //     //         // $('#add_form_adj').append(data);
                    //     //     },
                    //
                    //     // });
                    // });
                },

            });
    });

    $(document).on('click',"#add_adjust_action", function () {
            // console.log('add_adjust_action')
            var month = $('#month_adj').val();
            var year = $('#year_adj').val();
            var target_value = $('#target_adjust').val();
            $.ajax({
                type: 'Get',
                url: admin_url + 'My_custom_controller/set_hijri_adjust',
                // async: false,
                data: {
                    add_month : month,
                    add_year : year,
                    add_value: target_value,
                },
                success: function(data) {
                    var res_data = JSON.parse(data);
                    console.log($(this).parent());
                    $('#new_adjustement').append(res_data.new);
                    $('#txt_adj').val(res_data.adjdata);
                    $('#adjust_data').val(res_data.adjdata);



                },

            });

        });

    $(document).on('click',"#cancel_btn", function () {

        // console.log($(this).parent());
        $('#form_div').hide();
    });

    $(document).on('click',"#delete_btn", function () {
        // console.log($(this).data('month'))
        var month = $(this).data('month');
        var year = $(this).data('year');
        // var target_value = $('#target_adjust').val();

        $.ajax({
            type: 'Get',
            url: admin_url + 'My_custom_controller/delete_hijri_adjust',
            // async: false,
            data: {
                del_month : month,
                del_year : year,
            },
            success: function(data) {
                var res_data = JSON.parse(data);
                console.log(JSON.parse(data).adjdata);
                $('#new_adjustement').append(res_data.new);
                $('#txt_adj').val(res_data.adjdata);
                $('#adjust_data').val(res_data.adjdata);
            },

        });
        // console.log($(this).parent());
        $('#delete_div').hide();
    });

    $(document).on('click',"#delete_his_btn", function () {
        // console.log($(this).data('month'))
        var month = $(this).data('month');
        var year = $(this).data('year');
        // var target_value = $('#target_adjust').val();

        $.ajax({
            type: 'Get',
            url: admin_url + 'My_custom_controller/delete_hijri_adjust',
            // async: false,
            data: {
                del_month : month,
                del_year : year,
            },
            success: function(data) {
                var res_data = JSON.parse(data);
                // console.log(JSON.parse(data).adjdata);
                // $('#new_adjustement').append(res_data.new);
                $('#txt_adj').val(res_data.adjdata);
                $('#adjust_data').val(res_data.adjdata);
            },

        });
        console.log($(this).parent());
        // $(this).parent().hide();
        $('#delete_his_div').hide();
    });


    $(document).on('click',"#update_btn", function () {
        // console.log($(this).data('month'))
        var month = $(this).data('month');
        var year = $(this).data('year');
        // var target_value = $('#target_adjust').val();

        $.ajax({
            type: 'Get',
            url: admin_url + 'My_custom_controller/update_hijri_adjust',
            // async: false,
            data: {
                del_month : month,
                del_year : year,
            },
            success: function(data) {
                // var res_data = JSON.parse(data);
                // console.log(JSON.parse(data).adjdata);
                // $('#new_adjustement').append(res_data.new);
                // $('#txt_adj').val(res_data.adjdata);
                // $('#adjust_data').val(res_data.adjdata);


            },

        });
    });

    // $("#add_adjust_action").click(function(){
    //     console.log('gdsfsd');
    //     var month = $('#month_adj').val();
    //     var year = $('#year_adj').val();
    //     var target_value = $('#target_adjust').val();
    //     $.ajax({
    //         type: 'Get',
    //         url: admin_url + 'My_custom_controller/set_hijri_adjust',
    //         // async: false,
    //         data: {
    //             add_month : month,
    //             add_year : year,
    //             add_value: target_value,
    //         },
    //         success: function(data) {
    //
    //             // $('#add_form_adj').append(data);
    //         },
    //
    //     });
    // });
    
    // $.ajax({
    //     type: 'Get',
    //     url: admin_url + 'My_custom_controller/set_hijri_adjust',
    //     // async: false,
    //     // data: ['<?php echo get_instance()->security->get_csrf_token_name();?> : <?php echo get_instance()->security->get_csrf_hash(); ?>'],
    //     success: function(data) {
    //
    //     },
    //
    // });
    // $(document).on('submit','settings-form',function(){
    //     console.log('sfdhjkshf')
    //     $.ajax({
    //         type: 'post',
    //         url: admin_url + 'My_custom_controller/set_option',
    //
    //         // data: ['<?php echo get_instance()->security->get_csrf_token_name();?> : <?php echo get_instance()->security->get_csrf_hash(); ?>'],
    //         success: function(data) {
    //             // console.log(JSON.parse(data).lang)
    //             lang = JSON.parse(data).lang;
    //             dateType = JSON.parse(data).mode;
    //             // comment = JSON.parse(comment);
    //             // success(comment)
    //
    //         },
    //
    //     });
    // });
    // $('settings-form').onsubmit  = function(){
    //
    // };
}