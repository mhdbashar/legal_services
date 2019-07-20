<?php init_head() ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">



                     <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_award" data-title="New Holiday" data-readonly="">
                        Add New Award
                    </button>
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
                         'name'=>'Award',
                         'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-desc')
                        ),
                         array(
                         'name'=>'Reason',
                         'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-reson')
                        ),
                         array(
                         'name'=>'Date',
                         'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-date')
                        ),
                         array(
                         'name'=>'Controll',
                         'th_attrs'=>array('class'=>'toggleable', 'id'=>'th-id')
                        ),
                      );
                     render_datatable($_table_data, 'holiday'); ?>

                     <?php
                     $data['staff'] = $this->awards->getStaff();
                     ?>

                    <?php $this->load->view('modals/award', $data) ?>
</div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php init_tail() ?>

<script type="text/javascript">
    $(function(){
        initDataTable('.table-holiday', window.location.href, [1], [1]);
   });

    function edit_award_json(id){

        save_method = 'update';
        $('#form_transout')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string


        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('hrm/award/get') ?>/" + id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {

                console.log(data);
                $('[name="id"]').val(data.id);
                $('[name="award"]').val(data.award);
                $('[name="reason"]').val(data.reason);
                $('[name="date"]').val(data.date);
                
                
                // $('[name="dob"]').datepicker('update',data.dob);
                $('#edit_vac').modal('show'); // show bootstrap modal when complete loaded

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }

</script>