<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head();?>
<div id="wrapper">
    <div class="content">
        <?php echo form_open($this->uri->uri_string(),array('id'=>'article-form')); ?>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel_s">
                    <div id="field" class="panel-body">
                        <h4 class="no-margin">
                            <?php echo $title; ?>
                            <?php if(isset($article)){ ?>
                                <br />
                                <small>
                                    <?php if($article->staff_article == 1){ ?>
                                        <a href="<?php echo admin_url('knowledge_base/view/'.$article->articleid); ?>" target="_blank"><?php echo admin_url('knowledge_base/view/'.$article->slug); ?></a>
                                    <?php } else { ?>
                                        <a href="<?php echo site_url('knowledge-base/article/'.$article->articleid); ?>" target="_blank"><?php echo site_url('knowledge-base/article/'.$article->slug); ?></a>
                                    <?php } ?>
                                </small>
                            <?php } ?>
                        </h4>
                        <?php if(isset($article)){ ?>
                            <p>
                                <small>
                                    <?php echo _l('article_total_views'); ?>: <?php echo total_rows(db_prefix().'views_tracking',array('rel_type'=>'kb_article','rel_id'=>$article->articleid)); ?>
                                </small>
                                <?php if(has_permission('knowledge_base','','create')){ ?>
                                    <a href="<?php echo admin_url('knowledge_base/article'); ?>" class="btn btn-success pull-right"><?php echo _l('kb_article_new_article'); ?></a>
                                <?php } ?>
                                <?php if(has_permission('knowledge_base','','delete')){ ?>
                                    <a href="<?php echo admin_url('knowledge_base/delete_article/'.$article->articleid); ?>" class="btn btn-danger _delete pull-right mright5"><?php echo _l('delete'); ?></a>
                                <?php } ?>
                            <div class="clearfix"></div>
                            </p>
                        <?php } ?>
                        <hr class="hr-panel-heading" />
                        <div class="clearfix"></div>

                        <?php $value = (isset($article) ? $article->subject : ''); ?>
                        <?php $attrs = (isset($article) ? array() : array('autofocus'=>true)); ?>
                        <?php echo render_input('subject','kb_article_add_edit_subject',$value,'text',array_merge($attrs, ['required'=>'required'])); ?>
                        <?php if(isset($article)){
                            echo render_input('slug','kb_article_slug',$article->slug,'text');
                        } ?>
                        <?php $value = (isset($article) ? $article->articlegroup : ''); ?>
                        <?php if(has_permission('knowledge_base','','create')){
                            echo render_select_with_input_group('articlegroup',get_kb_groups(),array('groupid','name',  'required'=>'required'),'kb_article_add_edit_group',$value,'<a href="#" onclick="new_kb_group();return false;"><i class="fa fa-plus"></i></a>');
                        } else {
                            echo render_select('articlegroup',get_kb_groups(),array('groupid','name', 'required'=>'required'),'kb_article_add_edit_group',$value);
                        }
                        ?>
                        <div class="checkbox checkbox-primary">
                            <input type="checkbox" id="staff_article" name="staff_article" <?php if(isset($article) && $article->staff_article == 1){echo 'checked';} ?>>
                            <label for="staff_article"><?php echo _l('internal_article'); ?></label>
                        </div>
                        <div class="checkbox checkbox-primary">
                            <input type="checkbox" id="disabled" name="disabled" <?php if(isset($article) && $article->active_article == 0){echo 'checked';} ?>>
                            <label for="disabled"><?php echo _l('kb_article_disabled'); ?></label>
                        </div>
                        <?php if(isset($fields) && count($fields)>0){?>
                            <?php  $i=0;
                            foreach ($fields as $f){?>
                                <div id="field-<?=$i?>" class="row">
                                <?php echo render_input('title[]','title',$f['title'],'text',array_merge($attrs, ['required'=>'required']));?>
                                <?php echo render_textarea('description[]','subject',$f['description'],array('append_plugins'=> 'stickytoolbar', 'required'=>'required'),array('append_plugins'=> 'stickytoolbar'),'','tinymce tinymce-manual');?>
                                <a onclick="$('#field-<?=$i?>').html('')" class="btn btn-danger pull-left"><?php echo _l('delete_field'); ?></a>
                                <div class="clearfix"></div>
                                <hr class="hr-panel-heading" />
                                </div>
                            <?php $i++;}?>
                        <?php }else{?>
                            <div id="fld-0" class="row">
                            <?php echo render_input('title[]','title','','text',array_merge($attrs, ['required'=>'required'])); ?>
                            <?php echo render_textarea('description[]','subject','',array('append_plugins'=> 'stickytoolbar', 'required'=>'required'),array('append_plugins'=> 'stickytoolbar'),'','tinymce tinymce-manual'); ?>
                            <a onclick="$('#fld-0').html('')" class="btn btn-danger pull-left"><?php echo _l('delete_field'); ?></a>
                            <div class="clearfix"></div>
                            <hr class="hr-panel-heading" />
                            </div>

                        <?php } ?>

                    </div>

                </div>
            </div>
            <?php if((has_permission('knowledge_base','','create') && !isset($article)) || has_permission('knowledge_base','','edit') && isset($article)){ ?>
                <div class="btn-bottom-toolbar btn-toolbar-container-out text-right">
                    <button type="submit" class="btn btn-info pull-right"><?php echo _l('submit'); ?></button>
                    <a onclick="new_field()" class="btn btn-info pull-left"><i class="fa fa-plus"></i><?php echo _l('new_field'); ?></a>

                </div>
            <?php } ?>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<?php $this->load->view('admin/knowledge_base/group'); ?>
<?php init_tail(); ?>
<script>
    var i=0;
    $(function(){
        // init_editor('#description[0]', {append_plugins: 'stickytoolbar'});
        // appValidateForm($('#article-form'),{subject:'required',articlegroup:'required'});
    });
    function new_field() {
        i++;
        var x =`
       <div id="fld-${i}" class="row">
       <?php echo render_input('title[]','title','','text',['required'=>'required']); ?>
       <?php echo render_textarea('description[]','subject','',['required'=>'required'],array(),'','tinymce tinymce-manual'); ?>
       <a onclick="$('#fld-${i}').html('')" class="btn btn-danger pull-left"><?php echo _l('delete_field'); ?></a>
       <div class="clearfix"></div>
       <hr class="hr-panel-heading" />
        </div>
        `;
        $('#field').append(x);
    }
    function delete_field() {

    }
</script>
</body>
</html>
