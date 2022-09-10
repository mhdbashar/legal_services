<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<style>
    .feedback {
        padding: 10px 20px;
        border-radius: 4px;
        border-color: #84c529;
    }

    #mybutton {
        position: absolute;
        bottom: -11px;
        left: 3px;
    }

    .card {
        width: 240px;
        min-height: 250px;
        float: right;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <?php if (isset($childe_groups) && ($childe_groups) > 0) { ?>
                <?php foreach ($childe_groups as $category) { ?>
                    <div class="col-md-4 article-box">
                        <div class="text-center pt-3 card">
                            <img alt="category" src="<?php echo base_url() ?>assets/images/book.png" width="150"
                                 height="150"><br>
                            <span style="color:#093a64;font-weight: 900;font-size:13;">
          <a style="display:inline-block;"
             href="<?php echo site_url('knowledge-base/category/' . $category->groupid); ?>"> <?php echo $category->name; ?>  </a> </span>
                            <small><?php echo $category->description; ?></small>
                        </div>
                    </div>

                <?php } ?>
            <?php } ?>

            <?php foreach ($articles as $category) { ?>
                <!--<div style="padding-bottom: 35px;">-->
                <!-- <php echo "<h4>" ?>>-->
                <!--<php echo $category['name']; ?>-->
                <!-- <php echo "</h4>" ?>-->
                <!-- </div>-->
                <ul class="list-unstyled articles_list">
                    <?php foreach ($category['articles'] as $article) { ?>
                        <div class="col-md-4 article-box">
                            <div class="text-center pt-3 card">
                                <img alt="category" src="<?php echo base_url() ?>assets/images/book.png" width="150"
                                     height="150"><br>
                                <div style="color:#093a64;font-weight: 900;font-size:13px;">
                                    <a href="<?php echo site_url('knowledge-base/article/' . $article['articleid']); ?>">
                                        <?php
                                        echo $article['subject'];
                                        ?>
                                    </a></div>
                            </div>
                        </div>
                    <?php } ?>
                </ul>
            <?php } ?>
            <div id="mybutton">
                <a style="background-color: #84c529;" class="btn btn-primary a-button feedback"
                   href="javascript:history.go(-1)" title="Return to the previous page">رجوع للخلف</a>
            </div>
        </div>
    </div>
</div>
