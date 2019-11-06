<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
        	<div class="col-md-3">
			       	<ul class="nav navbar-pills navbar-pills-flat nav-tabs nav-stacked customer-tabs">
				       	<li class="customer_tab_contacts">
				       		<a data-group='deduction' href="?group=deduction"><?php echo _l('deduction') ?></a>
				       	</li>
			      	</ul>
            </div>
		   	<div class="col-md-9">
        		<div class="panel_s">
            		<div class="panel-body">
            			<?php $this->load->view('settings/tabs/'.$group) ?>
				   	</div>
				</div>
		   	</div>
            
        </div>
    </div>
</div>
<?php init_tail() ?>

<script>
   $(function(){
        initDataTable('.table-<?php echo $group ?>', window.location.href);
   });
</script>
<script type="text/javascript">
$("#update_deduction_type").on("show.bs.modal", function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var old = button.data("old"); // Extract info from data-* attributes
  var New = button.data("old");
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this)
  modal.find(".modal-body #old").val(old);

  modal.find(".modal-body #new").val(New);
})
</script>

</body>
</html>