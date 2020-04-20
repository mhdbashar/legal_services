<?php
/*
    attendance
*/
defined('BASEPATH') or exit('No direct script access allowed');
$aColumns = [
    'CONCAT(firstname, " ", lastname) as fullname', 

    db_prefix().'hr_extra_info.emloyee_id as employee_id',

    db_prefix().'branches.title_en as branch_id', 

    'CASE 
    WHEN ISNULL((SELECT time_in FROM '.db_prefix().'hr_attendance WHERE '.db_prefix().'hr_attendance.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendance.created=\"$date\"".'))
    THEN "Absent" 
    ELSE "Present"
    END as status',

    'CASE 
    WHEN ISNULL((SELECT time_in FROM '.db_prefix().'hr_attendance WHERE '.db_prefix().'hr_attendance.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendance.created=\"$date\"".'))
    THEN "-" 
    ELSE (SELECT time_in FROM '.db_prefix().'hr_attendance WHERE '.db_prefix().'hr_attendance.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendance.created=\"$date\"".') 
    END as time_in',

    'CASE 
        WHEN DAYNAME("'.$date.'") = "Saturday" AND !ISNULL((SELECT time_in FROM '.db_prefix().'hr_attendance WHERE '.db_prefix().'hr_attendance.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendance.created=\"$date\"".'))
            AND time_in >= (SELECT saturday_in FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id )
            THEN SUBTIME(time_in, (SELECT saturday_in FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id ))
        
        WHEN DAYNAME("'.$date.'") = "Sunday" AND !ISNULL((SELECT time_in FROM '.db_prefix().'hr_attendance WHERE '.db_prefix().'hr_attendance.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendance.created=\"$date\"".'))
            AND time_in >= (SELECT sunday_in FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id )
            THEN SUBTIME(time_in, (SELECT sunday_in FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id ))
        
        WHEN DAYNAME("'.$date.'") = "Monday" AND !ISNULL((SELECT time_in FROM '.db_prefix().'hr_attendance WHERE '.db_prefix().'hr_attendance.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendance.created=\"$date\"".'))
            AND time_in >= (SELECT monday_in FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id )
            THEN SUBTIME(time_in, (SELECT monday_in FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id ))
        
        WHEN DAYNAME("'.$date.'") = "Tuesday" AND !ISNULL((SELECT time_in FROM '.db_prefix().'hr_attendance WHERE '.db_prefix().'hr_attendance.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendance.created=\"$date\"".'))
            AND time_in >= (SELECT tuesday_in FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id )
            THEN SUBTIME(time_in, (SELECT tuesday_in FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id ))
        
        WHEN DAYNAME("'.$date.'") = "Wednesday" AND !ISNULL((SELECT time_in FROM '.db_prefix().'hr_attendance WHERE '.db_prefix().'hr_attendance.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendance.created=\"$date\"".'))
            AND time_in >= (SELECT wednesday_in FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id )
            THEN SUBTIME(time_in, (SELECT wednesday_in FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id ))
        
        WHEN DAYNAME("'.$date.'") = "Thursday" AND !ISNULL((SELECT time_in FROM '.db_prefix().'hr_attendance WHERE '.db_prefix().'hr_attendance.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendance.created=\"$date\"".'))
            AND time_in >= (SELECT thursday_in FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id )
            THEN SUBTIME(time_in, (SELECT thursday_in FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id ))
        
        WHEN DAYNAME("'.$date.'") = "Friday" AND !ISNULL((SELECT time_in FROM '.db_prefix().'hr_attendance WHERE '.db_prefix().'hr_attendance.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendance.created=\"$date\"".'))
            AND time_in >= (SELECT friday_in FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id )
            THEN SUBTIME(time_in, (SELECT friday_in FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id ))
        
        ELSE 
            "00:00"
    END as late',

    'CASE 
        WHEN DAYNAME("'.$date.'") = "Saturday" AND !ISNULL((SELECT time_out FROM '.db_prefix().'hr_attendance WHERE '.db_prefix().'hr_attendance.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendance.created=\"$date\"".'))
            AND time_out >= (SELECT saturday_out FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id )
            THEN SUBTIME(time_out, (SELECT saturday_out FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id ))
        
        WHEN DAYNAME("'.$date.'") = "Sunday" AND !ISNULL((SELECT time_out FROM '.db_prefix().'hr_attendance WHERE '.db_prefix().'hr_attendance.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendance.created=\"$date\"".'))
            AND time_out >= (SELECT sunday_out FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id )
            THEN SUBTIME(time_out, (SELECT sunday_out FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id ))
        
        WHEN DAYNAME("'.$date.'") = "Monday" AND !ISNULL((SELECT time_out FROM '.db_prefix().'hr_attendance WHERE '.db_prefix().'hr_attendance.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendance.created=\"$date\"".'))
            AND time_out >= (SELECT monday_out FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id )
            THEN SUBTIME(time_out, (SELECT monday_out FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id ))
        
        WHEN DAYNAME("'.$date.'") = "Tuesday" AND !ISNULL((SELECT time_out FROM '.db_prefix().'hr_attendance WHERE '.db_prefix().'hr_attendance.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendance.created=\"$date\"".'))
            AND time_out >= (SELECT tuesday_out FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id )
            THEN SUBTIME(time_out, (SELECT tuesday_out FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id ))
        
        WHEN DAYNAME("'.$date.'") = "Wednesday" AND !ISNULL((SELECT time_out FROM '.db_prefix().'hr_attendance WHERE '.db_prefix().'hr_attendance.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendance.created=\"$date\"".'))
            AND time_out >= (SELECT wednesday_out FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id )
            THEN SUBTIME(time_out, (SELECT wednesday_out FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id ))
        
        WHEN DAYNAME("'.$date.'") = "Thursday" AND !ISNULL((SELECT time_out FROM '.db_prefix().'hr_attendance WHERE '.db_prefix().'hr_attendance.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendance.created=\"$date\"".'))
            AND time_out >= (SELECT thursday_out FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id )
            THEN SUBTIME(time_out, (SELECT thursday_out FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id ))
        
        WHEN DAYNAME("'.$date.'") = "Friday" AND !ISNULL((SELECT time_out FROM '.db_prefix().'hr_attendance WHERE '.db_prefix().'hr_attendance.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendance.created=\"$date\"".'))
            AND time_out >= (SELECT friday_out FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id )
            THEN SUBTIME(time_out, (SELECT friday_out FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id ))
        
        ELSE 
            "00:00"
    END as over_time',

    'CASE 
        WHEN DAYNAME("'.$date.'") = "Saturday" AND !ISNULL((SELECT time_out FROM '.db_prefix().'hr_attendance WHERE '.db_prefix().'hr_attendance.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendance.created=\"$date\"".'))
            AND time_out <= (SELECT saturday_out FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id )
            THEN SUBTIME((SELECT saturday_out FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id ), time_out)
        
        WHEN DAYNAME("'.$date.'") = "Sunday" AND !ISNULL((SELECT time_out FROM '.db_prefix().'hr_attendance WHERE '.db_prefix().'hr_attendance.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendance.created=\"$date\"".'))
            AND time_out <= (SELECT sunday_out FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id )
            THEN SUBTIME((SELECT sunday_out FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id ), time_out)
        
        WHEN DAYNAME("'.$date.'") = "Monday" AND !ISNULL((SELECT time_out FROM '.db_prefix().'hr_attendance WHERE '.db_prefix().'hr_attendance.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendance.created=\"$date\"".'))
            AND time_out <= (SELECT monday_out FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id )
            THEN SUBTIME((SELECT monday_out FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id ), time_out)
        
        WHEN DAYNAME("'.$date.'") = "Tuesday" AND !ISNULL((SELECT time_out FROM '.db_prefix().'hr_attendance WHERE '.db_prefix().'hr_attendance.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendance.created=\"$date\"".'))
            AND time_out <= (SELECT tuesday_out FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id )
            THEN SUBTIME((SELECT tuesday_out FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id ), time_out)
        
        WHEN DAYNAME("'.$date.'") = "Wednesday" AND !ISNULL((SELECT time_out FROM '.db_prefix().'hr_attendance WHERE '.db_prefix().'hr_attendance.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendance.created=\"$date\"".'))
            AND time_out <= (SELECT wednesday_out FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id )
            THEN SUBTIME((SELECT wednesday_out FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id ), time_out)
        
        WHEN DAYNAME("'.$date.'") = "Thursday" AND !ISNULL((SELECT time_out FROM '.db_prefix().'hr_attendance WHERE '.db_prefix().'hr_attendance.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendance.created=\"$date\"".'))
            AND time_out <= (SELECT thursday_out FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id )
            THEN SUBTIME((SELECT thursday_out FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id ), time_out)
        
        WHEN DAYNAME("'.$date.'") = "Friday" AND !ISNULL((SELECT time_out FROM '.db_prefix().'hr_attendance WHERE '.db_prefix().'hr_attendance.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendance.created=\"$date\"".'))
            AND time_out <= (SELECT friday_out FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id )
            THEN SUBTIME((SELECT friday_out FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id ), time_out)
        
        ELSE 
            "00:00"
    END as early_leaving',


    //'time_in',
    'CASE 
    WHEN ISNULL((SELECT time_out FROM '.db_prefix().'hr_attendance WHERE '.db_prefix().'hr_attendance.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendance.created=\"$date\"".'))
    THEN "-" 
    ELSE (SELECT time_out FROM '.db_prefix().'hr_attendance WHERE '.db_prefix().'hr_attendance.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendance.created=\"$date\"".') 
    END as time_out',

    'CASE 
    WHEN ISNULL((SELECT time_out FROM '.db_prefix().'hr_attendance WHERE '.db_prefix().'hr_attendance.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendance.created=\"$date\"".'))
    THEN "-" 
    ELSE SUBTIME(time_out, time_in)
    END as total_work',

    'CURDATE() as created'
];

$sIndexColumn = 'id';
$sTable       = db_prefix().'hr_extra_info';

$join = [
    'LEFT JOIN '.db_prefix().'hr_attendance ON '.db_prefix().'hr_attendance.staff_id='.db_prefix().'hr_extra_info.staff_id',
    'INNER JOIN '.db_prefix().'staff ON '.db_prefix().'staff.staffid='.db_prefix().'hr_extra_info.staff_id',


	'LEFT JOIN '.db_prefix().'branches_services ON '.db_prefix().'branches_services.rel_id='.db_prefix().'staff.staffid AND '.db_prefix().'branches_services.rel_type="staff"',
	'LEFT JOIN '.db_prefix().'branches ON '.db_prefix().'branches.id='.db_prefix().'branches_services.branch_id',

    'LEFT JOIN '.db_prefix().'hr_office_shift ON '.db_prefix().'hr_office_shift.id='.db_prefix().'hr_extra_info.office_sheft',
];

//echo $date; exit;
$where = [];


$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [db_prefix().'hr_extra_info.id']);
$output  = $result['output'];
$rResult = $result['rResult'];
//var_dump($date); exit;

foreach ($rResult as $aRow) {
    $row = [];
    
    $row[] = $aRow['fullname'];

    $row[] = $aRow['employee_id'];

    $row[] = $aRow['branch_id'];

    $row[] = $date;

    $row[] = $aRow['status'];

    $row[] = $aRow['time_in'];

    $row[] = $aRow['time_out'];

    $row[] = $aRow['late'];

    $row[] = $aRow['early_leaving'];

    $row[] = $aRow['over_time'];

    $row[] = $aRow['total_work'];

    $output['aaData'][] = $row;
}
