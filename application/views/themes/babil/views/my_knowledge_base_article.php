<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


<div class="panel_s section-knowledge-base" dir="rtl">
    <div class="panel-body">
        <div class="row kb-article" >
            <div class="col-md-12<?php //if(count($related_articles) == 0){echo '12';}else{echo '8';} ?>">
                <h1 class="bold no-mtop kb-article-single-heading"><?php echo $article->subject; ?></h1>
                <small>
                    <?php echo _l('article_total_views'); ?>: <?php echo total_rows(db_prefix().'views_tracking',array('rel_type'=>'kb_article','rel_id'=>$article->articleid)); ?>
                </small>
                <hr class="no-mtop" />
                <?php
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
                                    <td ><?php echo $custom['name'].' :'; ?></td>
                                    <td ><?php echo $field;?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                        <!--                    </div>-->
                    <?php } ?>
                <div class="mtop10 tc-content kb-article-content">
				
				<?php $i=0; ?>
       
                    <?php foreach ( $fields as $d){
						
						?>
               
                                                  
                  
                  
                  
                  
                  
                  
                                                    <div>

                                                      

   
                                   <h3 style="color: rgb(255 255 255);background-color: #51647c;height: 28px;padding: 4px;"  data-toggle="collapse"  data-target="#demo<?php echo $i;?>"><i style="margin-right: 8px;" class="fa fa-minus-circle"></i>
  
                </h3>                  
                                                      
                                                      
                                                      
                                                      

                      
                      
                  
                 
              
              
                  
                        <p id="demo<?php echo $i;?>"   class="show"    data-parent="#accordion"   ><?php echo $d['description']; ?></p>
                  
                  
                  
						  <button style="float: left;";   class="fa fa-files-o"  onclick="copyElementText('demo<?php echo $i;?>')" title="نسخ النص لهذه المادة"></button>
                       <br>
                        <br>
						
						<?php
						$i++;
						?>
                        <hr class="no-mtop" />
						
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
<!--            --><?php //if(count($related_articles) > 0){ ?>
<!--                <div class="visible-xs visible-sm">-->
<!--                    <br />-->
<!--                </div>-->
<!--                <div class="col-md-4">-->
<!--                    <h4 class="bold no-mtop h3 kb-related-heading">--><?php //echo _l('related_knowledgebase_articles'); ?><!--</h4>-->
<!--                    <hr class="no-mtop" />-->
<!--                    <ul class="mtop10 articles_list">-->
<!--                        --><?php //foreach($related_articles as $relatedArticle) { ?>
<!--                            <li>-->
<!--                                <h4 class="article-heading article-related-heading">-->
<!--                                    <a href="--><?php //echo site_url('knowledge-base/article/'.$relatedArticle['articleid']); ?><!--">-->
<!--                                        --><?php //echo $relatedArticle['subject']; ?>
<!--                                    </a>-->
<!--                                </h4>-->
<!--                                						<div class="text-muted mtop10">--><?php //echo mb_substr(strip_tags($relatedArticle['description']),0,150); ?><!--...</div>-->
<!--                            </li>-->
<!--                            <hr class="hr-10" />-->
<!--                        --><?php //} ?>
<!--                    </ul>-->
<!--                </div>-->
<!--            --><?php //}	?>
            <?php hooks()->do_action('after_single_knowledge_base_article_customers_area',$article->articleid); ?>
        </div>
    </div>
</div>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script>
	
                function copyElementText(id) {

				
                                var text = document.getElementById(id).innerText;
								var elem = document.createElement("textarea");
                                document.body.appendChild(elem);
                                elem.value = text;
                                elem.select();
                                document.execCommand("copy");
                                document.body.removeChild(elem);
								
								Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                 title: 'تم نسخ النص بنجاح',
                                 showConfirmButton: false,
                                timer: 1500
                                     })
                            }
	
	</script>
  
  

  
  
  
  
  
  
  
  