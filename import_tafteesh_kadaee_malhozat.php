<?php //by mohammad nour watfa
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: text/html; charset=utf-8');

//https://www.youtube.com/watch?v=ZwRPKvElM9U
$connect = mysqli_connect("localhost", "libraryb_libadmin", "Wu)_25nodw#U", "libraryb_baraa");
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

        require('Classes/PHPExcel/IOFactory.php'); // Add PHPExcel Library in this code
        $objPHPExcel = PHPExcel_IOFactory::load($file); // create object of PHPExcel library by using load() method and in load method define path of selected file
        $excelReader = PHPExcel_IOFactory::createReaderForFile($file);
        $excelObj = $excelReader->load($file);
        $objWorksheet = $objPHPExcel->getActiveSheet();
        $ii = 1;
        $sheet_num = 0;
        $worksheet = $excelObj->getSheet($sheet_num);
        $lastRow = $worksheet->getHighestRow();
//        $HighestColumn = $worksheet->getHighestColumn();
        $AA = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
        $BB = ['B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
        $num = 0;
        for ($row = 1; $row <= $lastRow; $row++) {
            $a = $worksheet->getCell("A".$row)->getValue();
            if($row == 1 && $row < 17){
                $num = 5824;//الملحوظات في القضايا الجنائية
            }
            if($row == 17 && $row < 51){
                $num = 5825;//الملحوظات في القضايا الحقوقية
            }
            if($row == 51 && $row < 81){
                $num = 5826;//الملحوظات في الإنهاءات
            }
            if($row == 81 && $row < 111){
                $num = 5827;//الملحوظات العامة
            }
            if($a != ''){
                echo $a;
                $sql = "INSERT INTO category(title, parent_category, parent_category_path, show_on, status)
            VALUES
            ('$a',$num,'1-5823-$num','K','A')";
                if (mysqli_query($connect, $sql))
                {
                    $cat_id = mysqli_insert_id($connect);

                    $slug_id = slugify($a, '-');
                    $sql = "INSERT INTO knowledge(slug_id, cat_id, title, k_body, v_count, l_count, d_count, is_stickey, added_by, k_tag, k_soundex, entry_time, featured_video_link, last_update_time, status)
                        VALUES
                        ('$slug_id',$cat_id,'$a','',0,0,0,'N','AA','','',CURRENT_TIMESTAMP(),'',CURRENT_TIMESTAMP(),'P')";

                    if (mysqli_query($connect, $sql))
                    {
                        $knowledge_id = mysqli_insert_id($connect);
                    }
                    else
                    {
                        echo "Error: " . $sql . "<br>" . mysqli_error($connect);
                    }
                }
                else
                {
                    echo "Error: " . $sql . "<br>" . mysqli_error($connect);
                }
                echo '// A'.$row;
                echo '<br>';
            }
            else {
                continue;
            }

            for($xx = 0; $xx <= 7; $xx++){
                $custom_field_title = '';
                $fld_value = '';
                $sql = "INSERT INTO custom_field(cat_id, title, help_text, type, opt_json_base, is_required, default_value, is_api_based, is_private, is_on_grid, api_name, on_submit_api_check, status, fld_order)
                VALUES
                ('$cat_id','$custom_field_title','','T','','N','','N','N','N','','N','A',$ii)";
                mysqli_query($connect, $sql);
                $custom_id = mysqli_insert_id($connect);
                $sql = "INSERT INTO knowledge_custom_field
                (knowledge_id, custom_id, fld_title, fld_type, fld_value, fld_value_text, is_api_based, api_name, api_data)
                VALUES
                ('$knowledge_id','$custom_id','$custom_field_title','T','$fld_value','','N','','')";
                mysqli_query($connect, $sql);
            }

            foreach ($BB as $A) {
                $x = "$A" . $row;
                $h = $worksheet->getCell("$x")->getValue();
                if ($h != '') {
                    $hh = strpbrk($h,' ');
                    echo $hh.'=== >';

                    $custom_field_title = $hh;
                    $sql = "INSERT INTO custom_field(cat_id, title, help_text, type, opt_json_base, is_required, default_value, is_api_based, is_private, is_on_grid, api_name, on_submit_api_check, status, fld_order)
                        VALUES
                        ('$cat_id','$custom_field_title','','T','','N','','N','N','N','','N','A',$ii)";
                    mysqli_query($connect, $sql);
                    $custom_id = mysqli_insert_id($connect);

                    echo '// '.$x;
                    echo '<br>';
                    $row1 = $row + 1;
                    $x = "$A".$row1;
                    $h = $worksheet->getCell("$x")->getValue();//التصنيف الفرعى
                    echo $h;

                    $fld_value = $h;
                    $sql = "INSERT INTO knowledge_custom_field
                        (knowledge_id, custom_id, fld_title, fld_type, fld_value, fld_value_text, is_api_based, api_name, api_data)
                        VALUES
                        ('$knowledge_id','$custom_id','$custom_field_title','T','$fld_value','','N','','')";
                    mysqli_query($connect, $sql);

                    echo '<br>';
                }
                else{
                    continue;
                }

            }
            foreach ($AA as $a){
                foreach ($AA as $b){
                    $i = "$a" . "$b" . $row;
                    $h = $worksheet->getCell("$i")->getValue();//التصنيف الفرعى
                    if($h != '') {
                        $hh = strpbrk($h,' ');
                        echo $hh.'=== >';

                        $custom_field_title = $hh;
                        $sql = "INSERT INTO custom_field(cat_id, title, help_text, type, opt_json_base, is_required, default_value, is_api_based, is_private, is_on_grid, api_name, on_submit_api_check, status, fld_order)
                        VALUES
                        ('$cat_id','$custom_field_title','','T','','N','','N','N','N','','N','A',$ii)";
                        mysqli_query($connect, $sql);
                        $custom_id = mysqli_insert_id($connect);

                        echo '// '.$i;
                        echo '<br>';
                        $x = "$a" . "$b" . $row1;
                        $h = $worksheet->getCell("$x")->getValue();//التصنيف الفرعى
                        echo $h;

                        $fld_value = $h;
                        $sql = "INSERT INTO knowledge_custom_field
                        (knowledge_id, custom_id, fld_title, fld_type, fld_value, fld_value_text, is_api_based, api_name, api_data)
                        VALUES
                        ('$knowledge_id','$custom_id','$custom_field_title','T','$fld_value','','N','','')";
                        mysqli_query($connect, $sql);

                        echo '<br>';
                    }
                }
            }




        }


//        exit();
    } else {
        $output = '<label class="text-danger">Invalid File</label>'; //if non excel file then


    }
}

function slugify($text, string $divider = '-')
{
    // replace non letter or digits by divider
    $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

    // transliterate
    // $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    // remove unwanted characters
    //$text = preg_replace('~[^-\w]+~', '', $text);
    // trim
    $text = trim($text, $divider);
    // remove duplicate divider
    $text = preg_replace('~-+~', $divider, $text);
    // lowercase
    $text = strtolower($text);
    if (empty($text))
    {
        return 'n-a';
    }
    return $text;
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
        <label>Select Excel File</label>
        <input type="file" name="excel" />
        <br />
        <input type="submit" name="import" class="btn btn-info" value="Import" />
        <h5 align="center" style="color:red">The Import Closed Now, call with Developer!</h5>
    </form>
    <br />
    <br />
    <p align="center"> Powered by baraa-alhalabi@hotmail.com</p>
    <?php
    echo $output;
    ?>
</div>
</body>
</html>
