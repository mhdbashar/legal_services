function appDatepicker(e) {
    // console.log(app.options.date_format);
        let obj = document.getElementsByClassName('datepicker');
        let icon = document.getElementsByClassName('calendar-icon');
        let lang = "english";
        let dateType = "AD";
        // console.log(admin_url + 'settings/get_date_options');

        $.ajax({
            type: 'post',
            url: admin_url + 'My_custom_controller/get_date_options',
            // data: ['<?php echo get_instance()->security->get_csrf_token_name();?> : <?php echo get_instance()->security->get_csrf_hash(); ?>'],
            success: function(data) {
                console.log(JSON.parse(data).lang)
                lang = JSON.parse(data).lang;
                dateType = JSON.parse(data).mode;
                // comment = JSON.parse(comment);
                // success(comment)
            },

        });


        $.each(obj,function (k,v) {
            console.log($(this).parent().find('.calendar-icon')[0]);
            let icon = $(this).parent().find('.calendar-icon')[0]

            v.onclick = icon.onclick = function () {
                    // picker.setHijriMode('h');
                    pickDate(event);
                    picker.setLanguage(lang);
                    if(dateType == 'hijri'){
                        picker.setHijriMode(true);
                    }else{
                        picker.setHijriMode(false);
                    }

                    picker.onPicked=function(){


                        let elgd=document.getElementById(v.id);
                        // elgd.value=picker.getPickedDate().getDateString();

                        let date = picker.getPickedDate();
                        // console.log(elgd.value.split('ميلادي')[0]);

                        // let formattedDaten = HijriDate.toNDigit(date.getDate(),2)+'-'+
                        //     HijriDate.toNDigit(date.getMonth()+1,2)+'-'+
                        //     HijriDate.toNDigit(date.getFullYear(),4);
                        let formattedDaten = HijriDate.toNDigit(date.getFullYear(),4)+'-'+
                                HijriDate.toNDigit(date.getMonth()+1,2)+'-'+
                                HijriDate.toNDigit(date.getDate(),2);
                        console.log(formattedDaten)
                        elgd.value = formattedDaten;
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
        let picker=new Datepicker();
        let pickElm=picker.getElement();
        let pLeft=200;
        let pWidth=300;
        pickElm.style.position='absolute';
        pickElm.style.left=pLeft+'px';
        pickElm.style.top='172px';
        pickElm.style.zIndex =  99999;
        picker.attachTo(document.body);



        function openSidebar(){
            document.getElementById("mySidebar").style.display = "block"
        }

        function closeSidebar(){
            document.getElementById("mySidebar").style.display = "none"
        }

        function dropdown(el){
            if(el.className.indexOf('expanded')==-1){
                el.className=el.className.replace('collapsed','expanded');
            }else{
                el.className=el.className.replace('expanded','collapsed');
            }
        }

        function selectLang(el){
            el.children[0].checked=true;
            picker.setLanguage(el.children[0].value);
        }

        function setFirstDay(fd){
            picker.setFirstDayOfWeek(fd)
        }

        function setYear(){
            let el=document.getElementById('valYear');
            picker.setFullYear(el.value)
        }

        function setMonth(){
            let el=document.getElementById('valMonth');
            picker.setMonth(el.value)
        }

        function updateWidth(el){
            pWidth=parseInt(el.value);
            if(!fixWidth()){
                document.getElementById('valWidth').value=pWidth;
                picker.setWidth(pWidth)
            }
        }

        function pickDate(ev){
            ev=ev||window.event;
            let el=ev.target||ev.srcElement;
            pLeft=ev.pageX;
            fixWidth();
            pickElm.style.top=ev.pageY+'px';
            picker.setHijriMode(el.id=='hijrDate');
            picker.show();
            el.blur()
        }

        function gotoToday(){
            picker.today()
        }

        function setTheme(){
            let el=document.getElementById('txtTheme');
            let n=parseInt(el.value);
            if(!isNaN(n))picker.setTheme(n);
            else picker.setTheme(el.value)
        }

        function newTheme(){
            picker.setTheme()
        }

        function fixWidth(){
            let docWidth=document.body.offsetWidth;
            let isFixed=false;
            if(pLeft+pWidth>docWidth)pLeft=docWidth-pWidth;
            if(docWidth>=992&&pLeft<200)pLeft=200;
            else if(docWidth<992&&pLeft<0)pLeft=0;
            if(pLeft+pWidth>docWidth){
                pWidth=docWidth-pLeft;
                picker.setWidth(pWidth);
                document.getElementById('valWidth').value=pWidth;
                document.getElementById('sliderWidth').value=pWidth;
                isFixed=true
            }
            pickElm.style.left=pLeft+'px';
            return isFixed
        }
    }