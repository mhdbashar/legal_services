<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
    <div class="panel_s section-knowledge-base">
        <div class="panel-body">
            <div class="row kb-article">
                <div class="col-md-<?php if(count($related_articles) == 0){echo '12';}else{echo '8';} ?>">
                    <h1 class="bold no-mtop kb-article-single-heading"><?php echo $article->subject; ?></h1>
                    <small>
                        <?php echo _l('article_total_views'); ?>: <?php echo total_rows(db_prefix().'views_tracking',array('rel_type'=>'kb_article','rel_id'=>$article->articleid)); ?>
                    </small>
                    <hr class="no-mtop" />
                    <div class="mtop10 tc-content kb-article-content">
                        <?php
                        $custom_fields = get_custom_fields('kb_'.$article->type);
                        foreach ($custom_fields as $custom){
                            $fields_ = get_custom_field_value($article->articleid,$custom['id'],$custom['fieldto']);
                            ?>
                            <h4 class="<?php echo $custom['type'];?>" style="color: rgb(48, 176, 232)"> <?php echo $custom['name'];?> </h4>
                            <p> <?php echo $fields_;?> </p>
                            <br>
                        <?php } ?>
                        <?php foreach ( $fields as $d){
                            echo '<h4 class="text text-xl pb-4 pt-2 " style="color: rgb(48, 176, 232)">'.$d['title'].'</h4>';
                            echo '<p>'.$d['description'].'</p>';
                            echo '<br>';
                        }?>

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
<?php
