<section id="fancyTabWidget" class="tabs t-tabs">
    <ul class="nav nav-tabs no-margin" role="tablist">

        <li role="presentation" class="project_tab_activity">
            <a id="tab0" href="#tabBody0" role="tab" aria-expanded="true" aria-controls="tabBody0" aria-selected="true"
               onclick="getdata_tabBody0()"
               data-toggle="tab"><i class="fa fa-gavel" aria-hidden="true"></i> السوابق القضائية</a>
        </li>
        <li role="presentation" class="project_tab_invoices">
            <a id="tab1" href="#tabBody1" role="tab" aria-controls="tabBody1" aria-selected="true" data-toggle="tab"
               onclick="getdata_tabBody1()"
            ><i class="fa fa-balance-scale" aria-hidden="true"></i>الانظمة السعودية</a>
        </li>
        <li role="presentation" class="project_tab_invoices">
            <a id="tab2" href="#tabBody2" role="tab" aria-controls="tabBody2" aria-selected="true" data-toggle="tab"
               onclick="getdata_tabBody2()"
            ><span class="fa fa-tags"></span>
                المبادئ القضائية
            </a>
        </li>
        <li role="presentation" class="project_tab_invoices">
            <a id="tab3" href="#tabBody3" role="tab" aria-controls="tabBody3" aria-selected="true" data-toggle="tab"
               onclick="getdata_tabBody3()"
            ><span class="fa fa-bullhorn"></span> التعاميم العدلية </a>
        </li>
        <li role="presentation" class="project_tab_invoices">
            <a id="tab4" href="#tabBody4" role="tab" aria-controls="tabBody4" aria-selected="true" data-toggle="tab"
               onclick="getdata_tabBody4()"
            ><span class="fa fa-address-book-o"></span> الدليل العملي للأحوال الشخصية </a>
        </li>
        <li role="presentation" class="project_tab_invoices">
            <a id="tab5" href="#tabBody5" role="tab" aria-controls="tabBody5" aria-selected="true" data-toggle="tab"
               onclick="getdata_tabBody5()"
            ><span class="fa fa-briefcase"></span>الدليل العملي للقضاء العمالي </a>
        </li>


        <li role="presentation" class="project_tab_invoices">
            <a id="tab6" href="#tabBody6" role="tab" aria-controls="tabBody6" aria-selected="true" data-toggle="tab"
               onclick="getdata_tabBody6()"
            ><span class="fa fa-file-pdf-o"></span> الدليل العملي في القضايا الجزائية </a>
        </li>


        <li role="presentation" class="project_tab_invoices">
            <a id="tab7" href="#tabBody7" role="tab" aria-controls="tabBody7" aria-selected="true" data-toggle="tab"
               onclick="getdata_tabBody7()"
            ><span class="fa fa-mortar-board"></span> الدليل العملي للشركات</a>
        </li>


        <li role="presentation" class="project_tab_invoices">
            <a id="tab8" href="#tabBody8" role="tab" aria-controls="tabBody8" aria-selected="true" data-toggle="tab"
               onclick="getdata_tabBody8()"
            ><span class="fa fa-university"></span> الدليل العملي للقضاء الإداري </a>

        </li>


        <li role="presentation" class="project_tab_invoices">
            <a id="tab9" href="#tabBody9" role="tab" aria-controls="tabBody9" aria-selected="true" data-toggle="tab"
               onclick="getdata_tabBody9()"
            ><span class="fa fa-pencil-square"></span>الدليل العملي للقضاء العام </a>
        </li>


        <li role="presentation" class="project_tab_invoices">
            <a id="tab10" href="#tabBody10" role="tab" aria-controls="tabBody10" aria-selected="true" data-toggle="tab"
               onclick="getdata_tabBody10()"
            ><span class="fa fa-info-circle"></span>الدليل العملي للمحامي في الاسانيد والقواعد النظامية
                والشرعية </a>
        </li>


        <li role="presentation" class="project_tab_invoices">
            <a id="tab11" href="#tabBody11" role="tab" aria-controls="tabBody11" aria-selected="true" data-toggle="tab"
               onclick="getdata_tabBody11()"
            ><span class="fa fa-share-square-o"></span> القضاء العمالي </a>
        </li>


        <li role="presentation" class="project_tab_invoices">
            <a id="tab12" href="#tabBody12" role="tab" aria-controls="tabBody12" aria-selected="true" data-toggle="tab"
               onclick="getdata_tabBody12()"
            ><span class="fa fa-sticky-note-o"></span>التفتيش القضائي </a>
        </li>


        <li role="presentation" class="project_tab_invoices">
            <a id="tab13" href="#tabBody13" role="tab" aria-controls="tabBody13" aria-selected="true" data-toggle="tab"
               onclick="getdata_tabBody13()"
            ><span class="fa fa-file-word-o"></span> قرارات هيئة التدقيق مجتمعة </a>
        </li>


        <li role="presentation" class="project_tab_invoices">
            <a id="tab14" href="#tabBody14" role="tab" aria-controls="tabBody14" aria-selected="true" data-toggle="tab"
               onclick="getdata_tabBody14()"
            ><span class="fa fa-hdd-o"></span> مبادئ لجنة تسوية المنازعات المصرفية </a>
        </li>


        <li role="presentation" class="project_tab_invoices">
            <a id="tab15" href="#tabBody15" role="tab" aria-controls="tabBody15" aria-selected="true" data-toggle="tab"
               onclick="getdata_tabBody15()"
            ><span class="fa fa-map-o"></span> قرارات محكمة الاستئناف </a>
        </li>

        <li role="presentation" class="project_tab_invoices">
            <a id="tab16" href="#tabBody16" role="tab" aria-controls="tabBody16" aria-selected="true" data-toggle="tab"
               onclick="getdata_tabBody16()"
            ><span class="fa fa-tags"></span> مدونة القرارات والمبادئ العمالية </a>
        </li>

        <li role="presentation" class="project_tab_invoices">
            <a id="tab17" href="#tabBody17" role="tab" aria-controls="tabBody17" aria-selected="true" data-toggle="tab"
               onclick="getdata_tabBody17()"
            ><span class="fa fa-search"></span> مجموعة الأحكام القضائية </a>
        </li>

    </ul>

    <div id="myTabContent" class="tab-content fancyTabContent" aria-live="polite">
        <?php for ($i = 0; $i < 18; $i++) { ?>
            <div class="tab-pane fade active in" id="tabBody<?= $i ?>" role="tabpanel" aria-labelledby="tab<?= $i ?>"
                 tabindex="0" aria-hidden="false"></div>
        <?php } ?>
    </div>
</section>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    var url = 'https://library.lawyernet.net/api_lib/search1';

    // var url = 'http://localhost/legalserv/api_lib/search1';
    var befor = '<div class="thumbnail"><div class="row"><div class="col-md-12">';
    var after = '</div></div></div>';
    var non = '<h4 class="text-center"><?php echo _l("smtp_encryption_none"); ?>...</h4>';
    var search = <?=$search?>;
    var is_download_tabBody0 = false;
    var is_download_tabBody1 = false;
    var is_download_tabBody2 = false;
    var is_download_tabBody3 = false;
    var is_download_tabBody4 = false;
    var is_download_tabBody5 = false;
    var is_download_tabBody6 = false;
    var is_download_tabBody7 = false;
    var is_download_tabBody8 = false;
    var is_download_tabBody9 = false;
    var is_download_tabBody10 = false;
    var is_download_tabBody11 = false;
    var is_download_tabBody12 = false;
    var is_download_tabBody13 = false;
    var is_download_tabBody14 = false;
    var is_download_tabBody15 = false;
    var is_download_tabBody16 = false;
    var is_download_tabBody17 = false;

    function get_library_data_api() {
        add_loader();
        $('#tab0').click();
    }

    function copyElementText(id) {
        var text = document.getElementById(id).innerText;
        var elem = document.createElement("textarea");
        document.body.appendChild(elem);
        elem.value = text;
        elem.select();
        document.execCommand("copy");
        document.body.removeChild(elem);
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'تم نسخ النص بنجاح',
            showConfirmButton: false,
            timer: 1500
        })
    }

    function add_loader() {
        for (var i = 0; i < 18; i++) {
            $('#tabBody' + i).html('');
            $("#tabBody" + i).append('<div class="dt-loader"></div>');
        }
    }

    function getdata_tabBody0() {
        if (is_download_tabBody0 == false) {
            $.ajax({
                url: url,
                data: {
                    text: search,
                    type: 13
                },
                type: "POST",
                time: 300,
                success: function (data) {
                    response = JSON.parse(data);
                    $('#tabBody0').html('');
                    $.each(response, function (key, value) {
                        $('#tabBody0').append(`
                        <div class="thumbnail">
                            <a href="${value['link']}" target="_blank">
                                <h5>${value['name']}</h5>
                            </a>
                        </div>
                    `);
                    });
                    if (response == 0) $('#tabBody0').append(`${non}`);
                    is_download_tabBody0 = true;
                }
            });
        }
    }

    function getdata_tabBody1() {
        if (is_download_tabBody1 == false) {
            $.ajax({
                url: url,
                data: {
                    text: search,
                    type: 2
                },
                type: "POST",
                success: function (data) {
                    response = JSON.parse(data);
                    $('#tabBody1').html('');
                    $.each(response, function (key, value) {
                        $('#tabBody1').append(`${befor}
                        <a href="${value['link']}" target="_blank">
                            <h4>${value['name']}</h4>
                        </a>
                        <h5>${value['title']}</h5>
                        <p id="tabBody1-${key}">${value['description']}</p>
                        <button style="float: left" class="fa fa-files-o" onclick="copyElementText('tabBody1-${key}')" title="نسخ النص لهذه المادة"></button>
                    ${after}`);
                    });
                    if (response == 0) $('#tabBody1').append(`${non}`);
                    is_download_tabBody1 = true;
                }
            });
        }
    }

    function getdata_tabBody2() {
        if (is_download_tabBody2 == false) {
            $.ajax({
                url: url,
                data: {
                    text: search,
                    type: 12
                },
                type: "POST",
                success: function (data) {
                    response = JSON.parse(data);
                    $('#tabBody2').html('');
                    $.each(response, function (key, value) {
                        $('#tabBody2').append(`${befor}
                        <a href="${value['link']}" target="_blank">
                            <h4>${value['name']}</h4>
                        </a>
                       <h5>${value['title']}</h5>
                       <p id="tabBody2-${key}">${value['description']}</p>
                        <button style="float: left" class="fa fa-files-o" onclick="copyElementText('tabBody2-${key}')" title="نسخ النص لهذه المادة"></button>
                    ${after}`);
                    });
                    if (response == 0) $('#tabBody2').append(`${non}`);
                    is_download_tabBody2 = true;
                }
            });
        }
    }

    function getdata_tabBody3() {
        if (is_download_tabBody3 == false) {
            $.ajax({
                url: url,
                data: {
                    text: search,
                    type: 3
                },
                type: "POST",
                success: function (data) {
                    response = JSON.parse(data);
                    $('#tabBody3').html('');
                    $.each(response, function (key, value) {
                        $('#tabBody3').append(`${befor}
                        <a href="${value['link']}" target="_blank">
                            <h4>${value['name']}</h4>
                        </a>
                       <h5>${value['title']}</h5>
                       <p id="tabBody3-${key}">${value['description']}</p>
                        <button style="float: left" class="fa fa-files-o" onclick="copyElementText('tabBody3-${key}')" title="نسخ النص لهذه المادة"></button>
                    ${after}`);
                    });
                    if (response == 0) $('#tabBody3').append(`${non}`);
                    is_download_tabBody3 = true;
                }
            });
        }
    }

    function getdata_tabBody4() {
        if (is_download_tabBody4 == false) {
            $.ajax({
                url: url,
                data: {
                    text: search,
                    type: 4
                },
                type: "POST",
                success: function (data) {
                    response = JSON.parse(data);
                    $('#tabBody4').html('');
                    $.each(response, function (key, value) {
                        $('#tabBody4').append(`${befor}
                        <a href="${value['link']}" target="_blank">
                            <h4>${value['name']}</h4>
                        </a>
                       <h5>${value['title']}</h5>
                       <p id="tabBody4-${key}">${value['description']}</p>
                        <button style="float: left" class="fa fa-files-o" onclick="copyElementText('tabBody4-${key}')" title="نسخ النص لهذه المادة"></button>
                    ${after}`);
                    });
                    if (response == 0) $('#tabBody4').append(`${non}`);
                    is_download_tabBody4 = true;
                }
            });
        }
    }

    function getdata_tabBody5() {
        if (is_download_tabBody5 == false) {
            $.ajax({
                url: url,
                data: {
                    text: search,
                    type: 5
                },
                type: "POST",
                success: function (data) {
                    response = JSON.parse(data);
                    $('#tabBody5').html('');
                    $.each(response, function (key, value) {
                        $('#tabBody5').append(`${befor}
                        <a href="${value['link']}" target="_blank">
                            <h4>${value['name']}</h4>
                        </a>
                       <h5>${value['title']}</h5>
                       <p id="tabBody5-${key}">${value['description']}</p>
                        <button style="float: left" class="fa fa-files-o" onclick="copyElementText('tabBody5-${key}')" title="نسخ النص لهذه المادة"></button>
                    ${after}`);
                    });
                    if (response == 0) $('#tabBody5').append(`${non}`);
                    is_download_tabBody5 = true;
                }
            });
        }
    }

    function getdata_tabBody6() {
        if (is_download_tabBody6 == false) {
            $.ajax({
                url: url,
                data: {
                    text: search,
                    type: 6
                },
                type: "POST",
                success: function (data) {
                    response = JSON.parse(data);
                    $('#tabBody6').html('');
                    $.each(response, function (key, value) {
                        $('#tabBody6').append(`${befor}
                        <a href="${value['link']}" target="_blank">
                            <h4>${value['name']}</h4>
                        </a>
                       <h5>${value['title']}</h5>
                       <p id="tabBody6-${key}">${value['description']}</p>
                        <button style="float: left" class="fa fa-files-o" onclick="copyElementText('tabBody6-${key}')" title="نسخ النص لهذه المادة"></button>
                    ${after}`);
                    });
                    if (response == 0) $('#tabBody6').append(`${non}`);
                    is_download_tabBody6 = true;
                }
            });
        }
    }

    function getdata_tabBody7() {
        if (is_download_tabBody7 == false) {
            $.ajax({
                url: url,
                data: {
                    text: search,
                    type: 7
                },
                type: "POST",
                success: function (data) {
                    response = JSON.parse(data);
                    $('#tabBody7').html('');
                    $.each(response, function (key, value) {
                        $('#tabBody7').append(`${befor}
                        <a href="${value['link']}" target="_blank">
                            <h4>${value['name']}</h4>
                        </a>
                       <h5>${value['title']}</h5>
                       <p id="tabBody7-${key}">${value['description']}</p>
                        <button style="float: left" class="fa fa-files-o" onclick="copyElementText('tabBody7-${key}')" title="نسخ النص لهذه المادة"></button>
                    ${after}`);
                    });
                    if (response == 0) $('#tabBody7').append(`${non}`);
                    is_download_tabBody7 = true;
                }
            });
        }
    }

    function getdata_tabBody8() {
        if (is_download_tabBody8 == false) {
            $.ajax({
                url: url,
                data: {
                    text: search,
                    type: 8
                },
                type: "POST",
                success: function (data) {
                    response = JSON.parse(data);
                    $('#tabBody8').html('');
                    $.each(response, function (key, value) {
                        $('#tabBody8').append(`${befor}
                        <a href="${value['link']}" target="_blank">
                            <h4>${value['name']}</h4>
                        </a>
                       <h5>${value['title']}</h5>
                       <p id="tabBody8-${key}">${value['description']}</p>
                        <button style="float: left" class="fa fa-files-o" onclick="copyElementText('tabBody8-${key}')" title="نسخ النص لهذه المادة"></button>
                    ${after}`);
                    });
                    if (response == 0) $('#tabBody8').append(`${non}`);
                    is_download_tabBody8 = true;
                }
            });
        }
    }

    function getdata_tabBody9() {
        if (is_download_tabBody9 == false) {
            $.ajax({
                url: url,
                data: {
                    text: search,
                    type: 9
                },
                type: "POST",
                success: function (data) {
                    response = JSON.parse(data);
                    $('#tabBody9').html('');
                    $.each(response, function (key, value) {
                        $('#tabBody9').append(`${befor}
                        <a href="${value['link']}" target="_blank">
                            <h4>${value['name']}</h4>
                        </a>
                       <h5>${value['title']}</h5>
                       <p id="tabBody9-${key}">${value['description']}</p>
                        <button style="float: left" class="fa fa-files-o" onclick="copyElementText('tabBody9-${key}')" title="نسخ النص لهذه المادة"></button>
                    ${after}`);
                    });
                    if (response == 0) $('#tabBody9').append(`${non}`);
                    is_download_tabBody9 = true;
                }
            });
        }
    }

    function getdata_tabBody10() {
        if (is_download_tabBody10 == false) {
            $.ajax({
                url: url,
                data: {
                    text: search,
                    type: 10
                },
                type: "POST",
                success: function (data) {
                    response = JSON.parse(data);
                    $('#tabBody10').html('');
                    $.each(response, function (key, value) {
                        $('#tabBody10').append(`${befor}
                        <a href="${value['link']}" target="_blank">
                            <h4>${value['name']}</h4>
                        </a>
                       <h5>${value['title']}</h5>
                       <p id="tabBody10-${key}">${value['description']}</p>
                        <button style="float: left" class="fa fa-files-o" onclick="copyElementText('tabBody10-${key}')" title="نسخ النص لهذه المادة"></button>
                    ${after}`);
                    });
                    if (response == 0) $('#tabBody10').append(`${non}`);
                    is_download_tabBody10 = true;
                }
            });
        }
    }

    function getdata_tabBody11() {
        if (is_download_tabBody11 == false) {
            $.ajax({
                url: url,
                data: {
                    text: search,
                    type: 11
                },
                type: "POST",
                success: function (data) {
                    response = JSON.parse(data);
                    $('#tabBody11').html('');
                    $.each(response, function (key, value) {
                        $('#tabBody11').append(`${befor}
                        <a href="${value['link']}" target="_blank">
                            <h4>${value['name']}</h4>
                        </a>
                       <h5>${value['title']}</h5>
                       <p id="tabBody11-${key}">${value['description']}</p>
                        <button style="float: left" class="fa fa-files-o" onclick="copyElementText('tabBody11-${key}')" title="نسخ النص لهذه المادة"></button>
                    ${after}`);
                    });
                    if (response == 0) $('#tabBody11').append(`${non}`);
                    is_download_tabBody11 = true;
                }
            });
        }
    }

    function getdata_tabBody12() {
        if (is_download_tabBody12 == false) {
            $.ajax({
                url: url,
                data: {
                    text: search,
                    type: 14
                },
                type: "POST",
                success: function (data) {
                    response = JSON.parse(data);
                    $('#tabBody12').html('');
                    $.each(response, function (key, value) {
                        $('#tabBody12').append(`${befor}
                        <a href="${value['link']}" target="_blank">
                            <h4>${value['name']}</h4>
                        </a>
                       <h5>${value['title']}</h5>
                       <p id="tabBody12-${key}">${value['description']}</p>
                        <button style="float: left" class="fa fa-files-o" onclick="copyElementText('tabBody12-${key}')" title="نسخ النص لهذه المادة"></button>
                    ${after}`);
                    });
                    if (response == 0) $('#tabBody12').append(`${non}`);
                    is_download_tabBody12 = true;
                }
            });
        }
    }

    function getdata_tabBody13() {
        if (is_download_tabBody13 == false) {
            $.ajax({
                url: url,
                data: {
                    text: search,
                    type: 15
                },
                type: "POST",
                success: function (data) {
                    response = JSON.parse(data);
                    $('#tabBody13').html('');
                    $.each(response, function (key, value) {
                        $('#tabBody13').append(`${befor}
                        <a href="${value['link']}" target="_blank">
                            <h4>${value['name']}</h4>
                        </a>
                       <h5>${value['title']}</h5>
                       <p id="tabBody13-${key}">${value['description']}</p>
                        <button style="float: left" class="fa fa-files-o" onclick="copyElementText('tabBody13-${key}')" title="نسخ النص لهذه المادة"></button>
                    ${after}`);
                    });
                    if (response == 0) $('#tabBody13').append(`${non}`);
                    is_download_tabBody13 = true;
                }
            });
        }
    }

    function getdata_tabBody14() {
        if (is_download_tabBody14 == false) {
            $.ajax({
                url: url,
                data: {
                    text: search,
                    type: 16
                },
                type: "POST",
                success: function (data) {
                    response = JSON.parse(data);
                    $('#tabBody14').html('');
                    $.each(response, function (key, value) {
                        $('#tabBody14').append(`${befor}
                        <a href="${value['link']}" target="_blank">
                            <h4>${value['name']}</h4>
                        </a>
                       <h5>${value['title']}</h5>
                       <p id="tabBody14-${key}">${value['description']}</p>
                        <button style="float: left" class="fa fa-files-o" onclick="copyElementText('tabBody14-${key}')" title="نسخ النص لهذه المادة"></button>
                    ${after}`);
                    });
                    if (response == 0) $('#tabBody14').append(`${non}`);
                    is_download_tabBody14 = true;
                }
            });
        }
    }

    function getdata_tabBody15() {
        if (is_download_tabBody15 == false) {
            $.ajax({
                url: url,
                data: {
                    text: search,
                    type: 17
                },
                type: "POST",
                success: function (data) {
                    response = JSON.parse(data);
                    $('#tabBody15').html('');
                    $.each(response, function (key, value) {
                        $('#tabBody15').append(`${befor}
                        <a href="${value['link']}" target="_blank">
                            <h4>${value['name']}</h4>
                        </a>
                       <h5>${value['title']}</h5>
                       <p id="tabBody15-${key}">${value['description']}</p>
                        <button style="float: left" class="fa fa-files-o" onclick="copyElementText('tabBody15-${key}')" title="نسخ النص لهذه المادة"></button>
                    ${after}`);
                    });
                    if (response == 0) $('#tabBody15').append(`${non}`);
                    is_download_tabBody15 = true;
                }
            });
        }
    }

    function getdata_tabBody16() {
        if (is_download_tabBody16 == false) {
            $.ajax({
                url: url,
                data: {
                    text: search,
                    type: 18
                },
                type: "POST",
                success: function (data) {
                    response = JSON.parse(data);
                    $('#tabBody16').html('');
                    $.each(response, function (key, value) {
                        $('#tabBody16').append(`${befor}
                        <a href="${value['link']}" target="_blank">
                            <h4>${value['name']}</h4>
                        </a>
                       <h5>${value['title']}</h5>
                       <p id="tabBody16-${key}">${value['description']}</p>
                        <button style="float: left" class="fa fa-files-o" onclick="copyElementText('tabBody16-${key}')" title="نسخ النص لهذه المادة"></button>
                    ${after}`);
                    });
                    if (response == 0) $('#tabBody16').append(`${non}`);
                    is_download_tabBody16 = true;
                }
            });
        }
    }

    function getdata_tabBody17() {
        if (is_download_tabBody17 == false) {
            $.ajax({
                url: url,
                data: {
                    text: search,
                    type: 19
                },
                type: "POST",
                success: function (data) {
                    response = JSON.parse(data);
                    $('#tabBody17').html('');
                    $.each(response, function (key, value) {
                        $('#tabBody17').append(`${befor}
                        <a href="${value['link']}" target="_blank">
                            <h4>${value['name']}</h4>
                        </a>
                       <h5>${value['title']}</h5>
                       <p id="tabBody17-${key}">${value['description']}</p>
                        <button style="float: left" class="fa fa-files-o" onclick="copyElementText('tabBody17-${key}')" title="نسخ النص لهذه المادة"></button>
                    ${after}`);
                    });
                    if (response == 0) $('#tabBody17').append(`${non}`);
                    is_download_tabBody17 = true;
                }
            });
        }
    }

</script>
