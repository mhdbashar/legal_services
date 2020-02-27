<div class="col-md-9">
	<div class="panel_s">
        <div class="panel-body">
        	<h4 class="no-margin">
              <?php echo "Activites" ?>
           </h4>
           <div class="clearfix"></div>
	        <hr class="hr-panel-heading" />
	        <div class="clearfix"></div>
			<?php render_datatable(array(
	            'Bank Name',
	            'Account Name',
	            'Routing Number',
	            'Routing Number',
	        ),'activity'); 
	        ?>
		</div>
	</div>
</div>