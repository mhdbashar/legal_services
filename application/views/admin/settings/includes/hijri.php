<?php
defined('BASEPATH') or exit('No direct script access allowed');
//var_dump(get_option('active_language'));exit();
?>
<!-- Default switch -->

<div class="form-group">
<!--    <button type="button" class="flip-button"></button>-->
<!--    <input type="checkbox" name="hijri"  >Hijri-->
    <input type="checkbox"  id="hijri_check" data-toggle="toggle"  data-onstyle="primary" name="isHijriVal">
    <label for="hiri_check" style="margin-left: 5%">
        Hijri
    </label>
</div>
<hr />
<!--<div class="form-group" id="adjust_div">-->
<!--    <div class="form-group">-->
<!--        <label  class="control-label clearfix" style="margin-bottom: 2%">-->
<!--            Hijri adjustment-->
<!--        </label>-->
<!--        <div class="radio radio-primary radio-inline" style="margin-right: 2%">-->
<!--            <input type="radio" id="zero" name="hijri_adjust" value="Y-m-d|%Y-%m-%d|hijri" checked>-->
<!--            <label for="zero">-->
<!--                0-->
<!--            </label>-->
<!--        </div>-->
<!--        <div class="radio radio-primary radio-inline" style="margin-right: 2%">-->
<!--            <input type="radio" id="one" name="hijri_adjust" value="Y-m-d|%Y-%m-%d|hijri|+1" >-->
<!--            <label for="one">-->
<!--                +1-->
<!--            </label>-->
<!--        </div>-->
<!--        <div class="radio radio-primary radio-inline" style="margin-right: 2%">-->
<!--            <input type="radio" id="minus" name="hijri_adjust" value="Y-m-d|%Y-%m-%d|hijri|-1" >-->
<!--            <label for="minus">-->
<!--                -1-->
<!--            </label>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<!--<hr />-->
<div class="form-group" id="tbl_div">
    <label  class="control-label clearfix">
        Hijri Pages
    </label>

        <div class="row clearfix">
            <div class="col-md-9 column">
                <table class="table table-bordered table-hover" id="tab_logic">
                    <thead>
                    <tr >
                        <th class="text-center">
                            #
                        </th>
                        <th class="text-center">
                            Link
                        </th>

                    </tr>
                    </thead>
                    <tbody>
                    <tr id='addr0'>
<!--                        <td>-->
<!--                            1-->
<!--                        </td>-->
<!--                        <td>-->
<!--                            <input type="text" name='link0'  placeholder='Link' class="form-control"/>-->
<!--                        </td>-->

                    </tr>
<!--                    <tr id='addr1'></tr>-->
                    </tbody>
                </table>
            </div>
        </div>
        <a id="add_row" class="btn btn-default pull-left">Add Row</a><a id='delete_row' class="pull-right btn btn-default">Delete Row</a>

</div>

<div id="adjust_div">

    <div id="adjust_list" style="margin-top: 100px">
        <?php
        $hijri_settings = array('umalqura' => TRUE, 'langecode' => 'ar');
//        $hijri_settings['adj_data'] = $_SESSION['adj_data'];
//        $_SESSION['adj_data'] = $adj->get_adjdata(TRUE);
        $adj = new CalendarAdjustment();
        $hmonths = array(1 => "محرم", "صفر", "ربيع الأول", "ربيع الثاني", "جمادى الأولى", "جمادى الآخرة", "رجب", "شعبان", "رمضان", "شوال", "ذو القعدة", "ذو الحجة");
        $msg='';
        echo '<h2>التعديلات الحالية على تقويم أم القرى</h2>';

        $history = get_option('adjust_data');
        $history = json_decode($history);
        $myret = array();
        foreach ($history as $k => $v) {
            list($hm, $hy) = $adj->off2month($k);
            $myret[] = array('month' => $hm, 'year' => $hy, 'current' => $adj->myjd2gre($v), 'default' => $adj->myjd2gre($adj->umdata_clear[$k]));
//            var_dump($myret);exit();

        }
        foreach ($myret as $v){
            echo "<div id='delete_his_div'>";
            echo $v['year'] . "/ " . $v['month'] . " - " . $hmonths[$v['month']] . " => " . $v['current'] . " الافتراضي هو " . $v['default'] ;
            echo "<input type='button' id='delete_his_btn' data-month='".$v['month']."' data-year='".$v['year']."' value='حذف'>";
            echo '</div>';
        }




//        echo DateHijri::createFromHijri(1436, 11, 0)->format('_d _M _Y=d M Y') . '<br/>';
//        echo DateHijri::createFromHijri(1436, 12, 0)->format('_d _M _Y=d M Y') . '<br/>';
//        echo DateHijri::createFromHijri(1437, 1, 0)->format('_d _M _Y=d M Y') . '<br/>';
//        echo DateHijri::createFromHijri(1437, 2, 0)->format('_d _M _Y=d M Y') . '<br/>';
//        echo DateHijri::createFromHijri(1437, 3, 0)->format('_d _M _Y=d M Y') . '<br/>';
        ?>
    </div>
    <div id="new_adjustement">
        <p>New</p>
        <?php

        ?>

    </div>
    <div id="current_adjust">
        <input type="hidden" id="adjust_data" name="adjust_data">
<!--        --><?php
//            echo '<h2>إضافة تعديل على تقويم أم القرى</h2>';
//            echo $msg . '<br/>';
//            foreach ($adj->get_current_adjs() as $v) {
//            echo $v['year'] . "/ " . $v['month'] . " - " . $hmonths[$v['month']] . " => " . $v['current'] . " الافتراضي هو " . $v['default'] . " [<a href='" . $_SERVER['SCRIPT_NAME'] . "?action=del&amp;month=" . $v['month'] . "&amp;year=" . $v['year'] . "'>حذف</a>] [<a href='" . $_SERVER['SCRIPT_NAME'] . "?action=edit&amp;month=" . $v['month'] . "&amp;year=" . $v['year'] . "'>تعديل</a>]<br/>";
//            }
//        ?>
    </div>
    <div id="add_adjust">
        <label>السنة</label>
        <select  id="year_adj">
            <?php

            //echo 'السنة :< select name="year" >';
            $d = new DateHijri();
            list($mymonth, $myyear) = explode(' ', $d->format('_m _Y'));
            for ($n = Calendar::umstartyear; $n < Calendar::umendyear + 1; $n++) {
                echo "<option value='$n'";
                if ($n == $myyear) {
                    echo " selected ";
                }
                echo ">$n</option>\n";
            }

            ?>
        </select>
        <label>الشهر</label>
        <select  id="month_adj">
            <?php
//            echo '</select> الشهر :<select name="month" id="month_adj">';
            for ($n = 1; $n < 13; $n++) {
                echo "<option value='$n'";
                if ($n == $mymonth) {
                    echo "selected";
                }
                echo ">" . $hmonths[$n] . "</option>\n";
            }
            echo '<input type="button" name="add" id="btn_add_adjust" value="طلب إضافة" />';

            //        $hm = $_GET['month'];
            //        $hy = $_GET['year'];
            //        echo "تعديل بداية الشهر " . $hmonths[$hm] . " من سنة $hy إلى:";
            //        echo '<form method="post"><input type="hidden" name="addadj" value=1><input type="hidden" name="month" value=' . $hm . '><input type="hidden" name="year" value=' . $hy . '><select name="v">';
            //        $starts = $adj->get_possible_starts($hm, $hy);
            //        foreach ($starts as $start) {
            //            echo '<option value="' . $start['jd'] . '"' . (($start['currentset']) ? ' selected' : '') . ' >' . $start['grdate'];
            //            foreach ($start['alsoadjdata'] as $v) {
            //                echo " وسيتم أيضا تعديل بداية شهر " . $hmonths[$v['month']] . " من سنة " . $v['year'] . " إلى:" . $v['grdate'];
            //            }
            //            echo "</option>";
            //        }
            //        echo '</select><input type="submit" name="submit" value="إرسال" />';
            //        echo '<a href="' . $_SERVER['SCRIPT_NAME'] . '">إلغاء</a>';

            ?>
        </select>

    </div>
    <div id="add_form_adj">
        
    </div>
    <div id="adjust_data">
        <?php
            echo '<br/>بيانات التعديل<br/><textarea id="txt_adj" rows="6" cols="50" style="text-align:left;direction: ltr;">';
//            echo $adj->get_adjdata(TRUE);
            echo '</textarea><br/>';
        ?>
    </div>

    <?php


//    var_dump(DateHijri::createFromHijri(1436, 11, 0)->format('_d _M _Y=d M Y'));exit;



//
//
//        $hm = $_GET['month'];
//        $hy = $_GET['year'];
//        echo "تعديل بداية الشهر " . $hmonths[$hm] . " من سنة $hy إلى:";
//        echo '<form method="post"><input type="hidden" name="addadj" value=1><input type="hidden" name="month" value=' . $hm . '><input type="hidden" name="year" value=' . $hy . '><select name="v">';
//        $starts = $adj->get_possible_starts($hm, $hy);
//        foreach ($starts as $start) {
//            echo '<option value="' . $start['jd'] . '"' . (($start['currentset']) ? ' selected' : '') . ' >' . $start['grdate'];
//            foreach ($start['alsoadjdata'] as $v) {
//                echo " وسيتم أيضا تعديل بداية شهر " . $hmonths[$v['month']] . " من سنة " . $v['year'] . " إلى:" . $v['grdate'];
//            }
//            echo "</option>";
//        }
//        echo '</select><input type="submit" name="submit" value="إرسال" />';
//        echo '<a href="' . $_SERVER['SCRIPT_NAME'] . '">إلغاء</a>';

    ?>
</div>
<?php
///** adjuster for hijridatetime class
// * by hubaishan http://salafitech.net
// * ver 2.1
// * 8 dulqidah 1436 h
// *
// */
//// These setting can by edited
//define("our_pwd", "hijri"); // password
//$hijri_settings = array('umalqura' => TRUE, 'langecode' => 'ar');
//
//
//
//// example when using file
//// END of edit able setting
//// do not edit below
////require_once ("../hijri.class.php");
////session_start();
////if (array_key_exists('adj_data', $_SESSION)) {
////    $hijri_settings['adj_data'] = $_SESSION['adj_data'];
////}
//
//$adj = new CalendarAdjustment();
//
//$msg = '';
//if (!empty($_POST['login'])) {
//    $_SESSION['password'] = $_POST['password'];
//    header("Location: " . $_SERVER["SCRIPT_NAME"]);
//    exit();
//} elseif (array_key_exists('add', $_GET)) {
//    header("Location: " . $_SERVER["SCRIPT_NAME"] . "?action=add&month=" . $_GET[month] . "&year=" . $_GET[year]);
//    exit();
//} elseif (array_key_exists('exit', $_POST)) {
//    session_destroy();
//    header("Location: " . $_SERVER["SCRIPT_NAME"]);
//    exit();
//} elseif (array_key_exists('addadj', $_POST)) {
//    $adj->add_adj($_POST['month'], $_POST['year'], $_POST['v']);
//    $_SESSION['adj_data'] = $adj->get_adjdata(TRUE);
//    header("Location: " . $_SERVER["SCRIPT_NAME"]);
//    exit();
//} elseif (array_key_exists('deladj', $_POST)) {
//    $adj->del_adj($_POST['month'], $_POST['year']);
//    $_SESSION['adj_data'] = $adj->get_adjdata(TRUE);
//    header("Location: " . $_SERVER["SCRIPT_NAME"]);
//    exit();
//}
//?>
<!--<html dir="rtl">-->
<!---->
<!--<head>-->
<!--    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">-->
<!--    <title>تعديل تقويم أم القرى</title>-->
<!--</head>-->
<!---->
<!--<body>-->
<?php
//$no_session = false;
////if (array_key_exists('password', $_SESSION)) {
////    if ($_SESSION['password'] == our_pwd) {
////        $no_session = FALSE;
////    }
////}
//if ($no_session) {
//    echo '
//	<br><br><center>
//	<form method="post">
//	كلمة المرور
//	<input type="password" name="password" value="" /><br>
//	<input type="submit" name="login" value="دخول" />
//	</form>';
//    exit();
//}
//
//$hmonths = array(1 => "محرم", "صفر", "ربيع الأول", "ربيع الثاني", "جمادى الأولى", "جمادى الآخرة", "رجب", "شعبان", "رمضان", "شوال", "ذو القعدة", "ذو الحجة");
//
//if (isset($_GET['action'])) {
//    if ($_GET['action'] == 'del') {
//        echo "هل تريد بالتأكيد حذف تعديل الشهر" . $hmonths[$_GET['month']] . " من السنة " . $_GET['year'];
//        $auto_del = $adj->auto_del_info($_GET['month'], $_GET['year']);
//        if (!empty($auto_del)) {
//            echo " سيتم حذف تعديلات الأشهر ";
//            foreach ($auto_del as $k) {
//                echo $hmonths[$k['month']] . ' من سنة  ' . $k['year'];
//            }
//            echo "تلقائيا";
//        }
//        echo "\n" . '<form method="post"><input type="hidden" name="deladj" value=1><input type="hidden" name="month" value=' . $_GET['month'] . '><input type="hidden" name="year" value=' . $_GET['year'] . '><input type="submit" name="submit" value="نعم بالتأكيد" /></from>';
//        echo '<a href="' . $_SERVER['SCRIPT_NAME'] . '">إلغاء</a>';
//    } elseif ($_GET['action'] == 'edit' or $_GET['action'] == 'add') {
//        $hm = $_GET['month'];
//        $hy = $_GET['year'];
//        echo "تعديل بداية الشهر " . $hmonths[$hm] . " من سنة $hy إلى:";
//        echo '<form method="post"><input type="hidden" name="addadj" value=1><input type="hidden" name="month" value=' . $hm . '><input type="hidden" name="year" value=' . $hy . '><select name="v">';
//        $starts = $adj->get_possible_starts($hm, $hy);
//        foreach ($starts as $start) {
//            echo '<option value="' . $start['jd'] . '"' . (($start['currentset']) ? ' selected' : '') . ' >' . $start['grdate'];
//            foreach ($start['alsoadjdata'] as $v) {
//                echo " وسيتم أيضا تعديل بداية شهر " . $hmonths[$v['month']] . " من سنة " . $v['year'] . " إلى:" . $v['grdate'];
//            }
//            echo "</option>";
//        }
//        echo '</select><input type="submit" name="submit" value="إرسال" />';
//        echo '<a href="' . $_SERVER['SCRIPT_NAME'] . '">إلغاء</a>';
//    }
//} else {
//
//    echo '<h2>التعديلات الحالية على تقويم أم القرى</h2>';
//    echo $msg . '<br/>';
//    foreach ($adj->get_current_adjs() as $v) {
//        echo $v['year'] . "/ " . $v['month'] . " - " . $hmonths[$v['month']] . " => " . $v['current'] . " الافتراضي هو " . $v['default'] . " [<a href='" . $_SERVER['SCRIPT_NAME'] . "?action=del&amp;month=" . $v['month'] . "&amp;year=" . $v['year'] . "'>حذف</a>] [<a href='" . $_SERVER['SCRIPT_NAME'] . "?action=edit&amp;month=" . $v['month'] . "&amp;year=" . $v['year'] . "'>تعديل</a>]<br/>";
//    }
//    echo '<h2>إضافة تعديل على تقويم أم القرى</h2>';
//    echo DateHijri::createFromHijri(1436, 11, 0)->format('_d _M _Y=d M Y') . '<br/>';
//    echo DateHijri::createFromHijri(1436, 12, 0)->format('_d _M _Y=d M Y') . '<br/>';
//    echo DateHijri::createFromHijri(1437, 1, 0)->format('_d _M _Y=d M Y') . '<br/>';
//    echo DateHijri::createFromHijri(1437, 2, 0)->format('_d _M _Y=d M Y') . '<br/>';
//    echo DateHijri::createFromHijri(1437, 3, 0)->format('_d _M _Y=d M Y') . '<br/>';
//    echo '<form method="get">السنة :<select name="year">';
//    $d = new DateHijri();
//    list($mymonth, $myyear) = explode(' ', $d->format('_m _Y'));
//    for ($n = Calendar::umstartyear; $n < Calendar::umendyear + 1; $n++) {
//        echo "<option value='$n'";
//        if ($n == $myyear) {
//            echo " selected ";
//        }
//        echo ">$n</option>\n";
//    }
//    echo '</select> الشهر :<select name="month">';
//    for ($n = 1; $n < 13; $n++) {
//        echo "<option value='$n'";
//        if ($n == $mymonth) {
//            echo "selected";
//        }
//        echo ">" . $hmonths[$n] . "</option>\n";
//    }
//    echo '</select><input type="submit" name="add" value="طلب إضافة" /></form>';
//    echo '<br/>بيانات التعديل<br/><textarea rows="6" cols="50" style="text-align:left;direction: ltr;">';
//    echo $adj->get_adjdata(TRUE);
//    echo '</textarea><br/>';
//    echo '<br/><form method="post"><input type="submit" name="exit" value="خروج" /></form>';
//}
//?>




