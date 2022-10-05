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
        $num = 11;

        for ($row = 2; $row <= $lastRow; $row++) {
            $a = $worksheet->getCell("B".$row)->getValue();
            $a = substr_replace($a, "", 0, 72);
            if($a != '') {
                $slug_name = slugify($a);
                $sql = mysqli_query($connect, "select articleid from tblknowledge_base 
                        where (subject = '$a' and slug = '$slug_name' and articlegroup = '$num' and type = '$num')");
                $knowledge = mysqli_fetch_assoc($sql);
                if ($knowledge) {
                    $cat_id = $knowledge['articleid'];
                    $fld_value = $worksheet->getCell("D" . $row)->getValue();
                    $custom_field_title = $worksheet->getCell("A" . $row)->getValue();
                    $sql = "INSERT INTO tblknowledge_custom_fields(knowledge_id, title, description)
                            VALUES
                            ('$cat_id','$custom_field_title','$fld_value')";
                    mysqli_query($connect, $sql);
                } else {
                    $sql = "INSERT INTO tblknowledge_base(articlegroup, subject, description, slug, active, datecreated, article_order, staff_article, type)
                            VALUES
                            ('$num','$a','','$slug_name','1','2022-04-13 04:02:07','0','0','$num')";
                    if (mysqli_query($connect, $sql)) {
                        $cat_id = mysqli_insert_id($connect);
                        $fld_value = $worksheet->getCell("D" . $row)->getValue();
                        $custom_field_title = $worksheet->getCell("A" . $row)->getValue();
                        $sql = "INSERT INTO tblknowledge_custom_fields(knowledge_id, title, description)
                        VALUES
                        ('$cat_id','$custom_field_title','$fld_value')";
                        mysqli_query($connect, $sql);
                    }
                    else {
                        echo "Error: " . $sql . "<br>" . mysqli_error($connect);
                    }
                }
            }
            else {
                continue;
            }
        }
        echo 'done';
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
