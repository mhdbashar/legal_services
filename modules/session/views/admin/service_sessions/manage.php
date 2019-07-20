<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                     <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_session" data-title="New Holiday" data-readonly="">
                        Add New Session
                    </button>
                    <div class="clearfix"></div>
                    <hr class="hr-panel-heading" />
                    <div class="clearfix"></div>
                    <?php render_datatable(array(
                        'Subject',
                        'Date',
                        'Status',
                        'Result',
                        'Options',
                        ),'customer-groups'); ?>
                    <?php 

                        $data['rel_id'] = $rel_id;
                        $data['service_id'] = $service_id;
                        $data['judges'] = $this->Service_sessions_model->get_judges();
                        $data['courts'] = $this->Service_sessions_model->get_court();
                        $this->load->view('modals/session', $data)
                    ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
<script>
   $(function(){
        initDataTable('.table-customer-groups', window.location.href, [1], [1]);
   });
   function update_session_json(id){

        save_method = 'update';
        $('#form_transout')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string


        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('session/service_sessions/session_json') ?>/" + id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {

                console.log(data);
                $("#selection").children('option[class=' + data.court_id + ']').attr("selected", "selected");
                $('[name="subject"]').val(data.subject);
                $('[name="date"]').val(data.date);
                $('[name="id"]').val(data.id);
                
                
                // $('[name="dob"]').datepicker('update',data.dob);
                $('#edit_vac').modal('show'); // show bootstrap modal when complete loaded

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }

    /*
    function delete_session_json(id) {
      

            // ajax delete data to database
            if(confirm('Delete Session?'))
            {
                $.ajax({
                    url : "<?php echo site_url('session/service_sessions/delete_session_json') ?>/"+id,
                    type: "POST",
                    dataType: "JSON",
                    success: function(data)
                    {
                        location.reload();
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert('Error delte transin');
                    }
                });
            }

    }
    */


</script>
</body>
</html>
