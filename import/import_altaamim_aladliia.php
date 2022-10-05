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
        $excelObj    = $excelReader->load($file);
        $objWorksheet = $objPHPExcel->getActiveSheet();
        $ii = 1;
        $sheet_num = 0;
        $worksheet = $excelObj->getSheet($sheet_num);
        $lastRow = $worksheet->getHighestRow();
        $AA = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
        $BB = ['B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];

        $num = 3;//التعاميم العدلية

        for ($row = 1; $row <= $lastRow; $row++) {
            $a = $worksheet->getCell("A".$row)->getValue();
            if($a != ''){
                $slug_id = slugify($a);
                $sql = "INSERT INTO tblknowledge_base(articlegroup, subject, description, slug, active, datecreated, article_order, staff_article, type)
                        VALUES
                        ('$num','$a','','$slug_id','1','2022-04-13 04:02:07','0','0','$num')";
                if (mysqli_query($connect, $sql))
                {
                    $cat_id = mysqli_insert_id($connect);
                }
                else
                {
                    echo "Error: " . $sql . "<br>" . mysqli_error($connect);
                }
            }
            else {
                continue;
            }
            foreach ($BB as $A) {
                $x = "$A" . $row;
                $h = $worksheet->getCell("$x")->getValue();
                if ($h != '') {
                    $hh = $h;
                    $custom_field_title = $h;
                    $row1 = $row + 1;
                    $x = "$A".$row1;
                    $h = $worksheet->getCell("$x")->getValue();
                    $fld_value = $h;
                    $sql = "INSERT INTO tblknowledge_custom_fields(knowledge_id, title, description)
                    VALUES
                    ('$cat_id','$custom_field_title','$fld_value')";
                    mysqli_query($connect, $sql);
                }
                else{
                    continue;
                }

            }
            foreach ($AA as $a){
                foreach ($AA as $b){
                    $i = "$a" . "$b" . $row;
                    $h = $worksheet->getCell("$i")->getValue();
                    if($h != '') {
                        $custom_field_title = $h;
                        $x = "$a" . "$b" . $row1;
                        $h = $worksheet->getCell("$x")->getValue();
                        $fld_value = $h;
                        $sql = "INSERT INTO tblknowledge_custom_fields(knowledge_id, title, description)
                    VALUES
                    ('$cat_id','$custom_field_title','$fld_value')";
                        mysqli_query($connect, $sql);
                    }
                    else{
                        continue;
                    }

                }
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
