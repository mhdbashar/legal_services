<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <?php echo form_open($this->uri->uri_string(), array('id' => 'article-form')); ?>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel_s">
                    <div class="panel-body">
                        <h4 class="no-margin">
                            <?php echo $title; ?>
                            <?php if (isset($article)) { ?>
                                <br/>
                                <small>
                                    <?php if ($article->staff_article == 1) { ?>
                                        <a href="<?php echo admin_url('knowledge_base/view/' . $article->articleid); ?>"
                                           target="_blank"><?php echo admin_url('knowledge_base/view/' . $article->slug); ?></a>
                                    <?php } else { ?>
                                        <a href="<?php echo site_url('knowledge-base/article/' . $article->articleid); ?>"
                                           target="_blank"><?php echo site_url('knowledge-base/article/' . $article->slug); ?></a>
                                    <?php } ?>
                                </small>
                            <?php } ?>
                        </h4>
                        <?php if (isset($article)) { ?>
                            <p>
                                <small>
                                    <?php echo _l('article_total_views'); ?>
                                    : <?php echo total_rows(db_prefix() . 'views_tracking', array('rel_type' => 'kb_article', 'rel_id' => $article->articleid)); ?>
                                </small>
                                <?php if (has_permission('knowledge_base', '', 'create')) { ?>
                                    <a href="<?php echo admin_url('knowledge_base/article'); ?>"
                                       class="btn btn-success pull-right"><?php echo _l('kb_article_new_article'); ?></a>
                                <?php } ?>
                                <?php if (has_permission('knowledge_base', '', 'delete')) { ?>
                                    <a href="<?php echo admin_url('knowledge_base/delete_article/' . $article->articleid); ?>"
                                       class="btn btn-danger _delete pull-right mright5"><?php echo _l('delete'); ?></a>
                                <?php } ?>
                            <div class="clearfix"></div>
                            </p>
                        <?php } ?>
                        <hr class="hr-panel-heading"/>
                        <div class="clearfix"></div>

                        <?php if (!isset($article) && isset($kb_base_gruop)) { ?>
                            <div class="form-group">
                                <label class="control-label"><?php echo _l('kb_article_basic_group'); ?></label>
                                <select class="form-control selectpicker" id="cat" name="type">
                                    <option value=""><?php echo _l('nothing_was_specified'); ?></option>
                                    <?php foreach ($kb_base_gruop as $group) { ?>
                                        <option value="<?php echo $group->groupid ?>"><?php echo $group->name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="clearfix"></div>
                        <?php } ?>

                        <?php $value = (isset($article) ? $article->subject : ''); ?>
                        <?php $attrs = (isset($article) ? array() : array('autofocus' => true)); ?>
                        <?php echo render_input('subject', 'kb_article_add_edit_subject', $value, 'text', array_merge($attrs, ['required' => 'required'])); ?>
                        <?php if (isset($article)) {
                            echo render_input('slug', 'kb_article_slug', $article->slug, 'text');
                        } ?>
                        <?php
                        $value = (isset($article) ? $article->articlegroup : '');
                        $groups = (isset($article) ? kb_all_childe_group($article->type) : get_kb_groups());
                        foreach ($groups as $key => $group) {
                            $groups[$key]['full_name'] = kb_all_main_group_name($group['groupid']);
                        }
                        echo render_select('articlegroup', $groups, array('groupid', 'full_name', 'required' => 'required'), 'kb_article_add_edit_group', $value);
                        ?>
                        <div class="checkbox checkbox-primary">
                            <input type="checkbox" id="staff_article"
                                   name="staff_article" <?php if (isset($article) && $article->staff_article == 1) {
                                echo 'checked';
                            } ?>>
                            <label for="staff_article"><?php echo _l('internal_article'); ?></label>
                        </div>
                        <div class="checkbox checkbox-primary">
                            <input type="checkbox" id="disabled"
                                   name="disabled" <?php if (isset($article) && $article->active_article == 0) {
                                echo 'checked';
                            } ?>>
                            <label for="disabled"><?php echo _l('kb_article_disabled'); ?></label>
                        </div>

                        <!--                        <div class="form-group" append_plugins="stickytoolbar" app-field-wrapper="description">-->
                        <!--                            <label for="description" class="control-label">الموضوع</label>-->
                        <!--                            <textarea id="description" name="description[]" class="form-control tinymce-manual" append_plugins="stickytoolbar" required="required" rows="4">-->
                        <!--                            </textarea></div>-->

                        <!--                        <hr />-->
                        <div id="field" class="form-group">
                            <?php if (isset($article)) { ?>
                                <?php echo render_custom_fields('kb_' . $article->type, $article->articleid); ?>
                            <?php } ?>
                            <?php if (isset($fields)) { ?>
                                <?php $i = 0;
                                foreach ($fields as $f) {
                                    ?>
                                    <hr class="hr-panel-heading"/>
                                    <div id="fld-<?= $i ?>" class="form-group">
                                        <?php echo render_input('kb_custom_fields_id[]', '', $f['id'], '',[],[],'hide'); ?>

                                        <?php echo render_input('title[]', 'title', $f['title'], 'text', array_merge($attrs, ['required' => 'required'])); ?>
                                        <!--                                        --><?php //echo render_textarea('description[]','subject',$f['description'],array('append_plugins'=> 'stickytoolbar', 'required'=>'required'),array('append_plugins'=> 'stickytoolbar'),'','tinymce tinymce-manual');
                                        ?>

                                        <div class="form-group" append_plugins="stickytoolbar"
                                             app-field-wrapper="descriptions-<?= $i ?>">
                                            <label for="descriptions-<?= $i ?>"
                                                   class="control-label"><?php echo _l('subject'); ?></label>
                                            <textarea id="descriptions-<?= $i ?>" name="description[]"
                                                      class="form-control tinymce-manual" append_plugins="stickytoolbar"
                                                      required="required" rows="4">
                                                <?php echo $f['description']; ?>
                                            </textarea>
                                        </div>
                                        <a onclick="$('#fld-<?= $i ?>').html('')"
                                           class="btn btn-danger pull-left"><?php echo _l('delete_field'); ?></a>
                                        <div class="clearfix"></div>
                                    </div>
                                    <?php $i++;
                                } ?>
                            <?php } ?>

                        </div>
                    </div>

                </div>
            </div>
            <?php if ((has_permission('knowledge_base', '', 'create') && !isset($article)) || has_permission('knowledge_base', '', 'edit') && isset($article)) { ?>
                <div class="btn-bottom-toolbar btn-toolbar-container-out text-right">
                    <button type="submit" class="btn btn-info pull-right"><?php echo _l('submit'); ?></button>
                    <a onclick="new_field()" class="btn btn-info pull-left"><i
                                class="fa fa-plus"></i><?php echo ' ' . _l('new_field'); ?></a>

                </div>
            <?php } ?>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<?php $this->load->view('admin/knowledge_base/group'); ?>
<?php init_tail(); ?>
<script>
    var field_id = 0;
    $(function () {
        <?php if(isset($fields) ){?>
        <?php  $i = 0;
        foreach ($fields as $f){?>
        init_editor('#descriptions-<?php echo $i; ?>', {append_plugins: 'stickytoolbar'});
        <?php $i++;} ?>
        <?php } ?>
        init_editor('#description', {append_plugins: 'stickytoolbar'});
        appValidateForm($('#article-form'), {subject: 'required', articlegroup: 'required', type: 'required'});
    });

    function new_field() {
        field_id++;
        var x = `
       <div id="field-${field_id}" class="form-group">
               <hr class="hr-panel-heading" />
       <?php echo render_input('title[]', 'title', '', 'text', ['required' => 'required']); ?>
        <div class="form-group" append_plugins="stickytoolbar" app-field-wrapper="description-${field_id}">
        <label for="description-${field_id}" class="control-label"><?php echo _l('subject'); ?></label>
        <textarea id="description-${field_id}" name="description[]" class="form-control tinymce-manual" append_plugins="stickytoolbar" required="required" >
        </textarea></div>
       <a onclick="$('#field-${field_id}').html('')" class="btn btn-danger pull-left"><?php echo _l('delete_field'); ?></a>
       <div class="clearfix"></div>
        </div>
        `;
        $('#field').append(x);
        init_editor('#description-' + field_id, {append_plugins: 'stickytoolbar'});
    }

    $("#cat").change(function () {
        $('#field').html('');
        var id = $(this).val();
        $.ajax({
            url: "<?php echo admin_url('Knowledge_base/groups_fields'); ?>",
            data: {id: id},
            type: "POST",
            success: function (data) {
                $("#field").html(data);
                init_datepicker();
                init_selectpicker();
            }
        });
        $.ajax({
            url: "<?php echo admin_url('Knowledge_base/get_kb_all_childe_group_ajax'); ?>",
            data: {id: id},
            type: "POST",
            success: function (data) {
                $("#articlegroup").empty();
                response = JSON.parse(data);
                $('#articlegroup').append('<option value=""></option>');
                $.each(response, function (key, value) {
                    $('#articlegroup').append('<option value="' + value['group_id'] + '">' + value['full_name'] + '</option>');
                });
                $('#articlegroup').selectpicker('refresh');
            }
        });
    });

</script>
</body>
</html>
