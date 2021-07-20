
<div class="modal fade" id="show_msg" tabindex="-1" role="dialog" aria-labelledby="show_msg">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="add-title"><?php echo _l("message"); ?></span>
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <h3 id="msg"></h3>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal"><?php echo _l("close"); ?></button>
            </div>
        </div>
    </div>
</div>



<script>

    function show(msg, date, sender){
        $('[id="msg"]').html(msg);
        $('#show_msg').modal('show');
        $.ajax({
            url : "<?php echo site_url('receive_sms/save_sms/') ?>",
            type: "POST",
            dataType: "JSON",
            data: {msg, created_at: date, sender},
            success: function(data)
            {
                if(data.status == true)
                    $('#show_msg').modal('show'); // show bootstrap modal when complete loaded
                else
                    alert('Something went wrong!')

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }


</script>
