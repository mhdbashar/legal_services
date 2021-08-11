<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head();  ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="_buttons">
                            <div class="_buttons">
                                <a href="#" data-toggle="modal" data-target="#add-cat" class="btn btn-info pull-left display-block">
                                    <?php echo _l('AddMasterCategory'); ?>
                                </a>
                                <div class="clearfix"></div>
                                <hr class="hr-panel-heading" />
                                <h4 class="text-center">  <?php echo _l('BasicCategories'); ?></h4>
                            </div>
                            <table class="table dt-table scroll-responsive">
                                <thead>
                                <th>#</th>
                                <th><?php echo _l('name'); ?></th>
                                <th><?php echo _l('options'); ?></th>
                                </thead>
                                <tbody>
                                <?php $i=1; foreach($category as $cat){ ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td>
                                            <?php echo $cat->name; ?>
                                        </td>
                                        <td>
                                            <a href="<?php echo admin_url("edit_category/$ServID/$cat->id"); ?>" class="btn btn-default btn-icon"><i class="fa fa-pencil-square-o"></i></a>
                                            <a href="<?php echo admin_url("delete_category/$ServID/$cat->id"); ?>" class="btn btn-danger btn-icon _delete"><i class="fa fa-remove"></i></a>
                                            <div class="radio radio-primary radio-inline">
                                                <input type="radio" name="CatDetails"  id="<?php echo $cat->id; ?>" onchange="MakePrimary(<?php echo $ServID.','.$cat->id?>)">
                                                <label for="<?php echo $cat->id; ?>"><?php echo _l('Categories'); ?> <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></label>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php $i++; } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="_buttons">
                            <div class="_buttons">
                                <button id="BtnAddChild" data-toggle="modal" data-target="#add-child-cat" class="btn btn-info pull-left" disabled><?php echo _l('AddSubCategory'); ?></button>
                                <div class="clearfix"></div>
                                <hr class="hr-panel-heading" />
                                <h4 class="text-center">  <?php echo _l('SubCategories'); ?></h4>
                            </div>
                            <table id="SubCatChild" class="table dt-table scroll-responsive">
                                <thead>
                                <th>#</th>
                                <th><?php echo _l('name'); ?></th>
                                <th><?php echo _l('options'); ?></th>
                                </thead>
                                <tbody id="BodyTable">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="add-cat" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="add-title"><?php echo _l('AddMasterCategory'); ?></span>
                </h4>
            </div>
            <?php echo form_open(admin_url("AddCategory/$ServID"),array('id'=>'category-form')); ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php echo render_input('name','name'); ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button group="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
                <button group="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="add-child-cat" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="add-title"><?php echo _l('AddSubCategory'); ?></span>
                </h4>
            </div>
            <form id="ChildCatForm" method="post">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <input type="hidden" name="csrf_token_name" value="<?php echo $this->security->get_csrf_hash();?>">
                        <?php echo render_input('name','name'); ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button group="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
                <button group="submit" type="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
            </form>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
<script>
    $(function(){
        _validate_form($('#category-form'),{name:'required'});
        _validate_form($('#ChildCatForm'),{name:'required'});
    });
    function MakePrimary(ServID,CatID) {
        var table = $('#SubCatChild').dataTable();
        table.fnDestroy();
        $('#BodyTable').empty();
        UrlChild ='';
        $.ajax({
           url: '<?php echo admin_url('ChildCategory'); ?>/' + ServID +'/'+ CatID,
            success: function (data) {
                response = JSON.parse(data);
                UrlChild = '<?php echo admin_url('AddChildCat/').$ServID; ?>/'+ CatID;
                $("#ChildCatForm").attr("action", UrlChild);
                $("#BtnAddChild").removeAttr('disabled');
                    count = 1;
                    $.each(response, function (key,val) {
                        $("#SubCatChild").append(
                            '<tr>' +
                            '<td>' + count + '</td>' +
                            '<td>' + val.name + '</td>' +
                            '<td>' +
                            '<a href="<?php echo admin_url('edit_category/').$ServID; ?>/'+ val.id +'" class="btn btn-default btn-icon"><i class="fa fa-pencil-square-o"></i></a>' +
                            '<a href="<?php echo admin_url('delete_category/').$ServID; ?>/'+ val.id +'" class="btn btn-danger btn-icon _delete"><i class="fa fa-remove"></i></a>' +
                            '</td>' +
                            '</tr>'
                        );
                        count++;
                    });
            }
        });
    }
</script>
</body>
</html>