$(document).ready(function(){
    initHijrDatePicker();

    // const node = document.querySelector('[title="Close the picker"]');
    //
    //
    // console.log(node)
});

function appDatepicker(e) {
    initHijrDatePicker();
}
function initHijrDatePicker() {
    let dateobj = document.getElementsByClassName('datepicker');
    let datetimeobj = document.getElementsByClassName('datetimepicker');

    $.each(datetimeobj, function (k, v) {

        let stored= $(this).val();

        $(this).hijriDatePicker({
            locale: "ar-sa",
            hijriFormat:"iYYYY-iMM-iDD",
            format:"YYYY-MM-DD",
            showSwitcher: true,
            allowInputToggle: true,
            useCurrent: true,
            isRTL: false,
            keepOpen: false,
            hijri: false,
            // debug: true,
            // showClear: true,
            // showTodayButton: true,
            // showClose: true
        });
        if (stored !== null){
            $(this).val(stored);
        }
    });
    $.each(dateobj, function (k, v) {
        let stored= $(this).val();
        $(this).hijriDatePicker({
            locale: "ar-sa",
            hijriFormat:"iYYYY-iMM-iDD",
            format:"YYYY-MM-DD",
            showSwitcher: true,
            allowInputToggle: true,
            useCurrent: true,
            isRTL: false,
            keepOpen: false,
            hijri: false,
            // debug: true,
            // showClear: true,
            // showTodayButton: true,

        });
        if (stored !== null){
            $(this).val(stored);
        }

        // let sw = document.querySelectorAll('[data-action="switchDate"]')
        // sw[0].addEventListener('click', function() {
        //     console.log(sw)
        // })


    });
}