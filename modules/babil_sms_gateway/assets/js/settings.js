
if(window.location.href.replace(admin_url, '') == 'settings?group=device_sms'){
    let sms_senders = "";

    $.ajax({
        type: 'Get',
        url: admin_url + 'babil_sms_gateway/get_senders',
        async: false,
        success: function(data) {

            sms_senders = JSON.parse(data).sms_senders;

        },

    });
    var arr =[];
    if(sms_senders != []){
        arr = JSON.parse(sms_senders);
    }

    var i=0;
    if (arr && arr.length != 0) {
        $.each(arr, function( index, value ) {
            $('#addr'+index).html("<td>"+ (index+1) +"</td><td><input name='sms_sender"+index+"' type='text' value='"+value+"'  class='form-control input-md'  /> </td>");

            $('#tab_logic').append('<tr id="addr'+(index+1)+'"></tr>');
            i = index+1;
        });

    } else {
        $('#addr'+i).html("<td>"+ (i+1) +"</td><td><input name='sms_sender"+i+"' type='text' placeholder='Sender' class='form-control input-md'  /> </td>");
        $('#tab_logic').append('<tr id="addr'+(i+1)+'"></tr>');
        i=1;
    }



    $("#add_row").click(function(){
        $('#addr'+i).html("<td>"+ (i+1) +"</td><td><input name='sms_sender"+i+"' type='text' placeholder='Sender' class='form-control input-md'  /> </td>");

        $('#tab_logic').append('<tr id="addr'+(i+1)+'"></tr>');
        i++;
    });
    $("#delete_row").click(function(){
        if(i>1){
            $("#addr"+(i-1)).html('');
            i--;
        }
    });
}
