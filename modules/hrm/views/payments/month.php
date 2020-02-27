<?php init_head() ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body" style="text-align: center;">
                    	<form action="<?php echo base_url() ?>hrm/makepayment/month">
                    		<select class="btn" name="month">
                              <option selected><?php echo date('m') ?></option>
                            <?php for($i = 1; $i <= 12; $i++){ ?>
                                <?php $date = ($i < 10) ? "0".$i : $i ; ?>
                                <option value="<?php echo($date) ?>"><?php echo($date) ?></option>
                            <?php } ?>
                            </select>

                            <select class="btn" name="year">
                              <option selected><?php echo("20".date('y')) ?></option>
                            <?php for($i = date('y'); $i <= date('y')+12; $i++){ ?>
                                <option value="<?php echo("20".$i) ?>"><?php echo("20".$i) ?></option>
                            <?php } ?>
                            </select>
                            <input type="submit" class="btn btn-primary" value="GO">
                    	</form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php init_tail() ?>