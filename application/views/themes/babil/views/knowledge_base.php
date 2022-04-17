<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="panel_s" dir="rtl">
    <div class="panel-body">
        <?php if(count($articles) == 0){ ?>
            <p class="no-margin"><?php echo _l('clients_knowledge_base_articles_not_found'); ?></p>
        <?php } ?>
        <?php if(isset($category)){
            // Category articles list
            get_template_part('knowledge_base/category_articles_list', array('articles'=>$articles,'childe_groups'=>$childe_groups));
        }  else if(isset($search_results)) {
            // Search results
            get_template_part('knowledge_base/search_results', array('articles'=>$articles));
        } else {
            // Default page
            get_template_part('knowledge_base/categories', array('main_groups'=>$main_groups));
        }
        hooks()->do_action('after_kb_groups_customers_area');
        ?>
    </div>
</div>
