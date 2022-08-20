<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="panel_s section-knowledge-base" dir="rtl">
    <div class="panel-body">
        <div class="row kb-article" >
            <div class="col-md-12">
                <div class="mtop10 tc-content kb-article-content">
                    <?php if($result > 0){?>
                        <?php foreach ($result as $d){
                            echo '<a href="'.$d['link'].'"><h3  style="color: rgb(48, 176, 232)">'.$d['name'].'</h3></a>';
                            echo '<h5 style="">'.$d['title'].'</h5>';
                            echo '<p style="">'.$d['description'].'</p>';
                            echo '<br>';
                            echo '<br>';?>
                            <hr class="no-mtop" />
                        <?php }?>
                    <?php }else echo '<h5 style="">لايوجد نتائج</h5>';?>
                </div>
                <div class="btn-group mtop15 article_useful_buttons" role="group">
                    <a style="position: relative;background-color: #84c529;" class="btn btn-primary a-button" href="javascript:history.go(-1)" title="Return to the previous page">رجوع للخلف</a>
                </div>
            </div>
        </div>
    </div>
</div>