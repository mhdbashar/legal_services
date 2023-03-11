<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
    	<div class="row">
    		<div class="col-md-3">
       			<form action="<?php echo base_url() . 'hr/Holidays/index/'.$month ?>">
	        		<select id="themes" name="year" style="padding: 6px 70px; border-radius: 3px;" onchange="submitForm();">
	                <?php for($i = date('Y'); $i >=date('Y')-12; $i--){ ?>
	                	<?php $date = $i ; ?>
	                	<?php $select = ($date == $year) ? 'selected' : '' ; ?>
	                    <option <?php echo $select ?> value="<?php echo($date) ?>"><?php echo($date) ?></option>
	                <?php } ?>
	                </select>
	                <input type="submit" class="btn btn-primary" value="GO">
	        	</form>

       		</div>
    	</div>
        <div class="row">
            <div class="col-md-3">
		       	<ul class="nav navbar-pills navbar-pills-flat nav-tabs nav-stacked">
			       	<li class="<?php if($month == 1) echo 'active' ?>">
			       		<a href="<?php echo admin_url('hr/holidays/index/1'.'/'.$year) ?>">
			       			<i class="fa fa-fw fa-calendar"></i> January
			       		</a>
			       	</li>
			       	<li class="<?php if($month == 2) echo 'active' ?>">
			       		<a href="<?php echo admin_url('hr/holidays/index/2'.'/'.$year) ?>">
			       			<i class="fa fa-fw fa-calendar"></i> February
			       		</a>
			       	</li>
			       	<li class="<?php if($month == 3) echo 'active' ?>">
			       		<a href="<?php echo admin_url('hr/holidays/index/3'.'/'.$year) ?>">
			       			<i class="fa fa-fw fa-calendar"></i> March
			       		</a>
			       	</li>
			       	<li class="<?php if($month == 4) echo 'active' ?>">
			       		<a href="<?php echo admin_url('hr/holidays/index/4'.'/'.$year) ?>">
			       			<i class="fa fa-fw fa-calendar"></i> April
			       		</a>
			       	</li>
			       	<li class="<?php if($month == 5) echo 'active' ?>">
			       		<a href="<?php echo admin_url('hr/holidays/index/5'.'/'.$year) ?>">
			       			<i class="fa fa-fw fa-calendar"></i> May
			       		</a>
			       	</li>
			       	<li class="<?php if($month == 6) echo 'active' ?>">
			       		<a href="<?php echo admin_url('hr/holidays/index/6'.'/'.$year) ?>">
			       			<i class="fa fa-fw fa-calendar"></i> June
			       		</a>
			       	</li>
			       	<li class="<?php if($month == 7) echo 'active' ?>">
			       		<a href="<?php echo admin_url('hr/holidays/index/7'.'/'.$year) ?>">
			       			<i class="fa fa-fw fa-calendar"></i> July
			       		</a>
			       	</li>
			       	<li class="<?php if($month == 8) echo 'active' ?>">
			       		<a href="<?php echo admin_url('hr/holidays/index/8'.'/'.$year) ?>">
			       			<i class="fa fa-fw fa-calendar"></i> August
			       		</a>
			       	</li>
			       	<li class="<?php if($month == 9) echo 'active' ?>">
			       		<a href="<?php echo admin_url('hr/holidays/index/9'.'/'.$year) ?>">
			       			<i class="fa fa-fw fa-calendar"></i> September
			       		</a>
			       	</li>
			       	<li class="<?php if($month == 10) echo 'active' ?>">
			       		<a href="<?php echo admin_url('hr/holidays/index/10'.'/'.$year) ?>">
			       			<i class="fa fa-fw fa-calendar"></i> October
			       		</a>
			       	</li>
			       	<li class="<?php if($month == 11) echo 'active' ?>">
			       		<a href="<?php echo admin_url('hr/holidays/index/11'.'/'.$year) ?>">
			       			<i class="fa fa-fw fa-calendar"></i> November
			       		</a>
			       	</li>
			       	<li class="<?php if($month == 12) echo 'active' ?>">
			       		<a href="<?php echo admin_url('hr/holidays/index/12'.'/'.$year) ?>">
			       			<i class="fa fa-fw fa-calendar"></i> December
			       		</a>
			       	</li>
		      	</ul>
		     
		   </div>
            <div class="col-md-9">
                <div class="panel_s">
                    <div class="panel-body">
                     <div class="_buttons">
                        <a href="#" class="btn btn-info pull-left" data-toggle="modal" data-target="#add_holiday"><?php echo 'New Holiday'; ?></a>
                    </div>
                    <div class="clearfix"></div>
                    <hr class="hr-panel-heading" />
                    <div class="clearfix"></div>
                    <?php render_datatable(array(
                        'Event Name',
                        'Start Date',
                        'End Date',
                        'Color',
                        'Actions',
                        ),'countries'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('holiday/modals/holiday'); ?>
<?php init_tail(); ?>
<script>
   $(function(){
        initDataTable('.table-countries', window.location.href);
   });
</script>
</body>
</html>
