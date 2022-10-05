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
        $name_category = 'مدونة القرارات والمبادئ العمالية';

        $num_cat =18;
        for ($row = 2; $row <= $lastRow; $row++) {
            $a = $worksheet->getCell('A' . $row)->getValue();//1التصنيف الفرعى
            $b = $worksheet->getCell('B' . $row)->getValue();//2التصنيف الفرعى
            $c = $worksheet->getCell('C' . $row)->getValue();//3التصنيف الفرعى
            $e1 = $worksheet->getCell('E' . $row)->getValue();//الاسم
            $e = substr_replace($e1, "", 0, 72);//الاسم
            $g = $worksheet->getCell('G' . $row)->getValue();//المحتوى
            if ($a != '') {
                $users_a = get_gruop($a,$num_cat);
                if ($users_a) {
                    $cat_a = $users_a;
                    if ($b != '') {
                        $users_b = get_gruop($b,$cat_a);
                        if ($users_b) {
                            $cat_b = $users_b;
                            if ($c != '') {
                                $users_c = get_gruop($c,$cat_b);
                                if ($users_c) {
                                    $cat_id = $users_c;
                                    $knowledge = get_knowledge($e,$cat_id);
                                    if($knowledge) {
                                        int_Ncustoms($knowledge, $g);
                                    }else{
                                        $knowledge = int_knowledge($e,$cat_id);
                                        if($knowledge) {
                                            int_Ncustoms($knowledge, $g);
                                        }
                                    }
                                }else {
                                    $group = int_group($c,$cat_b);
                                    if ($group) {
                                        $knowledge = int_knowledge($e,$group);
                                        if($knowledge) {
                                            int_Ncustoms($knowledge, $g);
                                        }
                                    }
                                }
                            }else{
                                $knowledge = get_knowledge($e,$cat_b);
                                if($knowledge) {
                                    int_Ncustoms($knowledge, $g);
                                }else{
                                    $knowledge = int_knowledge($e,$cat_b);
                                    if($knowledge) {
                                        int_Ncustoms($knowledge, $g);
                                    }
                                }
                            }
                        }else {
                            $group = int_group($b,$cat_a);
                            if ($group) {
                                $cat_b = $group;
                                if ($c != '') {
                                    $group_c = int_group($c,$cat_b);
                                    if ($group_c) {
                                        $knowledge = int_knowledge($e,$group_c);
                                        if ($knowledge) {
                                            int_Ncustoms($knowledge,$g);
                                        }
                                    }
                                } else {
                                    $knowledge = int_knowledge($e,$cat_b);
                                    if ($knowledge) {
                                        int_Ncustoms($knowledge,$g);
                                    }
                                }
                            }
                        }
//
                    } else {
                        $knowledge = get_knowledge($e,$cat_a);
                        if($knowledge) {
                            int_Ncustoms($knowledge, $g);
                        }else{
                            $knowledge = int_knowledge($e,$cat_a);
                            if($knowledge) {
                                int_Ncustoms($knowledge, $g);
                            }
                        }

                    }
                } else {
                    $group_a = int_group($a,$num_cat);
                    if ($group_a) {
                        $cat_a = $group_a;
                        if ($b != '') {
                            $group_b = int_group($b,$cat_a);
                            if ($group_b) {
                                $cat_b = $group_b;
                                if ($c != '') {
                                    $group_c = int_group($c,$cat_b);
                                    if ($group_c) {
                                        $knowledge = int_knowledge($e,$group_c);
                                        if ($knowledge) {
                                            int_Ncustoms($knowledge,$g);
                                        }
                                    }
                                } else {
                                    $knowledge = int_knowledge($e,$cat_b);
                                    if ($knowledge) {
                                        int_Ncustoms($knowledge,$g);
                                    }
                                }
                            }
                        } else {
                            $knowledge = int_knowledge($e,$cat_a);
                            if ($knowledge) {
                                int_Ncustoms($knowledge,$g);
                            }
                        }
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

function get_knowledge($name,$g_id){
//    $connect = mysqli_connect("localhost", "root", "", "noorbabi_data");
    $connect = mysqli_connect("localhost", "libraryl_root", "kyz6YWu1vEU7", "libraryl_data");

    mysqli_query($connect, "SET CHARACTER SET utf8");
    mysqli_query($connect, "SET NAMES utf8");
    $slug_id = slugify($name);
    $sql = mysqli_query($connect, "select articleid from tblknowledge_base where slug = '$slug_id' and articlegroup = '$g_id' ");//and group_slug = '$slug_id'//name like '%$name%'
    $id = mysqli_fetch_assoc($sql);
    if($id){
        return $id['articleid'];
    }else
        return false;
}

function int_knowledge($name,$g_id)
{
//    $connect = mysqli_connect("localhost", "root", "", "noorbabi_data");
    $connect = mysqli_connect("localhost", "libraryl_root", "kyz6YWu1vEU7", "libraryl_data");

    mysqli_query($connect, "SET CHARACTER SET utf8");
    mysqli_query($connect, "SET NAMES utf8");
    $slug_id = slugify($name);
    $sql = "INSERT INTO tblknowledge_base(articlegroup, subject, description, slug, active, datecreated, article_order, staff_article, type)
                        VALUES
                        ('$g_id','$name','','$slug_id','1','2022-04-13 04:02:07','0','0','18')";
    if (mysqli_query($connect, $sql)) {
        return mysqli_insert_id($connect);
    }else
        return false;
}

function int_Ncustoms($article_id,$fl_1){
//    $connect = mysqli_connect("localhost", "root", "", "noorbabi_data");
    $connect = mysqli_connect("localhost", "libraryl_root", "kyz6YWu1vEU7", "libraryl_data");

    mysqli_query($connect, "SET CHARACTER SET utf8");
    mysqli_query($connect, "SET NAMES utf8");
    $sql = "INSERT INTO tblknowledge_custom_fields(knowledge_id, title, description)
                                    VALUES
                                    ('$article_id','','$fl_1')";
    mysqli_query($connect, $sql);
    echo $article_id.'<br>';
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
