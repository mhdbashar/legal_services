<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: text/html; charset=utf-8');

//https://www.youtube.com/watch?v=ZwRPKvElM9U
$connect = mysqli_connect("localhost", "root", "", "noorbabi_data");
mysqli_query($connect, "SET CHARACTER SET utf8");
mysqli_query($connect, "SET NAMES utf8");

$output = '';
if (isset($_POST["import"]))
{
    $extension = @end(explode(".", $_FILES["excel"]["name"])); // For getting Extension of selected file
    $allowed_extension = array(
        "xls",
        "xlsx",
        "csv"
    ); //allowed extension
    if (in_array($extension, $allowed_extension)) //check selected file extension is present in allowed extension array
    {
        $file = $_FILES["excel"]["tmp_name"]; // getting temporary source of excel file
        require ('modules/hr/third_party/excel/PHPExcel/IOFactory.php'); // Add PHPExcel Library in this code
        $objPHPExcel = PHPExcel_IOFactory::load($file); // create object of PHPExcel library by using load() method and in load method define path of selected file
        $excelReader = PHPExcel_IOFactory::createReaderForFile($file);
        $excelObj    = $excelReader->load($file);
        $cats = $objPHPExcel->getSheetNames();
//        $objWorksheet = $objPHPExcel->getActiveSheet();
        $i=1;
        $sheet_num = 0;
        $ii = 0;
        foreach ($cats as $catt)
        {
            $worksheet = $excelObj->getSheet($sheet_num);

            $lastRow   = $worksheet->getHighestDataRow();

            $cat = $worksheet->getCell('C1')->getValue();

            $slug_id = slugify($cat);

            $sql = "INSERT INTO tblknowledge_base(articlegroup, subject, description, slug, active, datecreated, article_order, staff_article, type)
            VALUES
            ('2','$cat','','$slug_id','1','2022-04-13 04:02:07','0','0','2')";

//            echo $cat;
//            echo'<br>';

            if (mysqli_query($connect, $sql))
            {
                $cat_id = mysqli_insert_id($connect);

                for ($row = 1; $row <= 7; $row++) {

                    $custom_field_title = $worksheet->getCell('A'.$row)->getValue();

                    $custom_field_title = $custom_field_title != '' ? $custom_field_title : 'لا يوجد';

                    $fld_value = $worksheet->getCell('B'.$row)->getValue();

                    $fld_value = $fld_value != '' ? $fld_value : 'لا يوجد';

                    $sql = "INSERT INTO tblcustomfieldsvalues(relid, fieldid, fieldto, value)
                                        VALUES
                                        ('$cat_id','$row','kb_2','$fld_value')";
                    mysqli_query($connect, $sql);
//                    echo $custom_field_title.$fld_value;
//                    echo '<br>';

                }
                for ($row = 8 ; $row <= 9;$row++) {
                    $custom_field_title = $worksheet->getCell('A' . $row)->getValue();


                    $fld_value = $worksheet->getCell('B' . $row)->getValue();
                    if($custom_field_title != '' && $fld_value != '') {
                        if ($fld_value == '') {
                            $sql = "INSERT INTO tblknowledge_custom_fields(knowledge_id, title, description)
                    VALUES
                    ('$cat_id','معلومات النظام','$fld_value')";
                        } else {
                            $sql = "INSERT INTO tblknowledge_custom_fields(knowledge_id, title, description)
                    VALUES
                    ('$cat_id','$custom_field_title','$fld_value')";

                        }
                        mysqli_query($connect, $sql);
                    }
                }

                for ($row = 10 ; $row <= $lastRow;$row++){
                    $custom_field_title = $worksheet->getCell('A'.$row)->getValue();

                    $custom_field_title = $custom_field_title != '' ? $custom_field_title : 'لا يوجد';

                    $fld_value = $worksheet->getCell('B'.$row)->getValue();

                    $fld_value = $fld_value != '' ? $fld_value : 'لا يوجد';

                    $sql = "INSERT INTO tblknowledge_custom_fields(knowledge_id, title, description)
                    VALUES
                    ('$cat_id','$custom_field_title','$fld_value')";
                    mysqli_query($connect, $sql);


//                    echo $custom_field_title.$fld_value;
//                    echo '<br>';

                }
            echo $lastRow;
            echo '<br>';
            }
            else
            {
                echo "Error: " . $sql . "<br>" . mysqli_error($connect);
            }
            $sheet_num++;
            $i++;
        }
    }
    else
    {
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

?>

<html>
<head>
    <title>Import Excel files By Baraa Alhalabi</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body
        {
            margin:0;
            padding:0;
            background-color:#f1f1f1;
        }
        .box
        {
            width:700px;
            border:1px solid #ccc;
            background-color:#fff;
            border-radius:5px;
            margin-top:100px;
        }

    </style>
</head>
<body>
<div class="container box">
    <h3 align="center">Import Excel files By Baraa Alhalabi</h3><br />
    <form method="post" enctype="multipart/form-data">
<!--        <label>Select Excel File</label>-->
        <input type="file" name="excel" />
        <br />
        <input type="submit" name="import" class="btn btn-info" value="Import" />
<!--        <h5 align="center" style="color:red">The Import Closed Now, call with Developer!</h5>-->
    </form>
    <br />
    <br />
<!--    <p align="center"> Powered by baraa-alhalabi@hotmail.com</p>-->
    <?php
    echo $output;
    ?>
</div>
</body>
</html>
