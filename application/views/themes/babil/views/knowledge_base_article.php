<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
    <div class="panel_s section-knowledge-base" dir="rtl">
        <div class="panel-body">
            <div class="row kb-article" >
                <div class="col-md-<?php if(count($related_articles) == 0){echo '12';}else{echo '8';} ?>">
                    <h1 class="bold no-mtop kb-article-single-heading"><?php echo $article->subject; ?></h1>
                    <small>
                        <?php echo _l('article_total_views'); ?>: <?php echo total_rows(db_prefix().'views_tracking',array('rel_type'=>'kb_article','rel_id'=>$article->articleid)); ?>
                    </small>
                    <hr class="no-mtop" />
                    <?php if($article->type == 2){
                        $custom_fields = get_custom_fields('kb_'.$article->type);

                    if(count($custom_fields) > 0){
                        ?>
<!--                    <div class="col-md-12" >-->
                        <table class="table table-striped">
                            <thead>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($custom_fields as $custom){
                                $field = get_custom_field_value($article->articleid,$custom['id'],$custom['fieldto']);
                                ?>
                                <tr>
                                    <td scope="1"><?php echo $custom['name']; ?></td>
                                    <td scope="2"><?php echo $field;?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
<!--                    </div>-->
                    <?php } } ?>
                    <div class="mtop10 tc-content kb-article-content">
                        <?php foreach ( $fields as $d){
                            echo '<h4  style="color: rgb(48, 176, 232)">'.$d['title'].'</h4>';
                            echo $d['description'];
                            echo '<br>';
                            echo '<br>';?>

                       <?php }?>

                    </div>
                    <hr />
                    <h4 class="mtop20"><?php echo _l('clients_knowledge_base_find_useful'); ?></h4>
                    <div class="answer_response"></div>
                    <div class="btn-group mtop15 article_useful_buttons" role="group">
                        <input type="hidden" name="articleid" value="<?php echo $article->articleid; ?>">
                        <button type="button" data-answer="1" class="btn btn-success"><?php echo _l('clients_knowledge_base_find_useful_yes'); ?></button>
                        <button type="button" data-answer="0" class="btn btn-danger"><?php echo _l('clients_knowledge_base_find_useful_no'); ?></button>
                    </div>
                </div>
                <?php if(count($related_articles) > 0){ ?>
                    <div class="visible-xs visible-sm">
                        <br />
                    </div>
                    <div class="col-md-4">
                        <h4 class="bold no-mtop h3 kb-related-heading"><?php echo _l('related_knowledgebase_articles'); ?></h4>
                        <hr class="no-mtop" />
                        <ul class="mtop10 articles_list">
                            <?php foreach($related_articles as $relatedArticle) { ?>
                                <li>
                                    <h4 class="article-heading article-related-heading">
                                        <a href="<?php echo site_url('knowledge-base/article/'.$relatedArticle['articleid']); ?>">
                                            <?php echo $relatedArticle['subject']; ?>
                                        </a>
                                    </h4>
                                    <!--						<div class="text-muted mtop10">--><?php //echo mb_substr(strip_tags($relatedArticle['description']),0,150); ?><!--...</div>-->
                                </li>
                                <hr class="hr-10" />
                            <?php } ?>
                        </ul>
                    </div>
                <?php }	?>
                <?php hooks()->do_action('after_single_knowledge_base_article_customers_area',$article->articleid); ?>
            </div>
        </div>
    </div>