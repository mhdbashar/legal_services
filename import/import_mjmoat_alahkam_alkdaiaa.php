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
        $sheet_num = 0;
        $worksheet = $excelObj->getSheet($sheet_num);
        $lastRow = $worksheet->getHighestRow();
        $num = 19;//مجموعة الأحكام القضائية
        for ($row = 2; $row <= $lastRow; $row++) {
            $a = $worksheet->getCell('A' . $row)->getValue();//الاسم
            $b = $worksheet->getCell('B' . $row)->getValue();//قرار الدائرة الرابعة
            $c = $worksheet->getCell('C' . $row)->getValue();//التاريخ
            $d = $worksheet->getCell('D' . $row)->getValue();//الحكم في القضية رقم
            $e = $worksheet->getCell('E' . $row)->getValue();//لعام
            $e = $e != '' ? $e : 'لا يوجد';
            $g = $worksheet->getCell('G' . $row)->getValue();//ملخص الحكم
            $g = $g != '' ? $g : 'لا يوجد';

            $h = $worksheet->getCell('H' . $row)->getValue();//نص الحكم
            $h = $h != '' ? $h : 'لا يوجد';

            $i = $worksheet->getCell('I' . $row)->getValue();//الأسباب
            $i = $i != '' ? $i : 'لا يوجد';

            $j = $worksheet->getCell('J' . $row)->getValue();//السند الشرعي والنظامي
            $j = $j != '' ? $j : 'لا يوجد';

            $k = $worksheet->getCell('K' . $row)->getValue();//قرار الاستئناف
            $k = $k != '' ? $k : 'لا يوجد';

            $a = $b != '' && $d == '' ? $a . ' ' . 'قرار الدائرة الرابعة بالمحكمة العليا : ' . $b : $a;
            $a = $b == '' && $d != '' ? $a . ' ' . 'الحكم في القضية : ' . $d : $a;

            $name = $a;
            $knowledge_id = int_knowledge($num,$name);
            if ($knowledge_id) {
                int_customs($knowledge_id,$b,$c,$d,$e);
                int_Ncustoms($knowledge_id,$g,$h,$i,$j,$k);
            } else {
                echo "Error: "  . "<br>" . mysqli_error($connect);
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
function int_knowledge($g_id,$name)
{
//    $connect = mysqli_connect("localhost", "root", "", "noorbabi_data");
    $connect = mysqli_connect("localhost", "libraryl_root", "kyz6YWu1vEU7", "libraryl_data");
    mysqli_query($connect, "SET CHARACTER SET utf8");
    mysqli_query($connect, "SET NAMES utf8");

    $slug_id = slugify($name);
    $sql = "INSERT INTO tblknowledge_base(articlegroup, subject, description, slug, active, datecreated, article_order, staff_article, type)
                        VALUES
                        ('$g_id','$name','','$slug_id','1','2022-04-13 04:02:07','0','0','$g_id')";
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

function int_customs($article_id,$fld_20,$fld_21,$fld_22,$fld_23)
{
//    $connect = mysqli_connect("localhost", "root", "", "noorbabi_data");
    $connect = mysqli_connect("localhost", "libraryl_root", "kyz6YWu1vEU7", "libraryl_data");
    mysqli_query($connect, "SET CHARACTER SET utf8");
    mysqli_query($connect, "SET NAMES utf8");

    $sql = "INSERT INTO tblcustomfieldsvalues(relid, fieldid, fieldto, value)
                                        VALUES('$article_id','20','kb_19','$fld_20')";
    mysqli_query($connect, $sql);
    $sql = "INSERT INTO tblcustomfieldsvalues(relid, fieldid, fieldto, value)
                                        VALUES('$article_id','21','kb_19','$fld_21')";
    mysqli_query($connect, $sql);
    $sql = "INSERT INTO tblcustomfieldsvalues(relid, fieldid, fieldto, value)
                                        VALUES('$article_id','22','kb_19','$fld_22')";
    mysqli_query($connect, $sql);
    $sql = "INSERT INTO tblcustomfieldsvalues(relid, fieldid, fieldto, value)
                                        VALUES('$article_id','23','kb_19','$fld_23')";
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
