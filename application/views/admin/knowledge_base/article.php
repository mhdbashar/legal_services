<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <?php echo form_open($this->uri->uri_string(), array('id' => 'article-form')); ?>
        <div class="row">
            <div class="col-md-12">
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
                        <?php if (isset($article)) { ?>
                            <?php echo render_custom_fields('kb_' . $article->type, $article->articleid); ?>
                        <?php } ?>
                        <div id="field" class="form-group">
                            <?php if (isset($fields)) { ?>
                                <?php $i = 1;
                                $l = 1;
                                foreach ($fields

                                         as $f) {
                                    ?>
                                    <div id="field-<?= $i ?>" class="form-group">
                                        <hr class="hr-panel-heading"/>
                                        <?php echo render_input("fields[$i][kb_custom_fields_id]", '', $f['id'], '', [], [], 'hide'); ?>
                                        <div class="form-group" app-field-wrapper="field[<?= $i ?>][title]">
                                            <label for="field[<?= $i ?>][title]"
                                                   class="control-label"><?php echo _l('title'); ?></label>
                                            <input type="text" id="field[<?= $i ?>][title]"
                                                   name="fields[<?= $i ?>][title]" class="form-control"
                                                   required="required" value="<?= $f['title'] ?>">
                                        </div>
                                        <div class="form-group" append_plugins="stickytoolbar"
                                             app-field-wrapper="description-<?= $i ?>">
                                            <label for="description-<?= $i ?>"
                                                   class="control-label"><?php echo _l('subject'); ?></label>
                                            <textarea id="description-<?= $i ?>" name="fields[<?= $i ?>][description]"
                                                      class="form-control tinymce-manual" append_plugins="stickytoolbar"
                                                      required="required" rows="4">
                                                <?php echo $f['description']; ?>
                                            </textarea></div>
                                        <a onclick="$('#field-<?= $i ?>').html('')"
                                           class="btn btn-danger _delete pull-left"><?php echo _l('delete_field'); ?></a>
                                        <a onclick="link(<?= $i ?>)"
                                           class="btn btn-info mleft10 pull-left"><?php echo _l('إضافة إرتباط'); ?></a>
                                        <div class="clearfix"></div>
                                        <?php if (isset($f['links'])) { ?>
                                            <?php
                                            foreach ($f['links']

                                                     as $link) {
                                                ?>
                                                <div class="form-group" id="field-link-<?= $l ?>">
                                                    <?php
                                                    echo render_input("fields[$i][link][$l][knowledge]", 'kb_article_slug', $link['knowledge_link_id'], 'text', [], [], 'hide');
                                                    echo render_input("fields[$i][link][$l][field]", 'kb_article_slug', $link['ct_link_id'], 'text', [], [], 'hide');
                                                    ?>
                                                    <hr class="hr-panel-heading"/>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-2">
                                                                <a onclick="$('#field-link-<?= $l ?>').html('')"
                                                                   class="btn btn-danger _delete pull-left"><?php echo _l('حذف الارتباط'); ?></a>
                                                            </div>
                                                            <div class="col-md-10">
                                                                <h5 class="">
                                                                    <?= get_knowledge_custom_field($link['ct_link_id'])->title ?> >>
                                                                    <?= get_knowledge_article($link['knowledge_link_id'])->subject ?> >>
                                                                    <?= kb_all_main_group_name($link['group_link_id']) ?>
                                                                </h5>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php $l++;
                                            }
                                        } ?>
                                    </div>
                                    <?php $i++;
                                } ?>
                            <?php } ?>
                        </div>
                        <div class="clearfix"></div>
                        <div class="clearfix"></div>
                        <div class="clearfix"></div>
                        <div class="clearfix"></div>

                    </div>

                </div>
            </div>
            <?php if ((has_permission('knowledge_base', '', 'create') && !isset($article)) || has_permission('knowledge_base', '', 'edit') && isset($article)) { ?>
                <div class="btn-bottom-toolbar btn-toolbar-container-out text-right">
                    <button type="submit" class="btn btn-info pull-right"><?php echo _l('submit'); ?></button>
                    <a onclick="new_field()" class="btn btn-info pull-left">
                        <i class="fa fa-plus"></i><?php echo ' ' . _l('new_field'); ?></a>
                </div>
            <?php } ?>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>

<?php //$this->load->view('admin/knowledge_base/group'); ?>
<?php init_tail(); ?>
<script>
    var field_id = 1000;
    var link_id = 1000;

    $(function () {
        <?php if(isset($fields) ){?>
        <?php  $i = 1;
        foreach ($fields as $f){?>
        init_editor('#description-<?php echo $i; ?>', {append_plugins: 'stickytoolbar'});
        <?php $i++;} ?>
        <?php } ?>
        appValidateForm($('#article-form'), {subject: 'required', articlegroup: 'required', type: 'required'});
    });

    function new_field() {
        field_id++;
        var x = `
       <div id="field-${field_id}" class="form-group">
       <hr class="hr-panel-heading" />
       <div class="form-group" app-field-wrapper="field[${field_id}][title]">
       <label for="field[${field_id}][title]" class="control-label"><?php echo _l('title'); ?></label>
       <input type="text" id="field[${field_id}][title]" name="fields[${field_id}][title]" class="form-control" required="required" value="">
       </div>
        <div class="form-group" append_plugins="stickytoolbar" app-field-wrapper="description-${field_id}">
        <label for="description-${field_id}" class="control-label"><?php echo _l('subject'); ?></label>
        <textarea id="description-${field_id}" name="fields[${field_id}][description]" class="form-control tinymce-manual" append_plugins="stickytoolbar" required="required">
        </textarea></div>
       <a onclick="$('#field-${field_id}').html('')" class="btn btn-danger _delete pull-left"><?php echo _l('delete_field'); ?></a>
       <a onclick="link(${field_id})" class="btn btn-info mleft10 pull-left"><?php echo _l('إضافة إرتباط'); ?></a>
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
                    $('#articlegroup').append('<option value="' + value['groupid'] + '">' + value['full_name'] + '</option>');
                });
                $('#articlegroup').selectpicker('refresh');
            }
        });
    });

    function link(id) {
        link_id++;
        var x = `
            <div class="form-group" id="field-link-${link_id}">
                <div class="clearfix"></div>
                <div class="form-group hide" id="link-1-group-${link_id}">
                    <label for="link-1-${link_id}" class="control-label"><?php echo _l('مرتبط بـ') ?></label>
                    <select class="form-control" id="link-1-${link_id}" onchange="get_childe_group(${link_id},2,this.value)"
                            name="fields[${id}][link][${link_id}][]"
                            placeholder="<?php echo _l('dropdown_non_selected_tex'); ?>">
                    </select>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group hide" id="link-2-group-${link_id}">
                    <label for="link-2-${link_id}" class="control-label"><?php echo _l('القسم الرئيسي') ?></label>
                    <select class="form-control" id="link-2-${link_id}" onchange="get_childe_group(${link_id},3,this.value)"
                            name="fields[${id}][link][${link_id}][]"
                            placeholder="<?php echo _l('dropdown_non_selected_tex'); ?>">
                    </select>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group hide" id="link-3-group-${link_id}">
                    <label for="link-3-${link_id}" class="control-label"><?php echo _l('القسم الفرعي 1') ?></label>
                    <select class="form-control" id="link-3-${link_id}" onchange="get_childe_group(${link_id},4,this.value)"
                            name="fields[${id}][link][${link_id}][]"
                            placeholder="<?php echo _l('dropdown_non_selected_tex'); ?>">
                    </select>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group hide" id="link-4-group-${link_id}">
                    <label for="link-4-${link_id}" class="control-label"><?php echo _l('القسم الفرعي 2') ?></label>
                    <select class="form-control" id="link-4-${link_id}" onchange="get_childe_group(${link_id},5,this.value)"
                            name="fields[${id}][link][${link_id}][]"
                            placeholder="<?php echo _l('dropdown_non_selected_tex'); ?>">
                    </select>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group hide" id="link-5-group-${link_id}">
                    <label for="link-5-${link_id}" class="control-label"><?php echo _l('القسم الفرعي 3') ?></label>
                    <select class="form-control" id="link-5-${link_id}" onchange="get_childe_group(${link_id},6,this.value)"
                            name="fields[${id}][link][${link_id}][]"
                            placeholder="<?php echo _l('dropdown_non_selected_tex'); ?>">
                    </select>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group hide" id="link-6-group-${link_id}">
                    <label for="link-6-${link_id}" class="control-label"><?php echo _l('القسم الفرعي 4') ?></label>
                    <select class="form-control" id="link-6-${link_id}" onchange="get_childe_group(${link_id},7,this.value)"
                            name="fields[${id}][link][${link_id}][]"
                            placeholder="<?php echo _l('dropdown_non_selected_tex'); ?>">
                    </select>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group hide" id="link-7-group-${link_id}">
                    <label for="link-7-${link_id}" class="control-label"><?php echo _l('القسم الفرعي 5') ?></label>
                    <select class="form-control" id="link-7-${link_id}" onchange="get_childe_group(${link_id},8,this.value)"
                            name="fields[${id}][link][${link_id}][]"
                            placeholder="<?php echo _l('dropdown_non_selected_tex'); ?>">
                    </select>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group hide" id="link-8-group-${link_id}">
                    <label for="link-8-${link_id}" class="control-label"><?php echo _l('القسم الفرعي 6') ?></label>
                    <select class="form-control" id="link-8-${link_id}" onchange="get_childe_group(${link_id},9,this.value)"
                            name="fields[${id}][link][${link_id}][]"
                            placeholder="<?php echo _l('dropdown_non_selected_tex'); ?>">
                    </select>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group hide" id="link-9-group-${link_id}">
                    <label for="link-9-${link_id}" class="control-label"><?php echo _l('القسم الفرعي 7') ?></label>
                    <select class="form-control" id="link-9-${link_id}" onchange="get_childe_group(${link_id},10,this.value)"
                            name="fields[${id}][link][${link_id}][]"
                            placeholder="<?php echo _l('dropdown_non_selected_tex'); ?>">
                    </select>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group hide" id="knowledg-group-${link_id}">
                    <label for="knowledg-${link_id}" class="control-label"><?php echo _l('عنوان المحتوى') ?></label>
                    <select class="form-control" id="knowledg-${link_id}" onchange="get_fields(${link_id},this.value)"
                            name="fields[${id}][link][${link_id}][knowledge]"
                            placeholder="<?php echo _l('dropdown_non_selected_tex'); ?>">
                    </select>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group hide" id="knowledge-fields-group-${link_id}">
                    <label for="knowledge-fields-${link_id}" class="control-label"><?php echo _l('عنوان الحقل') ?></label>
                    <select class="form-control" id="knowledge-fields-${link_id}"
                            name="fields[${id}][link][${link_id}][field]"
                            placeholder="<?php echo _l('dropdown_non_selected_tex'); ?>">
                    </select>
                    <div class="clearfix"></div>
                </div>
                <a onclick="$('#field-link-${link_id}').html('')"
                class="btn btn-danger _delete pull-left"><?php echo _l('حذف الارتباط'); ?></a>
                <div class="clearfix"></div>
                <hr class="hr-panel-heading"/>
            </div>
        `;
        $(`#field-${id}`).append(x);
        $.ajax({
            url: "<?php echo admin_url('Knowledge_base/get_kb_country_groups_ajax'); ?>",
            type: "POST",
            success: function (data) {
                response = JSON.parse(data);
                $(`#link-1-${link_id}`).append('<option value=""></option>');
                $.each(response, function (key, value) {
                    $(`#link-1-${link_id}`).append('<option value="' + value['groupid'] + '">' + value['name'] + '</option>');
                });
                $(`#link-1-${link_id}`).selectpicker('refresh');
                $(`#link-1-group-${link_id}`).removeClass('hide');
            }
        });
    }

    function get_childe_group(linkid, childid, groupid) {
        var hide_child = childid;
        $(`#knowledge-fields-${linkid}`).empty();
        $(`#knowledge-fields-${linkid}`).selectpicker('refresh');
        $(`#knowledge-fields-group-${linkid}`).addClass('hide');
        $(`#knowledg-${linkid}`).empty();
        $(`#knowledg-${linkid}`).selectpicker('refresh');
        $(`#knowledg-group-${linkid}`).addClass('hide');
        for (var i = 0; i < 10; i++) {
            $(`#link-${hide_child}-${linkid}`).empty();
            $(`#link-${hide_child}-${linkid}`).selectpicker('refresh');
            $(`#link-${hide_child}-group-${linkid}`).addClass('hide');
            hide_child++;
        }
        if (groupid !== '') {
            $.ajax({
                url: "<?php echo admin_url('Knowledge_base/get_all_childe_group_ajax'); ?>",
                data: {id: groupid},
                type: "POST",
                success: function (data) {
                    response = JSON.parse(data);
                    if (response !== 0) {
                        $(`#link-${childid}-${linkid}`).append('<option value=""></option>');
                        $.each(response, function (key, value) {
                            $(`#link-${childid}-${linkid}`).append('<option value="' + value['groupid'] + '">' + value['name'] + '</option>');
                        });
                        $(`#link-${childid}-${linkid}`).selectpicker('refresh');
                        $(`#link-${childid}-group-${linkid}`).removeClass('hide');
                    } else {
                        $.ajax({
                            url: "<?php echo admin_url('Knowledge_base/get_knowledge_ajax'); ?>",
                            data: {id: groupid},
                            type: "POST",
                            success: function (data) {
                                response = JSON.parse(data);
                                $(`#knowledg-${linkid}`).append('<option value=""></option>');
                                $.each(response, function (key, value) {
                                    $(`#knowledg-${linkid}`).append('<option value="' + value['articleid'] + '">' + value['subject'] + '</option>');
                                });
                                $(`#knowledg-${linkid}`).selectpicker('refresh');
                                $(`#knowledg-group-${linkid}`).removeClass('hide');
                            }
                        });
                    }
                }
            });
        }
    }

    function get_fields(linkid, knowledgid) {
        $(`#knowledge-fields-${linkid}`).empty();
        $(`#knowledge-fields-${linkid}`).selectpicker('refresh');
        if (knowledgid !== '') {
            $.ajax({
                url: "<?php echo admin_url('Knowledge_base/get_knowledge_fields_ajax'); ?>",
                data: {id: knowledgid},
                type: "POST",
                success: function (data) {
                    response = JSON.parse(data);
                    $(`#knowledge-fields-${linkid}`).append('<option value=""></option>');
                    $.each(response, function (key, value) {
                        $(`#knowledge-fields-${linkid}`).append('<option value="' + value['id'] + '">' + value['title'] + '</option>');
                    });
                    $(`#knowledge-fields-${linkid}`).selectpicker('refresh');
                    $(`#knowledge-fields-group-${linkid}`).removeClass('hide');
                }
            });
        }
    }

</script>
</body>
</html>
