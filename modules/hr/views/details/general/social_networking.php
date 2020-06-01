<?php echo form_open(admin_url('hr/general/update_social_networking'),array('id'=>'form_transout')); ?>
<?php echo form_hidden('staff_id', $staff_id); ?>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
	        <label for="facebook" class="control-label"><i class="fa fa-facebook"></i> <?php echo _l('facebook') ?></label>
	        <input type="text" class="form-control" name="facebook" value="<?php echo $staff->facebook ?>" aria-invalid="false">
	    </div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
	        <label for="twitter" class="control-label"><i class="fa fa-twitter"></i> <?php echo _l('twitter') ?></label>
	        <input type="text" class="form-control" name="twitter" value="<?php echo $other_social->twitter ?>" aria-invalid="false">
	    </div>
	</div>
	<div class="col-md-12">
		<div class="form-group">
	        <label for="blogger" class="control-label"><i class="fa fa-blog"></i> <?php echo _l('blogger') ?></label>
	        <input type="text" class="form-control" name="blogger" value="<?php echo $other_social->blogger ?>" aria-invalid="false">
	    </div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
	        <label for="linkedin" class="control-label"><i class="fa fa-linkedin"></i> <?php echo _l('linkedin') ?></label>
	        <input type="text" class="form-control" name="linkedin" value="<?php echo $staff->linkedin ?>" aria-invalid="false">
	    </div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
	        <label for="google_plus" class="control-label"><i class="fa fa-google"></i> <?php echo _l('google_plus_profile') ?></label>
	        <input type="text" class="form-control" name="google_plus" value="<?php echo $other_social->google_plus ?>" aria-invalid="false">
	    </div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
	        <label for="instagram" class="control-label"><i class="fa fa-instagram"></i> <?php echo _l('instagram') ?></label>
	        <input type="text" class="form-control" name="instagram" value="<?php echo $other_social->instagram ?>" aria-invalid="false">
	    </div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
	        <label for="pinterest" class="control-label"><i class="fa fa-pinterest"></i> <?php echo _l('pinterest') ?></label>
	        <input type="text" class="form-control" name="pinterest" value="<?php echo $other_social->pinterest ?>" aria-invalid="false">
	    </div>
	</div>
	<div class="col-md-12">
		<div class="form-group">
	        <label for="youtube" class="control-label"><i class="fa fa-youtube"></i> <?php echo _l('youtube') ?></label>
	        <input type="text" class="form-control" name="youtube" value="<?php echo $other_social->youtube ?>" aria-invalid="false">
	    </div>
	</div>
	<div class="col-md-12">
		<div class="form-group">
	        <label for="skype" class="control-label"><i class="fa fa-skype"></i> <?php echo _l('skype') ?></label>
	        <input type="text" class="form-control" name="skype" value="<?php echo $staff->skype ?>" aria-invalid="false"> 
	    </div>
	</div>
</div>
<button group="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
<?php echo form_close(); ?>