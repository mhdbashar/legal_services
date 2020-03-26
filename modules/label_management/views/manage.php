<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php init_head(); ?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<div id="wrapper">
    <div class="content">
    	<?php $this->load->view('modals/lang') ?>
    	<div class="panel_s">
            <div class="panel-body">

            	<a class="btn btn-info" href="<?php echo base_url() . "label_management/language/table/english"?>">English</a>
                <a class="btn btn-info" href="<?php echo base_url() . "label_management/language/table/arabic"?>">Arabic</a>

                <h2 class="m-5"><?php echo ucfirst($language) ?></h2>
                <div class="row">
                  <div class="col-md-4">
                    <a href="#" class="btn btn-info pull-left" data-toggle="modal" data-target="#exampleModal"><?php echo 'Add New Lable'; ?></a>
                  </div>
                  <div class="col-md-4">
                    <a class="btn <?php if ($custom == "custom_lang") echo "btn-default" ?>" href="<?php echo base_url() . "label_management/language/table/".$language."/custom_lang"?>">Custom</a>
                    <a class="btn <?php if ($custom == $language."_lang") echo "btn-default" ?>" href="<?php echo base_url() . "label_management/language/table/".$language."/".$language."_lang"?>">Native</a>
                  </div>
              </div>
				

				<div class="clearfix"></div>
				<hr class="hr-panel-heading" />
				<div class="clearfix"></div>
       			<table id="options" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Lable</th>
                <th>Translate</th>
                <th>Control</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Lable</th>
                <th>Translate</th>
                <th>Control</th>
            </tr>
        </tfoot>
    </table>
        	</div>
    	</div>
    </div>
</div>
<?php init_tail() ?>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>

<script>
	$(document).ready(function() {
      
      var table = $('#options').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "<?php echo base_url() . "label_management/language/lang/".$language."/".$custom ?>",
        responsive: true,
        language: {
        search: "_INPUT_",
        searchPlaceholder: "Search",
        "columns": [
		{"name": "Lable", "orderable": "false"},
		{"name": "Translate", "orderable": "true"},
		{"name": "Control", "orderable": "true"},
		],
        "order": [[1, 'asc']],
		deferRender: true,
		scrollY: 800,
		scrollCollapse: true
        }
      });
    });
</script>

<script type="text/javascript">
$('#EditModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var key = button.data('key') // Extract info from data-* attributes
  var value = button.data('value');
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this)
  modal.find('.modal-body input').val(key);
  modal.find('.modal-body textarea').val(value);
})
</script>
