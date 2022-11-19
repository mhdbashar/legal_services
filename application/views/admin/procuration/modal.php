
<div class="modal fade" id="file" tabindex="-1" role="dialog" aria-labelledby="file" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="add-title"><?php echo _l("view"); ?></span>
                </h4>
            </div>
            <div class="modal-body">
                <div class="col-md-12 border-right project_file_area" id="show_file">
                </div>
            </div>
            <div class="modal-footer">
                <button group="button" class="btn btn-default" data-dismiss="modal"><?php echo _l("close"); ?></button>
            </div>
        </div>
    </div>
</div>

<script>
    function get_url_extension( url ) {
        return url.split(/[#?]/)[0].split('.').pop().trim();
    }
    function edit(id){

        save_method = 'update';
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo admin_url('procuration/file') ?>/" + id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {

                let ext = get_url_extension(data);
                if(ext === 'png' || ext === 'jpg' || ext === 'jpeg' || ext === 'gif'){
                    $('#show_file').html(`<img src="${data}" class="img img-responsive" />`)
                }
                else if (ext === 'docs' || ext === 'doc' || ext === 'docx'){
                    $('#show_file').html(`<iframe src="https://docs.google.com/viewer?url=${data}&embedded=true" height="100%" width="100%" frameborder="0"></iframe>`)
                }
                else if (ext === 'pdf'){
                    $('#show_file').html(`<iframe src="${data}" height="100%" width="100%" frameborder="0"></iframe>`)
                }
                else {
                    $('#show_file').html(`cannot view file`)
                }

                $('#file').modal('show'); // show bootstrap modal when complete loaded

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }


</script>