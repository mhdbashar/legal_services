<?php
$m = $this->input->get('month');
$y = $this->input->get('year');

if (empty($m) and empty($m)) {
    $m = date('m'); $y = date('y');
}

$user_period = $this->Details_model->getnewstaff($user_id)['period'];
$periods = $this->Workday->get_period();
if ($user_period == 'e')
	$period = $periods['evening'];
else
	$period = $periods['morning'];

$start = substr($period, 0, strpos($period, '-'));
$end = str_replace($start.'-', '', $period);

$sh = substr($start, 0, strpos($start, ':'));
$sm = str_replace($sh.':', '', $start);

$eh = substr($end, 0, strpos($end, ':'));
$em = str_replace($eh.':', '', $end);


$stotal = (float)($sh + $sm/60);
$etotal = (float)($eh + $em/60);
$total = $etotal - $stotal;
$total_job = (int)(floor($total)) . ":" . ($total - floor($total)) * 60;

$holidays = $this->Details_model->get_month_holiday($m);
$holi = [];
foreach($holidays as $holiday){

	$start_date = new DateTime($holiday['start_date']);
	$end_date = new DateTime($holiday['end_date']);
	$format_start = (int)$start_date->format('d');
	$format_end = (int)$end_date->format('d');
	for($i = $format_start; $i < $format_end; $i++){
		$holi[$i] = (int)$i . "\n";
	}
}

$time = str_replace('-', '', date('Y-m-d', strtotime($y.'-'.$m.'-01')));
$datetime = DateTime::createFromFormat('Ymd', $time);
$day_name = $datetime->format('D');

$vactions = $this->Details_model->get_month_vaction($m, $user_id);
$vac = [];
foreach($vactions as $vaction){

	$start_date = new DateTime($vaction['start_date']);
	$end_date = new DateTime($vaction['end_date']);
	$format_start = (int)$start_date->format('d');
	$format_end = (int)$end_date->format('d');
	for($i = $format_start; $i < $format_end; $i++){
		$vac[$i] = (int)$i . "\n";
	}
}

$work_days = $this->Details_model->getdays();

$total_month_hour = 0;
$total_month_min = 0;


function numDays($date, $year){
	switch ($date) {
		case 1:
			return 31;
			break;
		case 2:
			if($year % 4 == 0) return 29; else return 28;
			break;
		case 3:
			return 31;
			break;
		case 4:
			return 30;
			break;
		case 5:
			return 31;
			break;
		case 6:
			return 30;
			break;
		case 7:
			return 31;
			break;
		case 8:
			return 31;
			break;
		case 9:
			return 30;
			break;
		case 10:
			return 31;
			break;
		case 11:
			return 30;
			break;
		case 12:
			return 31;
			break;
	}
}
function print_days($day_name){
	$days = [

  		'<th scope="col">Saturday</th>',
        '<th scope="col">Sunday</th>',
        '<th scope="col">Monday</th>',
        '<th scope="col">Tuesday</th>',
        '<th scope="col">Wednesday</th>',
        '<th scope="col">Thursday</th>',
        '<th scope="col">friday</th>',
        
  	];
	switch ($day_name) {
		case 'Sat':
			echo $days[0]. $days[1]. $days[2]. $days[3]. $days[4]. $days[5]. $days[6];
			break;
		case 'Sun':
			echo $days[1]. $days[2]. $days[3]. $days[4]. $days[5]. $days[6] . $days[0];
			break;
		case 'Mon':
			echo $days[2]. $days[3]. $days[4]. $days[5]. $days[6] . $days[0]. $days[1];
			break;
		case 'Tue':
			echo $days[3]. $days[4]. $days[5]. $days[6] . $days[0]. $days[1]. $days[2];
			break;
		case 'Wed':
			echo $days[4]. $days[5]. $days[6] . $days[0]. $days[1]. $days[2]. $days[3];
			break;
		case 'Thu':
			echo $days[5]. $days[6] . $days[0]. $days[1]. $days[2]. $days[3]. $days[4];
			break;
		case 'Fri':
			echo $days[6] . $days[0]. $days[1]. $days[2]. $days[3]. $days[4]. $days[5];
			break;
	}
}
function is_holiday($y, $m, $day, $work_days){
	$datetime = DateTime::createFromFormat('Ymd', $y.$m.$day);
	$day_name = $datetime->format('D');
	switch ($day_name) {
		case 'Sat':
		if($work_days['saturday'] == 0) return true;
			return false;
			break;
		case 'Sun':
		if($work_days['sunday'] == 0) return true;
			return false;
			break;
		case 'Mon':
		if($work_days['monday'] == 0) return true;
			return false;
			break;
		case 'Tue':
		if($work_days['tuesday'] == 0) return true;
			return false;
			break;
		case 'Wed':
		if($work_days['wednesday'] == 0) return true;
			return false;
			break;
		case 'Thu':
		if($work_days['thursday'] == 0) return true;
			return false;
			break;
		case 'Fri':
		if($work_days['friday'] == 0) return true;
			return false;
			break;
		default:
			return false;
}
}
?>
<div class="col-md-9">
	<div class="panel_s">
        <div class="panel-body">
        	<h4 class="no-margin">
		        <?php echo "Timecard Details"; ?>
			</h4>
			<hr>
        	<form action="<?php echo base_url() . 'hrm/employees/member/'.$user_id ?>">
        		<input class="hidden hide" value="timecard" name="group">
        		<select class="btn" name="month">
                <?php for($i = 1; $i <= 12; $i++){ ?>
                	<?php $select = ($i == $m) ? 'selected' : '' ; ?>
                    <?php  $date = ($i < 10) ? "0".$i : $i ; ?>
                    
                    <option <?php echo $select ?> value="<?php echo($date) ?>"><?php echo($date) ?></option>
                <?php } ?>
                </select>

                <select class="btn" name="year">
                <?php for($i = date('y'); $i >= date('y')-12; $i--){ ?>
                	<?php $date = ($i < 10) ? "0".$i : $i ; ?>
                	<?php $select = ("20".$date == $y) ? 'selected' : '' ; ?>
                    <option <?php echo $select ?> value="<?php echo("20".$date) ?>"><?php echo("20".$date) ?></option>
                <?php } ?>
                </select>
                <input type="submit" class="btn btn-primary" value="GO">
        	</form>
        	<div class="table-responsive">
        	<table class="table">
		      <thead>

		        <tr>
		          <?php print_days($day_name); ?>
		          <th scope="col">Total</th>
		        </tr>

		      </thead>
		      <tbody>
		      	<?php $weeks = (numDays($m, $y)/7 > 4) ? 5 : 4 ; ?>
		      	<?php $lang = array_fill(1, $weeks, 'value') ?>
		<?php $day = 1; foreach($lang as $key => $value): ?>
		        <tr>
		          <?php $break = 0; for($i = 0; $i < 7; $i++){ ?>
		          	<?php if($day > numDays($m, $y)) break; ?>
		          	<?php 
		          	$area = '';
		          	if(isset($holi[$day]) or isset($vac[$day]) or is_holiday($y,$m,$day, $work_days)) {
		          		$break++;
		          		if(isset($holi[$day]))
		          			$area .="<b class='text-success'>Holiday</b>";
		          		if(isset($vac[$day]))
		          			$area .="<br><b class='text-danger'>Vaction</b>";
		          		if(is_holiday($y,$m,$day, $work_days))
		          			$area = "<b class='text-success'>Holiday</b>";
		          	} else{
		          		$area = "<b>Day : </b>" . $day . "<br><b>Period : </b><br>" . $period . "<br><b>Hours : </b>" . $total_job;
		          	}  

		          	?>
		          	<td><?php echo $area;  $day++; ?></td>
		          	
		          <?php } ?>
		          <?php $min = ($total - floor($total)) * 60; 
		          		$total_week_min = $min * ($i - $break);
		          		$total_week_hour = ($i - $break) * floor($total);
		          		for ($j = $i; $j < 7; $j++) echo "<td style='background-color: #e0e6ec'></td>";
		          ?>
		          <?php
		          while ($total_week_min >= 60) {
		           	$total_week_hour++; $total_week_min-= 60;
		           } 
		          ?>
		          <td class="text-primary"><?php echo (abs($total_week_hour) . ":" . (int)(abs($total_week_min))); $total_month_hour += $total_week_hour; $total_month_min += $total_week_min ?></td>
		        </tr>
		<?php endforeach; ?>        
		      </tbody>
		    </table>
		      <?php
		          while ($total_month_min >= 60) {
		           	$total_month_hour++; $total_month_min-= 60;
		           } 
	          ?>
	          <hr>
		    <h3>Total in month : <span class="text-primary"><?php echo abs($total_month_hour) . ":" . (int)abs($total_month_min) ?></span> </h3>	
        	</div>
        	
           

           
        </div>
     </div>
</div>