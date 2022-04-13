<?php defined('BASEPATH') or exit('No direct script access allowed');?>
<?php if(isset($main_groups) && count($main_groups)>0){?>
    <?php foreach($main_groups as $category){?>
        <div class="col-md-12">
            <div class="article_group_wrapper">
                <h4 class="bold"><i class="fa fa-folder-o"></i> <a href="<?php echo site_url('knowledge-base/category/'.$category->groupid); ?>"><?php echo $category->name; ?></a>
<!--                    <small>--><?php //echo count($category->description); ?><!--</small>-->
                </h4>
            </div>
        </div>
    <?php } ?>
<?php } ?>

