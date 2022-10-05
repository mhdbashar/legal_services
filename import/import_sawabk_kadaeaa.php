<?php //by mohammad nour watfa
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: text/html; charset=utf-8');

//https://www.youtube.com/watch?v=ZwRPKvElM9U
//$connect = mysqli_connect("localhost", "root", "", "noorbabi_data");
$connect = mysqli_connect("localhost", "libraryl_root", "kyz6YWu1vEU7", "libraryl_data");

mysqli_query($connect, "SET CHARACTER SET utf8");
mysqli_query($connect, "SET NAMES utf8");

$output = '';
if (isset($_POST["import"])) {
    $extension = @end(explode(".", $_FILES["excel"]["name"])); // For getting Extension of selected file
    $allowed_extension = array(
        "xls",
        "xlsx",
        "csv"
    ); //allowed extension
    if (in_array($extension, $allowed_extension)) //check selected file extension is present in allowed extension array
    {
        $file = $_FILES["excel"]["tmp_name"]; // getting temporary source of excel file
//        require ('modules/hr/third_party/excel/PHPExcel/IOFactory.php'); // Add PHPExcel Library in this code
        require ('application/third_party/excel/PHPExcel/IOFactory.php'); // Add PHPExcel Library in this code
        $objPHPExcel = PHPExcel_IOFactory::load($file); // create object of PHPExcel library by using load() method and in load method define path of selected file
        $excelReader = PHPExcel_IOFactory::createReaderForFile($file);
        $excelObj = $excelReader->load($file);
        $objWorksheet = $objPHPExcel->getActiveSheet();
        $ii = 1;
        $sheet_num = 0;
        $worksheet = $excelObj->getSheet($sheet_num);
        $lastRow = $worksheet->getHighestRow();
        for ($row = 2; $row <= $lastRow; $row++) {
            $a = $worksheet->getCell('A' . $row)->getValue();//التصنيف الفرعى
            $b = $worksheet->getCell('B' . $row)->getValue();//التصنيف الفرعى
            $c = $worksheet->getCell('C' . $row)->getValue();//التصنيف الفرعى
            $d = $worksheet->getCell('D' . $row)->getValue();//التصنيف الفرعى
            $e = $worksheet->getCell('E' . $row)->getValue();//التصنيف الفرعى
            $f = $worksheet->getCell('F' . $row)->getValue();//التصنيف الفرعى
            $g = $worksheet->getCell('G' . $row)->getValue();//الاسم

            $h = $worksheet->getCell('H' . $row)->getValue();//رقم القضية
            $h = $h != '' ? $h : 'لا يوجد';

            $i = $worksheet->getCell('I' . $row)->getValue();//تاريخها (هـ)
            $i = $i != '' ? $i : 'لا يوجد';

            $j = $worksheet->getCell('J' . $row)->getValue();//رقم الصك
            $j = $j != '' ? $j : 'لا يوجد';

            $k = $worksheet->getCell('K' . $row)->getValue();//تاريخه
            $k = $k != '' ? $k : 'لا يوجد';

            $l = $worksheet->getCell('L' . $row)->getValue();//رقم الدعوى
            $l = $l != '' ? $l : 'لا يوجد';

            $m = $worksheet->getCell('M' . $row)->getValue();//صدق الحكم من الاستئناف بالقرار
            $m = $m != '' ? $m : 'لا يوجد';

//            $n = $worksheet->getCell('N' . $row)->getValue();//صدق الحكم من الاستئناف بالقرار
            $o = $worksheet->getCell('O' . $row)->getValue();//رقم القضية الابتدائية
            $o = $o != '' ? $o : 'لا يوجد';

            $p = $worksheet->getCell('P' . $row)->getValue();//رقم القرار العاجل
            $p = $p != '' ? $p : 'لا يوجد';

            $q = $worksheet->getCell('Q' . $row)->getValue();//رقم الحكم الابتدائي
            $q = $q != '' ? $q : 'لا يوجد';

            $r = $worksheet->getCell('R' . $row)->getValue();//رقم قضية الاستئناف
            $r = $r != '' ? $r : 'لا يوجد';

            $s = $worksheet->getCell('S' . $row)->getValue();//رقم حكم الاستئناف
            $s = $s != '' ? $s : 'لا يوجد';

            $t = $worksheet->getCell('T' . $row)->getValue();//تاريخ الاستئناف (هـ)
            $t = $t != '' ? $t : 'لا يوجد';

//                $u = $worksheet->getCell('U' . $row)->getValue();//كلمات مفتاحية
            $v = $worksheet->getCell('V' . $row)->getValue();//ملخص الحكم
            $v = $v != '' ? $v : 'لا يوجد';

            $w = $worksheet->getCell('W' . $row)->getValue();//نص الحكم
            $w = $w != '' ? $w : 'لا يوجد';

            $x = $worksheet->getCell('X' . $row)->getValue();//الأسباب
            $x = $x != '' ? $x : 'لا يوجد';

            $y = $worksheet->getCell('Y' . $row)->getValue();//السند الشرعي والنظامي
            $y = $y != '' ? $y : 'لا يوجد';

            $z = $worksheet->getCell('Z' . $row)->getValue();//قرار الاستئناف
            $z = $z != '' ? $z : 'لا يوجد';

            $a = $a != '' ? $a : 'سابقة قضائية';

            $group_a = get_gruop($a,13);
            if ($group_a) {
                $g_a = $group_a ;
                if ($b != '') {
                    $group_b = get_gruop($b,$g_a);
                    if ($group_b) {
                        $g_b = $group_b ;
                        if ($c != '') {
                            $group_c = get_gruop($c,$g_b);
                            if ($group_c) {
                                $g_c = $group_c ;
                                if ($d != '') {
                                    $group_d = get_gruop($d,$g_c);
                                    if ($group_d) {
                                        $g_d = $group_d ;
                                        if ($e != '') {
                                            $group_e = get_gruop($e,$g_d);
                                            if ($group_e) {
                                                $g_e = $group_e ;
                                                if ($f != '') {
                                                    $group_f = get_gruop($f,$g_e);
                                                    if ($group_f) {
                                                        $art = int_knowledge($group_f,$g);
                                                        if ($art) {
                                                            int_customs($art,$h,$i,$j,$k,$l,$m,$o,$p,$q,$r,$s,$t);
                                                            int_Ncustoms($art,$v,$w,$x,$y,$z);
                                                            continue;
                                                        }
                                                    } else {
                                                        $group_f = int_group($f,$g_e);
                                                        if ($group_f) {
                                                            $art = int_knowledge($group_f,$g);
                                                            if ($art) {
                                                                int_customs($art,$h,$i,$j,$k,$l,$m,$o,$p,$q,$r,$s,$t);
                                                                int_Ncustoms($art,$v,$w,$x,$y,$z);
                                                                continue;
                                                            }
                                                        }
                                                    }
                                                } else {
                                                    $art = int_knowledge($g_e,$g);
                                                    if ($art) {
                                                        int_customs($art,$h,$i,$j,$k,$l,$m,$o,$p,$q,$r,$s,$t);
                                                        int_Ncustoms($art,$v,$w,$x,$y,$z);
                                                        continue;
                                                    }
                                                }
                                            } else {
                                                $group_e = int_group($e,$g_d);
                                                if ($group_e) {
                                                    $art = int_knowledge($group_e,$g);
                                                    if ($art) {
                                                        int_customs($art,$h,$i,$j,$k,$l,$m,$o,$p,$q,$r,$s,$t);
                                                        int_Ncustoms($art,$v,$w,$x,$y,$z);
                                                        continue;
                                                    }
                                                }
                                            }
                                        } else {
                                            $art = int_knowledge($g_d,$g);
                                            if ($art) {
                                                int_customs($art,$h,$i,$j,$k,$l,$m,$o,$p,$q,$r,$s,$t);
                                                int_Ncustoms($art,$v,$w,$x,$y,$z);
                                                continue;
                                            }
                                        }
                                    } else {
                                        $group_d = int_group($d,$g_c);
                                        if ($group_d) {
                                            $art = int_knowledge($group_d,$g);
                                            if ($art) {
                                                int_customs($art,$h,$i,$j,$k,$l,$m,$o,$p,$q,$r,$s,$t);
                                                int_Ncustoms($art,$v,$w,$x,$y,$z);
                                                continue;
                                            }
                                        }
                                    }
                                } else {
                                    $art = int_knowledge($g_c,$g);
                                    if ($art) {
                                        int_customs($art,$h,$i,$j,$k,$l,$m,$o,$p,$q,$r,$s,$t);
                                        int_Ncustoms($art,$v,$w,$x,$y,$z);
                                        continue;
                                    }
                                }
                            } else {
                                $group_c = int_group($c,$g_b);
                                if ($group_c) {
                                    $art = int_knowledge($group_c,$g);
                                    if ($art) {
                                        int_customs($art,$h,$i,$j,$k,$l,$m,$o,$p,$q,$r,$s,$t);
                                        int_Ncustoms($art,$v,$w,$x,$y,$z);
                                        continue;
                                    }
                                }
                            }
                        } else {
                            $art = int_knowledge($g_b,$g);
                            if ($art) {
                                int_customs($art,$h,$i,$j,$k,$l,$m,$o,$p,$q,$r,$s,$t);
                                int_Ncustoms($art,$v,$w,$x,$y,$z);
                                continue;
                            }
                        }
                    } else {
                        $group_b = int_group($b,$g_a);
                        if ($group_b) {
                            $art = int_knowledge($group_b,$g);
                            if ($art) {
                                int_customs($art,$h,$i,$j,$k,$l,$m,$o,$p,$q,$r,$s,$t);
                                int_Ncustoms($art,$v,$w,$x,$y,$z);
                                continue;
                            }
                        }
                    }
                } else {
                    $art = int_knowledge($g_a,$g);
                    if ($art) {
                        int_customs($art,$h,$i,$j,$k,$l,$m,$o,$p,$q,$r,$s,$t);
                        int_Ncustoms($art,$v,$w,$x,$y,$z);
                        continue;
                    }
                }
            } else {
                $group_a = int_group($a,13);
                if ($group_a) {
                    if ($b != '') {
                        $group_b = int_group($b,$group_a);
                        if($group_b) {
                            if ($c != '') {
                                $group_c = int_group($c, $group_b);
                                if($group_c) {
                                    if ($d != '') {
                                        $group_d = int_group($d, $group_c);
                                        if($group_d) {
                                            if ($e != '') {
                                                $group_e = int_group($e, $group_d);
                                                if($group_e) {
                                                    if ($f != '') {
                                                        $group_f = int_group($f, $group_e);
                                                        if ($group_f) {
                                                            $art = int_knowledge($group_f,$g);
                                                            if ($art) {
                                                                int_customs($art,$h,$i,$j,$k,$l,$m,$o,$p,$q,$r,$s,$t);
                                                                int_Ncustoms($art,$v,$w,$x,$y,$z);
                                                                continue;
                                                            }
                                                        }
                                                    } else {
                                                        $art = int_knowledge($group_e,$g);
                                                        if ($art) {
                                                            int_customs($art,$h,$i,$j,$k,$l,$m,$o,$p,$q,$r,$s,$t);
                                                            int_Ncustoms($art,$v,$w,$x,$y,$z);
                                                            continue;
                                                        }
                                                    }
                                                }
                                            } else {
                                                $art = int_knowledge($group_d,$g);
                                                if ($art) {
                                                    int_customs($art,$h,$i,$j,$k,$l,$m,$o,$p,$q,$r,$s,$t);
                                                    int_Ncustoms($art,$v,$w,$x,$y,$z);
                                                    continue;
                                                }
                                            }
                                        }
                                    } else {
                                        $art = int_knowledge($group_c,$g);
                                        if ($art) {
                                            int_customs($art,$h,$i,$j,$k,$l,$m,$o,$p,$q,$r,$s,$t);
                                            int_Ncustoms($art,$v,$w,$x,$y,$z);
                                            continue;
                                        }
                                    }
                                }
                            } else {
                                $art = int_knowledge($group_b,$g);
                                if ($art) {
                                    int_customs($art,$h,$i,$j,$k,$l,$m,$o,$p,$q,$r,$s,$t);
                                    int_Ncustoms($art,$v,$w,$x,$y,$z);
                                    continue;
                                }
                            }
                        }
                    }else{
                        $art = int_knowledge($group_a,$g);
                        if ($art) {
                            int_customs($art,$h,$i,$j,$k,$l,$m,$o,$p,$q,$r,$s,$t);
                            int_Ncustoms($art,$v,$w,$x,$y,$z);
                            continue;
                        }
                    }
                }
            }
        }
    } else {
        $output = '<label class="text-danger">Invalid File</label>'; //if non excel file then


    }
}

function slugify($text)
{
    $slag_str = strtolower($text);
    $slag_str = preg_replace("/\\s+/iu", '-', $slag_str);
    $slag_str = preg_replace('/[\\\\*\$\'"\(\)&@]/u', '-', $slag_str);
    $slag_str = preg_replace('/[-]+/', '-', $slag_str);
    return trim($slag_str, '-');
}
function get_gruop($name,$parent_id){

//    $connect = mysqli_connect("localhost", "root", "", "noorbabi_data");
    $connect = mysqli_connect("localhost", "libraryl_root", "kyz6YWu1vEU7", "libraryl_data");

    mysqli_query($connect, "SET CHARACTER SET utf8");
    mysqli_query($connect, "SET NAMES utf8");
    $slug_id = slugify($name);
    $sql = mysqli_query($connect, "select groupid from tblknowledge_base_groups where group_slug = '$slug_id' and parent_id = '$parent_id' ");//and group_slug = '$slug_id'//name like '%$name%'
    $id = mysqli_fetch_assoc($sql);
    if($id){
        return $id['groupid'];
    }else
        return false;
}
function int_group($name,$parent_id){
//    $connect = mysqli_connect("localhost", "root", "", "noorbabi_data");
    $connect = mysqli_connect("localhost", "libraryl_root", "kyz6YWu1vEU7", "libraryl_data");

    mysqli_query($connect, "SET CHARACTER SET utf8");
    mysqli_query($connect, "SET NAMES utf8");
    $slug_id = slugify($name);
    $sql = "INSERT INTO tblknowledge_base_groups(name, group_slug, active, color, parent_id, is_main)
                        VALUES
                        ('$name','$slug_id','1','','$parent_id','0')";
    if (mysqli_query($connect, $sql)) {
        return mysqli_insert_id($connect);
    }else
        return false;

}

function int_knowledge($g_id,$name)
{
    echo $g_id,'<br>';
//    $connect = mysqli_connect("localhost", "root", "", "noorbabi_data");
    $connect = mysqli_connect("localhost", "libraryl_root", "kyz6YWu1vEU7", "libraryl_data");

    mysqli_query($connect, "SET CHARACTER SET utf8");
    mysqli_query($connect, "SET NAMES utf8");

    $slug_id = slugify($name);
    $sql = "INSERT INTO tblknowledge_base(articlegroup, subject, description, slug, active, datecreated, article_order, staff_article, type)
                        VALUES
                        ('$g_id','$name','','$slug_id','1','2022-04-13 04:02:07','0','0','13')";
    if (mysqli_query($connect, $sql)) {
        return mysqli_insert_id($connect);
    }
    return false;
}

function int_Ncustoms($article_id,$fl_1,$fl_2,$fl_3,$fl_4,$fl_5){
//    $connect = mysqli_connect("localhost", "root", "", "noorbabi_data");
    $connect = mysqli_connect("localhost", "libraryl_root", "kyz6YWu1vEU7", "libraryl_data");

    mysqli_query($connect, "SET CHARACTER SET utf8");
    mysqli_query($connect, "SET NAMES utf8");

    $sql = "INSERT INTO tblknowledge_custom_fields(knowledge_id, title, description)
                                    VALUES
                                    ('$article_id','ملخص الحكم','$fl_1')";
    mysqli_query($connect, $sql);
    $sql = "INSERT INTO tblknowledge_custom_fields(knowledge_id, title, description)
                                    VALUES
                                    ('$article_id','نص الحكم','$fl_2')";
    mysqli_query($connect, $sql);
    $sql = "INSERT INTO tblknowledge_custom_fields(knowledge_id, title, description)
                                    VALUES
                                    ('$article_id','الأسباب','$fl_3')";
    mysqli_query($connect, $sql);
    $sql = "INSERT INTO tblknowledge_custom_fields(knowledge_id, title, description)
                                    VALUES
                                    ('$article_id','السند الشرعي والنظامي','$fl_4')";
    mysqli_query($connect, $sql);
    $sql = "INSERT INTO tblknowledge_custom_fields(knowledge_id, title, description)
                                    VALUES
                                    ('$article_id','قرار الاستئناف','$fl_5')";
    mysqli_query($connect, $sql);
}

function int_customs($article_id,$fld_8,$fld_9,$fld_10,$fld_11,$fld_12,$fld_13,$fld_14,$fld_15,$fld_16,$fld_17,$fld_18,$fld_19)
{
//    $connect = mysqli_connect("localhost", "root", "", "noorbabi_data");
    $connect = mysqli_connect("localhost", "libraryl_root", "kyz6YWu1vEU7", "libraryl_data");

    mysqli_query($connect, "SET CHARACTER SET utf8");
    mysqli_query($connect, "SET NAMES utf8");

    $sql = "INSERT INTO tblcustomfieldsvalues(relid, fieldid, fieldto, value)
                                        VALUES('$article_id','8','kb_13','$fld_8')";
    mysqli_query($connect, $sql);
    $sql = "INSERT INTO tblcustomfieldsvalues(relid, fieldid, fieldto, value)
                                        VALUES('$article_id','9','kb_13','$fld_9')";
    mysqli_query($connect, $sql);
    $sql = "INSERT INTO tblcustomfieldsvalues(relid, fieldid, fieldto, value)
                                        VALUES('$article_id','10','kb_13','$fld_10')";
    mysqli_query($connect, $sql);
    $sql = "INSERT INTO tblcustomfieldsvalues(relid, fieldid, fieldto, value)
                                        VALUES('$article_id','11','kb_13','$fld_11')";
    mysqli_query($connect, $sql);
    $sql = "INSERT INTO tblcustomfieldsvalues(relid, fieldid, fieldto, value)
                                        VALUES('$article_id','12','kb_13','$fld_12')";
    mysqli_query($connect, $sql);
    $sql = "INSERT INTO tblcustomfieldsvalues(relid, fieldid, fieldto, value)
                                        VALUES('$article_id','13','kb_13','$fld_13')";
    mysqli_query($connect, $sql);
    $sql = "INSERT INTO tblcustomfieldsvalues(relid, fieldid, fieldto, value)
                                        VALUES('$article_id','14','kb_13','$fld_14')";
    mysqli_query($connect, $sql);
    $sql = "INSERT INTO tblcustomfieldsvalues(relid, fieldid, fieldto, value)
                                        VALUES('$article_id','15','kb_13','$fld_15')";
    mysqli_query($connect, $sql);
    $sql = "INSERT INTO tblcustomfieldsvalues(relid, fieldid, fieldto, value)
                                        VALUES('$article_id','16','kb_13','$fld_16')";
    mysqli_query($connect, $sql);
    $sql = "INSERT INTO tblcustomfieldsvalues(relid, fieldid, fieldto, value)
                                        VALUES('$article_id','17','kb_13','$fld_17')";
    mysqli_query($connect, $sql);
    $sql = "INSERT INTO tblcustomfieldsvalues(relid, fieldid, fieldto, value)
                                        VALUES('$article_id','18','kb_13','$fld_18')";
    mysqli_query($connect, $sql);
    $sql = "INSERT INTO tblcustomfieldsvalues(relid, fieldid, fieldto, value)
                                        VALUES ('$article_id','19','kb_13','$fld_19')";
    mysqli_query($connect, $sql);
}

?>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container box">
    <form method="post" enctype="multipart/form-data">
        <input type="file" name="excel" />
        <br />
        <input type="submit" name="import" class="btn btn-info" value="Import" />
    </form>
    <br />
    <br />
    <?php
    echo $output;
    ?>
</div>
</body>
</html>
