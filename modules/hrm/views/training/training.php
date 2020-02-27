<?php init_head() ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">



                     <a type="button" class="btn btn-primary" data-readonly="" href="<?php echo site_url('hrm/training/add') ?>">
                        Add New Training
                    </a>
                    <div class="clearfix"></div>
                    <hr class="hr-panel-heading" />
                    <div class="clearfix"></div>
                    <?php
                    $_table_data = array(
                         array(
                         'name'=>'Staff',
                         'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-staff_id')
                        ),
                         array(
                         'name'=>'Course / Training',
                         'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-training')
                        ),
                         array(
                         'name'=>'Vendor',
                         'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-vendor')
                        ),
                         array(
                         'name'=>'Start Date',
                         'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-start_date')
                        ),
                         array(
                         'name'=>'End Date',
                         'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-end_date')
                        ),
                         array(
                         'name'=>'Cost',
                         'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-cost')
                        ),
                         array(
                         'name'=>'Status',
                         'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-status')
                        ),
                         array(
                         'name'=>'Controll',
                         'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-id')
                        )
                      );
                     render_datatable($_table_data, 'training'); ?>

                     <?php
                     $data['staff'] = $this->Train->getStaff();
                     ?>

                    <?php /* $this->load->view('modals/training', $data) */ ?>
</div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php init_tail() ?>

<script type="text/javascript">
    $(function(){
        initDataTable('.table-training', window.location.href, [1], [1]);

        
        $('#addtraining').on('click',function(){
        	$('#exampleModalLabel').html('Add New Training');
        	$('[name="id"]').val('');
            $('[name="staff_id"]').val('');
            $('[name="training"]').val('');
            $('[name="vendor"]').val('');
            $('[name="start_date"]').val('');
            $('[name="end_date"]').val('');
            $('[name="cost"]').val('');
            $('[name="status"]').val('');
            $('[name="performance"]').val('');
            $('[name="remarks"]').val('');
            $('#id').val('');
        });
   });



    function edit_training_json(id){

        save_method = 'update';
        $('#form_transout')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string


        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('hrm/training/get') ?>/" + id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {

                console.log(data);
                $('[name="id"]').val(data.id);
                $('[name="staff_id"]').val(data.staff_id);
                $('[name="training"]').val(data.training);
                $('[name="vendor"]').val(data.vendor);
                $('[name="start_date"]').val(data.start_date);
                $('[name="end_date"]').val(data.end_date);
                $('[name="cost"]').val(data.cost);
                $('[name="status"]').val(data.status);
                //$('button[data-id="status"] .filter-option-inner-inner').html(data.status);
                $('[name="performance"]').val(data.performance);
                $('[name="remarks"]').val(data.remarks);
                
                
                // $('[name="dob"]').datepicker('update',data.dob);
                $('#exampleModalLabel').html('Edit Training');
                $('#id').val(id);
                $('#add_training').modal('show'); // show bootstrap modal when complete loaded

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }

</script>