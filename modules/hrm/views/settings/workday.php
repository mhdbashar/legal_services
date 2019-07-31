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
<hr>
                        <form class="form-check form-inline" action="<?php echo base_url() . 'hrm/Workdays/edit/' ?>">
                                <div class="col-md-4">
                                    <label for="ammount" class="col-form-label">Morning</label>
                                    <input class="form-control" value="<?php echo $period['morning'] ?>" name="morning"></div>
                                <div class="col-md-4">
                                    <label for="ammount" class="col-form-label">Evening</label>
                                    <input class="form-control" value="<?php echo $period['evening'] ?>" name="evening"></div>
                            

                    <br><br><br>


<?php foreach($data as $key => $value): ?>

	<?php if ($value == 1)$checked = 'checked'; else $checked = null; ?>
						<div style="display: -webkit-inline-box">
                        <div class="checkbox checkbox-primary">
                        <input value="1" type="checkbox" name="<?php echo $key ?>" <?php echo $checked; ?> id="show_to_customer<?php echo $key; ?>">
                            <label for="show_to_customer<?php echo $key; ?>"><?php echo $key ?></label>
                        </div>
                        </div>
<?php endforeach; ?>
        <hr>
                    <div class="">
						<button class="btn btn-primary" style="margin-left: 10px" type="submit">Submit</button>
					</div>
					</form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php init_tail() ?>
