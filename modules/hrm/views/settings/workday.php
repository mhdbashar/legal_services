<?php init_head() ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <nav class="navbar navbar-light bg-light">
                          <form class="form-inline">
                            <a href="<?php echo base_url() ?>hrm/workdays" class="btn btn-outline-success" type="button">Work Days</a>
                            <a href="<?php echo base_url() ?>hrm/holidays" class="btn btn-outline-secondary" type="button">Holidays</a>
                            <a href="<?php echo base_url() ?>hrm/vac" class="btn btn-outline-secondary" type="button">Vaction</a>
                          </form>
                        </nav>


					<form class="form-check" action="<?php echo base_url() . 'hrm/Workdays/edit' ?>">
<?php foreach($data as $key => $value): ?>

	<?php if ($value == 1)$checked = 'checked'; else $checked = null; ?>
						<input <?php echo $checked; ?> style="margin-left: 30px;" class="form-check-input large" value="1" type="checkbox" name="<?php echo $key ?>" id="defaultCheck1">  
						<label class="form-check-label" for="defaultCheck1">
					    	<?php echo $key ?>
						</label>

<?php endforeach; ?>
						<br>
						<input style="margin-left: 30px;" class="input" type="submit" name="">
						
					</form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php init_tail() ?>
