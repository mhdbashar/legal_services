<?php init_head() ?>
<style type="text/css">
	body {
	font-family: Tahoma;
}



/* declare a 7 column grid on the table */
.calendar {
	width: 100%;
  display: grid;
  grid-template-columns: repeat(7, 1fr);
}

.calendar tr, .calendar tbody {
  grid-column: 1 / -1;
  display: grid;
  grid-template-columns: repeat(7, 1fr);
 width: 100%;
}

caption {
	text-align: center;
  grid-column: 1 / -1;
  font-size: 130%;
  font-weight: bold;
  padding: 10px 0;
}

.calendar a {
	color: #8e352e;
	text-decoration: none;
}

.calendar td, .calendar th {
	padding: 5px;
	box-sizing:border-box;
	border: 1px solid #ccc;
}

.calendar .weekdays {
	background: #8e352e;  
}


.calendar .weekdays th {
	text-align: center;
	text-transform: uppercase;
	line-height: 20px;
	border: none !important;
	padding: 10px 6px;
	color: #fff;
	font-size: 13px;
}

.calendar td {
	min-height: 100px;
  display: flex;
  flex-direction: column;
}

.calendar .days li:hover {
	background: #d3d3d3;
}

.calendar .colspan{
	text-align: center;
    grid-column: 1 / -1;
    font-size: 130%;
    font-weight: bold;
    padding: 10px 0;
    border: 0px;
}

.calendar .date {
	text-align: center;
	margin-bottom: 5px;
	padding: 2px;
	color: #3c8dbc;
	font-size: 25px;
    font-weight: 300;
  flex: 0 0 auto;
  align-self: flex-end;
}
.calendar .date-day {
	text-align: center;
	margin-bottom: 5px;
	padding: 2px;
	color: #c5be22;
	font-size: 25px;
    font-weight: 300;
  flex: 0 0 auto;
  align-self: flex-end;
}

.calendar .event {
  flex: 0 0 auto;
	font-size: 13px;
	border-radius: 4px;
	padding: 5px;
	margin-bottom: 5px;
	line-height: 14px;
	background: #e4f2f2;
	border: 1px solid #b5dbdc;
	color: #009aaf;
	text-decoration: none;
}

.calendar .event-desc {
	color: #666;
	margin: 3px 0 7px 0;
	text-decoration: none;	
}

.calendar .other-month {
	background: #f5f5f5;
	color: #666;
}

/* ============================
				Mobile Responsiveness
   ============================*/


@media(max-width: 768px) {

	.calendar .weekdays, .calendar .other-month {
		display: none;
	}

	.calendar li {
		height: auto !important;
		border: 1px solid #ededed;
		width: 100%;
		padding: 10px;
		margin-bottom: -1px;
	}
  
  .calendar, .calendar tr, .calendar tbody {
    grid-template-columns: 1fr;
  }
  
  .calendar  tr {
    grid-column: 1 / 2;
  }

	.calendar .date {
		align-self: flex-start;
	}
}
</style>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                	<div class="panel-body">
                	<div class="_buttons">
                        <a href="#" class="btn btn-info pull-left" data-toggle="modal" data-target="#attendance_date"><?php echo _l('calendar_date'); ?></a>
                    </div>
                		<?php
						$prefs['template'] = '

				           {table_open}<table class="calendar">{/table_open}

							{heading_row_start}<tr>{/heading_row_start}

						   {heading_title_cell}<th class="colspan" colspan="{colspan}">{heading}</th>{/heading_title_cell}

						   {heading_row_end}</tr>{/heading_row_end}


				           {week_row_start}<tr class="weekdays">{/week_row_start}
				           {week_day_cell}<th  scope="col">{week_day}</th>{/week_day_cell}
				           {week_row_end}</tr>{/week_row_end}

							{cal_row_start}<tr>{/cal_row_start}
						   {cal_cell_start}<td>{/cal_cell_start}

						   {cal_cell_content}<span class="date">{day}</span> {content}{/cal_cell_content}
						   {cal_cell_content_today}<span class="date-day">{day}</span> {content}{/cal_cell_content_today}

						   {cal_cell_no_content}<span class="date">{day}</span>{/cal_cell_no_content}
						   {cal_cell_no_content_today}<span class=" date-day">{day}</span>{/cal_cell_no_content_today}

						   {cal_cell_blank}&nbsp;{/cal_cell_blank}

						   {cal_cell_end}</td>{/cal_cell_end}
						   {cal_row_end}</tr>{/cal_row_end}

				           {table_close}</table>{/table_close}
				        ';
				        $prefs['day_type'] = 'long';

				        $this->load->library('calendar', $prefs);
                		?>
						<?php echo $this->calendar->generate($year, $month, $office_shift_days); ?>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $this->load->view('timesheet/attendance/modals/calendar_modal'); ?>
<?php init_tail() ?>