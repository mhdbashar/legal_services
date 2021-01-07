  (function(){
   "use strict";
   $(document).on("click",".btn-edit-datetime",function() {
    $(this).addClass('hide');
    $('.btn-close-edit-datetime').removeClass('hide');
    $("#clock_attendance_modal .curr_date .form-group").slideDown(500);
  });
   $(document).on("click",".btn-close-edit-datetime",function() {
     $(this).addClass('hide');
     $('.btn-edit-datetime').removeClass('hide');
     $('#clock_attendance_modal input[name="edit_date"]').val('');
     $("#clock_attendance_modal .curr_date .form-group").slideUp(500);
     var staff_id = $('#clock_attendance_modal input[name="staff_id"]').val();
     var date = submit_form();
     get_data_attendance(staff_id, date);
    $('#clock_attendance_modal input[name="edit_date"]').val('');
   });
 })(jQuery);
 function setDate(){
   "use strict";
   var today = new Date();
   var second = today.getSeconds();
   var secondDeg = ((second / 60) * 360) + 360; 
   $("#clock_attendance_modal #secondHand").css('transform','rotate('+secondDeg+'deg)');
   var minute = today.getMinutes();
   var minuteDeg = ((minute / 60) * 360); 
   $("#clock_attendance_modal #minuteHand").css('transform','rotate('+minuteDeg+'deg)');
   var hour = today.getHours();
   var hourDeg = ((hour / 12 ) * 360 ); 
   $("#clock_attendance_modal #hourHand").css('transform','rotate('+hourDeg+'deg)');
 }
 function open_check_in_out(){
   "use strict";
   $("#clock_attendance_modal .curr_date .form-group").slideUp(1);
   $(".btn-close-edit-datetime").click();
   setDate();
   setInterval(setDate, 1000);
   $('#clock_attendance_modal').modal('show');
   appValidateForm($('#timesheets-form-check-in'), {
     staff_id: 'required',
     date: 'required'
   })
   appValidateForm($('#timesheets-form-check-out'), {
     staff_id: 'required',
     date: 'required'
   })   
 }

 function updateClock() {
   "use strict";
   var currentTime = new Date();
   var currentHoursAP = currentTime.getHours();
   var currentHours = currentTime.getHours();
   var currentMinutes = currentTime.getMinutes();
   var currentSeconds = currentTime.getSeconds();
   currentMinutes = (currentMinutes < 10 ? "0" : "") + currentMinutes;
   currentSeconds = (currentSeconds < 10 ? "0" : "") + currentSeconds;
   var timeOfDay = (currentHours < 12) ? "AM" : "PM";
   currentHoursAP = (currentHours > 12) ? currentHours - 12 : currentHours;
   currentHoursAP = (currentHoursAP == 0) ? 12 : currentHoursAP;
   var currentTimeString =  currentHours + ":" + currentMinutes + ":" + currentSeconds;
   $('.time_script').text(currentTimeString);
   "use strict";
   $('input[name="hours"]').val(currentTimeString);
 }
 function changedate(el){
   "use strict";
   var date = $(el).val();
   $('#clock_attendance_modal input[name="edit_date"]').val(date);
   var staff_id = $('#clock_attendance_modal input[name="staff_id"]').val();
   date = submit_form();
   get_data_attendance(staff_id, date);
 }
 function changestaff_id(el){
   "use strict";
   var staff_id = $(el).val();
   $('#clock_attendance_modal input[name="staff_id"]').val(staff_id);
   var date = submit_form();
   get_data_attendance(staff_id, date);
 }
 function get_data_attendance(staff_id, date){
   "use strict";
   if(staff_id != ''){
     var data = {};
     data.staff_id = staff_id;
     data.date = date;
     $.post(admin_url+'timesheets/get_data_attendance',data).done(function(response){
      response = JSON.parse(response);
      $('#attendance_history').html('');
      $('#attendance_history').html(response.html_list);
    });
   }
 }
 function submit_form(){
  var val_date = $('#clock_attendance_modal input[name="edit_date"]').val();
  if(val_date == ''){
    var d = new Date();
    var month = d.getMonth()+1;
    var day = d.getDate();
    var output = d.getFullYear() + '-' +
    (month<10 ? '0' : '') + month + '-' +
    (day<10 ? '0' : '') + day +' '+
    d.getHours()+':'+
    d.getMinutes()+':'+
    d.getSeconds();
    $('#clock_attendance_modal input[name="edit_date"]').val(output);
    return output;
  }
  return val_date;
}