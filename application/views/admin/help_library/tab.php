<section id="fancyTabWidget" class="tabs t-tabs">
    <ul class="nav nav-tabs fancyTabs" role="tablist">
        <li class="tab fancyTab active">
            <div class="arrow-down">
                <div class="arrow-down-inner"></div>
            </div>
            <a id="tab0" href="#tabBody0" role="tab" aria-expanded="true" aria-controls="tabBody0" aria-selected="true" data-toggle="tab" tabindex="0"><span class="fa fa-gavel"></span>السوابق القضائية</a>
            <div class="whiteBlock"></div>
        </li>
        <li class="tab fancyTab">
            <div class="arrow-down">
                <div class="arrow-down-inner"></div>
            </div>
            <a id="tab1" href="#tabBody1" role="tab" aria-controls="tabBody1" aria-selected="true" data-toggle="tab" tabindex="0"><span class="fa fa-balance-scale"></span>الانظمة السعودية</a>
            <div class="whiteBlock"></div>
        </li>
        <li class="tab fancyTab">
            <div class="arrow-down">
                <div class="arrow-down-inner"></div>
            </div>
            <a id="tab2" href="#tabBody2" role="tab" aria-controls="tabBody2" aria-selected="true" data-toggle="tab" tabindex="0"><span class="fa fa-tags"></span>نماذج وعقود</a>
            <div class="whiteBlock"></div>
        </li>
        <li class="tab fancyTab">
            <div class="arrow-down">
                <div class="arrow-down-inner"></div>
            </div>
            <a id="tab3" href="#tabBody3" role="tab" aria-controls="tabBody3" aria-selected="true" data-toggle="tab" tabindex="0"><span class="fa fa-book"></span>الكتب القانونية والأبحاث</a>
            <div class="whiteBlock"></div>
        </li>
    </ul>
    <div id="myTabContent" class="tab-content fancyTabContent" aria-live="polite">
        <div class="tab-pane fade active in" id="tabBody0" role="tabpanel" aria-labelledby="tab0" aria-hidden="false" tabindex="0">
            <div class="row">
                <?php
                foreach ($books as $book):
                    if($book != 'success'):
                        foreach ($book as $row):
                            if($row->main_section == 1): ?>
                                <div class="col-sm-3 col-md-3">
                                    <div class="thumbnail" style="height: 155px;">
                                        <div class="caption">
                                            <h4><?php echo $row->book_title; ?></h4>
                                            <?php foreach ($row->sections as $sec): ?>
                                                <?php if($sec->parent_id != 0) : ?>
                                                    <b>&nbsp;<i class="fa fa-angle-double-left text-primary"></i>&nbsp;<?php echo $sec->section_name; ?></b>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                            <br>
                                            <br>
                                            <p><a href="<?php echo $row->url; ?>" class="btn btn-primary" role="button" target="_blank">عرض</a></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; endforeach; endif; endforeach; ?>
            </div>
        </div>
        <div class="tab-pane fade" id="tabBody1" role="tabpanel" aria-labelledby="tab1" aria-hidden="true" tabindex="0">
            <div class="row">
                <?php
                foreach ($books as $book):
                    if($book != 'success'):
                        foreach ($book as $row):
                            if($row->main_section == 2): ?>
                                <div class="col-sm-3 col-md-3">
                                    <div class="thumbnail" style="height: 155px;">
                                        <div class="caption">
                                            <h4><?php echo $row->book_title; ?></h4>
                                            <?php foreach ($row->sections as $sec): ?>
                                                <?php if($sec->parent_id != 0) : ?>
                                                    <b>&nbsp;<i class="fa fa-angle-double-left text-primary"></i>&nbsp;<?php echo $sec->section_name; ?></b>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                            <br>
                                            <br>
                                            <p><a href="<?php echo $row->url; ?>" class="btn btn-primary" role="button" target="_blank">عرض</a></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; endforeach; endif; endforeach; ?>
            </div>
        </div>
        <div class="tab-pane fade" id="tabBody2" role="tabpanel" aria-labelledby="tab2" aria-hidden="true" tabindex="0">
            <div class="row">
                <?php
                foreach ($books as $book):
                    if($book != 'success'):
                        foreach ($book as $row):
                            if($row->main_section == 3): ?>
                                <div class="col-sm-3 col-md-3">
                                    <div class="thumbnail" style="height: 155px;">
                                        <div class="caption">
                                            <h4><?php echo $row->book_title; ?></h4>
                                            <?php foreach ($row->sections as $sec): ?>
                                                <?php if($sec->parent_id != 0) : ?>
                                                    <b>&nbsp;<i class="fa fa-angle-double-left text-primary"></i>&nbsp;<?php echo $sec->section_name; ?></b>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                            <br>
                                            <br>
                                            <p><a href="<?php echo $row->url; ?>" class="btn btn-primary" role="button" target="_blank">عرض</a></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; endforeach; endif; endforeach; ?>
            </div>
        </div>
        <div class="tab-pane fade" id="tabBody3" role="tabpanel" aria-labelledby="tab3" aria-hidden="true" tabindex="0">
            <div class="row">
                <?php
                foreach ($books as $book):
                    if($book != 'success'):
                        foreach ($book as $row):
                            if($row->main_section == 4): ?>
                                <div class="col-sm-3 col-md-3">
                                    <div class="thumbnail" style="height: 155px;">
                                        <div class="caption">
                                            <h4><?php echo $row->book_title; ?></h4>
                                            <?php foreach ($row->sections as $sec): ?>
                                                <?php if($sec->parent_id != 0) : ?>
                                                    <b>&nbsp;<i class="fa fa-angle-double-left text-primary"></i>&nbsp;<?php echo $sec->section_name; ?></b>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                            <br>
                                            <br>
                                            <p><a href="<?php echo $row->url; ?>" class="btn btn-primary" role="button" target="_blank">عرض</a></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; endforeach; endif; endforeach; ?>
            </div>
        </div>
    </div>
</section>