<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="_buttons">
                            <?php if (has_permission('hr', '', 'create')){ ?> <a href="#" class="btn btn-info pull-left" onclick="add()" data-toggle="modal" data-target="#add_designation"><?php echo _l('new_designation'); ?></a><?php } ?>
                        </div>
                        <div class="clearfix"></div>
                        <hr class="hr-panel-heading" />
                        <div class="clearfix"></div>
                        <?php
                        $data = array(
                            _l('designation'),
                        );
                        if (has_permission('hr', '', 'edit') || has_permission('hr', '', 'delete') )
                            $data[] = _l('control');
                        render_datatable($data,'designation'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('organization/modals/designation_modal'); ?>
<?php init_tail(); ?>
<script>
    $(function(){
        initDataTable('.table-designation', window.location.href);
    });



    $(function () {

        $('#add-submit').on('click', function (e) {
            var number = $(".add_number #number").val();
            e.preventDefault();

            $.ajax({
                url: '<?php
                    $id = '';
                    echo admin_url('hr/organization/validate_designation_number/').$id; ?>',
                type: 'POST',
                dataType: 'json',
                data: {number: number},
                error: function () {
                    console.log('error')
                },
                success: function (data) {
                    if (data.status == true) {
                        //alert(data.status);
                        $(window).off('beforeunload');
                        $("#form_add").unbind('submit').submit();


                    } else if (data.status == false) {

                        // alert(data.status);
                        $("input[name='number']").css('border', '2px solid red');
                    }
                }
            });
        });
        $('#edit-submit').on('click', function (e) {
            var number = $(".edit_number #number").val();
            e.preventDefault();
            var id = $('[name="id"]').val();
            $.ajax({
                url: '<?php
                    $id = '';
                    echo admin_url('hr/organization/validate_designation_number/'); ?>' + id,
                type: 'POST',
                dataType: 'json',
                data: {number: number},
                error: function () {
                    console.log('error')
                },
                success: function (data) {
                    if (data.status == true) {
                        //alert(data.status);
                        $(window).off('beforeunload');
                        $("#form_edit").unbind('submit').submit();


                    } else if (data.status == false) {

                        // alert(data.status);
                        $("input[name='number']").css('border', '2px solid red');
                    }
                }
            });
        });
    })
</script>
</body>
</html>
