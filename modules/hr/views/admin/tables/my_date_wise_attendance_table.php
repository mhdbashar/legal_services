<?php
/*
    attendance
*/
$date = '2020-04-20';
defined('BASEPATH') or exit('No direct script access allowed');
$aColumns = [
    'CONCAT(firstname, " ", lastname) as fullname', 

    db_prefix().'hr_extra_info.emloyee_id as employee_id',

    'CASE 
    WHEN ISNULL((SELECT MAX(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".'))
    THEN "Absent" 
    ELSE "Present"
    END as status',

    'CASE 
    WHEN ISNULL((SELECT MAX(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"in\"".'ORDER BY id LIMIT 1))
    THEN "-" 
    ELSE (SELECT MIN(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"in\"".'ORDER BY id LIMIT 1)
    END as time_in',

    'CASE 
        WHEN DAYNAME((SELECT created FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"in\"".'ORDER BY id LIMIT 1)) = "Saturday" AND !ISNULL((SELECT MIN(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"in\"".'ORDER BY id LIMIT 1))
            AND (SELECT MIN(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"in\"".'ORDER BY id LIMIT 1) >= (SELECT saturday_in FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id )
            THEN SUBTIME((SELECT MIN(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"in\"".'ORDER BY id LIMIT 1), (SELECT saturday_in FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id ))
        
        WHEN DAYNAME((SELECT created FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"in\"".'ORDER BY id LIMIT 1)) = "Sunday" AND !ISNULL((SELECT MIN(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"in\"".'ORDER BY id LIMIT 1))
            AND (SELECT MIN(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"in\"".'ORDER BY id LIMIT 1) >= (SELECT sunday_in FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id )
            THEN SUBTIME((SELECT MIN(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"in\"".'ORDER BY id LIMIT 1), (SELECT sunday_in FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id ))
        
        WHEN DAYNAME((SELECT created FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"in\"".'ORDER BY id LIMIT 1)) = "Monday" AND !ISNULL((SELECT MIN(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"in\"".'ORDER BY id LIMIT 1))
            AND (SELECT MIN(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"in\"".'ORDER BY id LIMIT 1) >= (SELECT monday_in FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id )
            THEN SUBTIME((SELECT MIN(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"in\"".'ORDER BY id LIMIT 1), (SELECT monday_in FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id ))
        
        WHEN DAYNAME((SELECT created FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"in\"".'ORDER BY id LIMIT 1)) = "Tuesday" AND !ISNULL((SELECT MIN(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"in\"".'ORDER BY id LIMIT 1))
            AND (SELECT MIN(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"in\"".'ORDER BY id LIMIT 1) >= (SELECT tuesday_in FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id )
            THEN SUBTIME((SELECT MIN(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"in\"".'ORDER BY id LIMIT 1), (SELECT tuesday_in FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id ))
        
        WHEN DAYNAME((SELECT created FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"in\"".'ORDER BY id LIMIT 1)) = "Wednesday" AND !ISNULL((SELECT MIN(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"in\"".'ORDER BY id LIMIT 1))
            AND (SELECT MIN(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"in\"".'ORDER BY id LIMIT 1) >= (SELECT wednesday_in FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id )
            THEN SUBTIME((SELECT MIN(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"in\"".'ORDER BY id LIMIT 1), (SELECT wednesday_in FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id ))
        
        WHEN DAYNAME((SELECT created FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"in\"".'ORDER BY id LIMIT 1)) = "Thursday" AND !ISNULL((SELECT MIN(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"in\"".'ORDER BY id LIMIT 1))
            AND (SELECT MIN(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"in\"".'ORDER BY id LIMIT 1) >= (SELECT thursday_in FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id )
            THEN SUBTIME((SELECT MIN(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"in\"".'ORDER BY id LIMIT 1), (SELECT thursday_in FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id ))
        
        WHEN DAYNAME((SELECT created FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"in\"".'ORDER BY id LIMIT 1)) = "Friday" AND !ISNULL((SELECT MIN(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"in\"".'ORDER BY id LIMIT 1))
            AND (SELECT MIN(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"in\"".'ORDER BY id LIMIT 1) >= (SELECT friday_in FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id )
            THEN SUBTIME((SELECT MIN(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"in\"".'ORDER BY id LIMIT 1), (SELECT friday_in FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id ))
        
        ELSE 
            "-"
    END as late',

    'CASE 
        WHEN DAYNAME((SELECT created FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"in\"".'ORDER BY id LIMIT 1)) = "Saturday" AND !ISNULL((SELECT MAX(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"out\"".'ORDER BY id DESC LIMIT 1))
            AND (SELECT MAX(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"out\"".'ORDER BY id LIMIT 1) >= (SELECT saturday_out FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id )
            THEN SUBTIME((SELECT MAX(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"out\"".'ORDER BY id LIMIT 1), (SELECT saturday_out FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id ))
        
        WHEN DAYNAME((SELECT created FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"in\"".'ORDER BY id LIMIT 1)) = "Sunday" AND !ISNULL((SELECT MAX(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"out\"".'ORDER BY id DESC LIMIT 1))
            AND (SELECT MAX(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"out\"".'ORDER BY id LIMIT 1) >= (SELECT sunday_out FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id )
            THEN SUBTIME((SELECT MAX(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"out\"".'ORDER BY id LIMIT 1), (SELECT sunday_out FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id ))
        
        WHEN DAYNAME((SELECT created FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"in\"".'ORDER BY id LIMIT 1)) = "Monday" AND !ISNULL((SELECT MAX(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"out\"".'ORDER BY id DESC LIMIT 1))
            AND (SELECT MAX(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"out\"".'ORDER BY id LIMIT 1) >= (SELECT monday_out FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id )
            THEN SUBTIME((SELECT MAX(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"out\"".'ORDER BY id LIMIT 1), (SELECT monday_out FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id ))
        
        WHEN DAYNAME((SELECT created FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"in\"".'ORDER BY id LIMIT 1)) = "Tuesday" AND !ISNULL((SELECT MAX(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"out\"".'ORDER BY id DESC LIMIT 1))
            AND (SELECT MAX(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"out\"".'ORDER BY id LIMIT 1) >= (SELECT tuesday_out FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id )
            THEN SUBTIME((SELECT MAX(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"out\"".'ORDER BY id LIMIT 1), (SELECT tuesday_out FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id ))
        
        WHEN DAYNAME((SELECT created FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"in\"".'ORDER BY id LIMIT 1)) = "Wednesday" AND !ISNULL((SELECT MAX(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"out\"".'ORDER BY id DESC LIMIT 1))
            AND (SELECT MAX(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"out\"".'ORDER BY id LIMIT 1) >= (SELECT wednesday_out FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id )
            THEN SUBTIME((SELECT MAX(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"out\"".'ORDER BY id LIMIT 1), (SELECT wednesday_out FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id ))
        
        WHEN DAYNAME((SELECT created FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"in\"".'ORDER BY id LIMIT 1)) = "Thursday" AND !ISNULL((SELECT MAX(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"out\"".'ORDER BY id DESC LIMIT 1))
            AND (SELECT MAX(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"out\"".'ORDER BY id LIMIT 1) >= (SELECT thursday_out FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id )
            THEN SUBTIME((SELECT MAX(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"out\"".'ORDER BY id LIMIT 1), (SELECT thursday_out FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id ))
        
        WHEN DAYNAME((SELECT created FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"in\"".'ORDER BY id LIMIT 1)) = "Friday" AND !ISNULL((SELECT MAX(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"out\"".'ORDER BY id DESC LIMIT 1))
            AND (SELECT MAX(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"out\"".'ORDER BY id LIMIT 1) >= (SELECT friday_out FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id )
            THEN SUBTIME((SELECT MAX(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"out\"".'ORDER BY id LIMIT 1), (SELECT friday_out FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id ))
        
        ELSE 
            "-"
    END as over_time',

    'CASE 
        WHEN DAYNAME((SELECT created FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"in\"".'ORDER BY id LIMIT 1)) = "Saturday" AND !ISNULL((SELECT MAX(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"out\"".'ORDER BY id DESC LIMIT 1))
            AND (SELECT MAX(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"out\"".'ORDER BY id LIMIT 1) <= (SELECT saturday_out FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id )
            THEN SUBTIME((SELECT sunday_out FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id ), (SELECT MAX(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"out\"".'ORDER BY id LIMIT 1))
        
        WHEN DAYNAME((SELECT created FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"in\"".'ORDER BY id LIMIT 1)) = "Sunday" AND !ISNULL((SELECT MAX(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"out\"".'ORDER BY id DESC LIMIT 1))
            AND (SELECT MAX(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"out\"".'ORDER BY id LIMIT 1) <= (SELECT sunday_out FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id )
            THEN SUBTIME((SELECT sunday_out FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id ), (SELECT MAX(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"out\"".'ORDER BY id LIMIT 1))
        
        WHEN DAYNAME((SELECT created FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"in\"".'ORDER BY id LIMIT 1)) = "Monday" AND !ISNULL((SELECT MAX(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"out\"".'ORDER BY id DESC LIMIT 1))
            AND (SELECT MAX(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"out\"".'ORDER BY id LIMIT 1) <= (SELECT monday_out FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id )
            THEN SUBTIME((SELECT monday_out FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id ), (SELECT MAX(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"out\"".'ORDER BY id LIMIT 1))
        
        WHEN DAYNAME((SELECT created FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"in\"".'ORDER BY id LIMIT 1)) = "Tuesday" AND !ISNULL((SELECT MAX(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"out\"".'ORDER BY id DESC LIMIT 1))
            AND (SELECT MAX(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"out\"".'ORDER BY id LIMIT 1) <=(SELECT tuesday_out FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id )
            THEN SUBTIME((SELECT sunday_out FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id ), (SELECT MAX(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"out\"".'ORDER BY id LIMIT 1))
        
        WHEN DAYNAME((SELECT created FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"in\"".'ORDER BY id LIMIT 1)) = "Wednesday" AND !ISNULL((SELECT MAX(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"out\"".'ORDER BY id DESC LIMIT 1))
            AND (SELECT MAX(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"out\"".'ORDER BY id LIMIT 1) <= (SELECT wednesday_out FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id )
            THEN SUBTIME((SELECT sunday_out FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id ), (SELECT MAX(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"out\"".'ORDER BY id LIMIT 1))
        
        WHEN DAYNAME((SELECT created FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"in\"".'ORDER BY id LIMIT 1)) = "Thursday" AND !ISNULL((SELECT MAX(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"out\"".'ORDER BY id DESC LIMIT 1))
            AND (SELECT MAX(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"out\"".'ORDER BY id LIMIT 1) <= (SELECT thursday_out FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id )
            THEN SUBTIME((SELECT sunday_out FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id ), (SELECT MAX(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"out\"".'ORDER BY id LIMIT 1))
        
        WHEN DAYNAME((SELECT created FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"in\"".'ORDER BY id LIMIT 1)) = "Friday" AND !ISNULL((SELECT MAX(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"out\"".'ORDER BY id DESC LIMIT 1))
            AND (SELECT MAX(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"out\"".'ORDER BY id LIMIT 1) <= (SELECT friday_out FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id )
            THEN SUBTIME((SELECT sunday_out FROM '.db_prefix().'hr_office_shift WHERE '.db_prefix().'hr_extra_info.office_sheft = '.db_prefix().'hr_office_shift.id ), (SELECT MAX(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"out\"".'ORDER BY id LIMIT 1))
        
        ELSE 
            "-"
    END as early_leaving',


    //'time_out',
    

    'attendance.created as created',

    'CASE 
    WHEN ((SELECT COUNT(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"out\"".'ORDER BY id DESC LIMIT 1)) < 2
    THEN "-" 

    ELSE

    (SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(SUBTIME((SELECT time FROM '.db_prefix().'hr_attendances AS attendances WHERE '.'attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '."attendances.time>".db_prefix().'hr_attendances.time'.' AND '."attendances.type=\"in\"".' AND '.'attendances.time!=(SELECT MIN(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendances.created".' AND '.db_prefix()."hr_attendances.type=\"in\"".')'.'ORDER BY time ASC LIMIT 1), time))))



     FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.type=\"out\"".' AND '.db_prefix().'hr_attendances.time!=(SELECT MAX(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.type=\"out\"".')'.'ORDER BY time ASC)

    END as total_rest',

    'CASE 
    WHEN ISNULL((SELECT MAX(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"out\"".'ORDER BY id DESC LIMIT 1))
    THEN "-" 
    ELSE (SELECT MAX(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"out\"".'ORDER BY id DESC LIMIT 1)
    END as time_out',

    'CASE 
    WHEN ISNULL((SELECT MAX(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"out\"".'ORDER BY id))
    THEN "-" 
    ELSE SUBTIME((SELECT MAX(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"out\"".'ORDER BY id DESC LIMIT 1), (SELECT MIN(time) FROM '.db_prefix().'hr_attendances WHERE '.db_prefix().'hr_attendances.staff_id = '.db_prefix().'hr_extra_info.staff_id AND '.db_prefix()."hr_attendances.created=attendance.created".' AND '.db_prefix()."hr_attendances.type=\"in\"".'ORDER BY id DESC LIMIT 1))
    END as total_work'
];

if(get_staff_default_language() == 'arabic'){
    $aColumns[] = db_prefix().'branches.title_ar as branch_id';
}else{
    $aColumns[] = db_prefix().'branches.title_en as branch_id';
}

$sIndexColumn = 'id';
$sTable       = db_prefix().'hr_extra_info';

$join = [
    'INNER JOIN '.db_prefix().'staff ON '.db_prefix().'staff.staffid='.db_prefix().'hr_extra_info.staff_id',
    'LEFT JOIN '.db_prefix().'hr_attendances as attendance ON attendance.staff_id='.db_prefix().'hr_extra_info.staff_id AND (attendance.created BETWEEN "'.$start_date.'" AND "'.$end_date.'")',


    'LEFT JOIN '.db_prefix().'branches_services ON '.db_prefix().'branches_services.rel_id='.db_prefix().'staff.staffid AND '.db_prefix().'branches_services.rel_type="staff"',
    'LEFT JOIN '.db_prefix().'branches ON '.db_prefix().'branches.id='.db_prefix().'branches_services.branch_id',

    'LEFT JOIN '.db_prefix().'hr_office_shift ON '.db_prefix().'hr_office_shift.id='.db_prefix().'hr_extra_info.office_sheft',
];

//echo $date; exit;
$where = ['AND '.db_prefix().'staff.staffid='."'".$staff_id."'"];


$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [db_prefix().'hr_extra_info.id']);
$output  = $result['output'];
$rResult = $result['rResult'];
//var_dump($date); exit;
$date = [];

foreach ($rResult as $aRow) {
    $row = [];

    if(in_array($aRow['created'], $date))
        continue;
    
    $row[] = $aRow['fullname'];

    $row[] = $aRow['employee_id'];

    $row[] = $aRow['branch_id'];

    $row[] = $aRow['created'];

    $row[] = $aRow['status'];

    $row[] = $aRow['time_in'];

    $row[] = $aRow['time_out'];

    $row[] = $aRow['late'];

    $row[] = $aRow['early_leaving'];

    $row[] = $aRow['over_time'];

    $row[] = $aRow['total_work'];

    $row[] = $aRow['total_rest'];

    $date[] = $aRow['created'];

    $output['aaData'][] = $row;
}
