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
            <a id="tab2" href="#tabBody2" role="tab" aria-controls="tabBody2" aria-selected="true" data-toggle="tab" tabindex="0"><span class="fa fa-tags"></span>المبادئ القضائية</a>
            <div class="whiteBlock"></div>
        </li>
        <li class="tab fancyTab">
            <div class="arrow-down">
                <div class="arrow-down-inner"></div>
            </div>
            <a id="tab3" href="#tabBody3" role="tab" aria-controls="tabBody3" aria-selected="true" data-toggle="tab" tabindex="0"><span class="fa fa-book"></span>الكتب القانونية والأبحاث</a>
            <div class="whiteBlock"></div>
        </li>
        <li class="tab fancyTab">
            <div class="arrow-down">
                <div class="arrow-down-inner"></div>
            </div>
            <a id="tab4" href="#tabBody4" role="tab" aria-controls="tabBody4" aria-selected="true" data-toggle="tab" tabindex="0"><span class="fa fa-bullhorn"></span>الأنظمة والتشريعات والقوانين</a>
            <div class="whiteBlock"></div>
        </li>
    </ul>
    <div id="myTabContent" class="tab-content fancyTabContent" aria-live="polite">
        <div class="tab-pane fade active in" id="tabBody0" role="tabpanel" aria-labelledby="tab0" aria-hidden="false" tabindex="0">
            <div class="row">
                <?php if(!empty($books)): ?>
                <?php
                foreach ($books as $book):
                    if($book != 'success'):
                        foreach ($book as $row):
                            if($row->main_section == 31): ?>
                                <div class="col-sm-3 col-md-3">
                                    <div class="thumbnail book-body">
                                        <div class="row">
                                        <div class="col-md-8 caption">
                                            <h4><?php echo $row->book_title; ?></h4>
                                            <?php foreach ($row->sections as $sec): ?>
                                                <?php if($sec->parent_id != 0) : ?>
                                                    <b>&nbsp;<i class="fa fa-angle-double-left text-primary"></i>&nbsp;<?php echo $sec->section_name; ?></b>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                            <br>
                                            <br>
                                            <p><a href="<?php echo $row->url; ?>" class="btn btn-primary book-btn" role="button" target="_blank"><?php echo _l('view_book'); ?></a></p>
                                        </div>
                                        <div class="col-md-4">
                                            <i class="fa fa-book book-style"></i>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            <?php endif; endforeach; endif; endforeach; ?>
                <?php else: ?>
                    <h4 class="text-center"><?php echo _l('smtp_encryption_none'); ?>...</h4>
                <?php endif; ?>
            </div>
        </div>
        <div class="tab-pane fade" id="tabBody1" role="tabpanel" aria-labelledby="tab1" aria-hidden="true" tabindex="0">
            <div class="row">
                <?php if(!empty($books)): ?>
                <?php
                foreach ($books as $book):
                    if($book != 'success'):
                        foreach ($book as $row):
                            if($row->main_section == 32): ?>
                                <div class="col-sm-3 col-md-3">
                                    <div class="thumbnail book-body">
                                    <div class="row">
                                        <div class="col-md-8 caption">
                                            <h4><?php echo $row->book_title; ?></h4>
                                            <?php foreach ($row->sections as $sec): ?>
                                                <?php if($sec->parent_id != 0) : ?>
                                                    <b>&nbsp;<i class="fa fa-angle-double-left text-primary"></i>&nbsp;<?php echo $sec->section_name; ?></b>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                            <br>
                                            <br>
                                            <p><a href="<?php echo $row->url; ?>" class="btn btn-primary book-btn" role="button" target="_blank"><?php echo _l('view_book'); ?></a></p>
                                        </div>
                                        <div class="col-md-4">
                                            <i class="fa fa-book book-style"></i>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            <?php endif; endforeach; endif; endforeach; ?>
                <?php else: ?>
                <h4 class="text-center"><?php echo _l('smtp_encryption_none'); ?>...</h4>
                <?php endif; ?>
            </div>
        </div>
        <div class="tab-pane fade" id="tabBody2" role="tabpanel" aria-labelledby="tab2" aria-hidden="true" tabindex="0">
            <div class="row">
                <?php if(!empty($books)): ?>
                <?php
                foreach ($books as $book):
                    if($book != 'success'):
                        foreach ($book as $row):
                            if($row->main_section == 33): ?>
                                <div class="col-sm-3 col-md-3">
                                    <div class="thumbnail book-body">
                                        <div class="row">
                                        <div class="col-md-8 caption">
                                            <h4><?php echo $row->book_title; ?></h4>
                                            <?php foreach ($row->sections as $sec): ?>
                                                <?php if($sec->parent_id != 0) : ?>
                                                    <b>&nbsp;<i class="fa fa-angle-double-left text-primary"></i>&nbsp;<?php echo $sec->section_name; ?></b>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                            <br>
                                            <br>
                                            <p><a href="<?php echo $row->url; ?>" class="btn btn-primary book-btn" role="button" target="_blank"><?php echo _l('view_book'); ?></a></p>
                                        </div>
                                        <div class="col-md-4">
                                            <i class="fa fa-book book-style"></i>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            <?php endif; endforeach; endif; endforeach; ?>
                <?php else: ?>
                    <h4 class="text-center"><?php echo _l('smtp_encryption_none'); ?>...</h4>
                <?php endif; ?>
            </div>
        </div>
        <div class="tab-pane fade" id="tabBody3" role="tabpanel" aria-labelledby="tab3" aria-hidden="true" tabindex="0">
            <div class="row">
                <?php if(!empty($books)): ?>
                <?php
                foreach ($books as $book):
                    if($book != 'success'):
                        foreach ($book as $row):
                            if($row->main_section == 34): ?>
                                <div class="col-sm-3 col-md-3">
                                    <div class="thumbnail book-body">
                                        <div class="row">
                                        <div class="col-md-8 caption">
                                            <h4><?php echo $row->book_title; ?></h4>
                                            <?php foreach ($row->sections as $sec): ?>
                                                <?php if($sec->parent_id != 0) : ?>
                                                    <b>&nbsp;<i class="fa fa-angle-double-left text-primary"></i>&nbsp;<?php echo $sec->section_name; ?></b>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                            <br>
                                            <br>
                                            <p><a href="<?php echo $row->url; ?>" class="btn btn-primary book-btn" role="button" target="_blank"><?php echo _l('view_book'); ?></a></p>
                                        </div>
                                        <div class="col-md-4">
                                            <i class="fa fa-book book-style"></i>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            <?php endif; endforeach; endif; endforeach; ?>
                <?php else: ?>
                <h4 class="text-center"><?php echo _l('smtp_encryption_none'); ?>...</h4>
                <?php endif; ?>
            </div>
        </div>
        <div class="tab-pane fade" id="tabBody4" role="tabpanel" aria-labelledby="tab4" aria-hidden="true" tabindex="0">
            <div class="row">
                <?php if(!empty($books)): ?>
                    <?php
                    foreach ($books as $book):
                        if($book != 'success'):
                            foreach ($book as $row):
                                if($row->main_section == 35): ?>
                                    <div class="col-sm-3 col-md-3">
                                        <div class="thumbnail book-body">
                                            <div class="row">
                                            <div class="col-md-8 caption">
                                                <h4><?php echo $row->book_title; ?></h4>
                                                <?php foreach ($row->sections as $sec): ?>
                                                    <?php if($sec->parent_id != 0) : ?>
                                                        <b>&nbsp;<i class="fa fa-angle-double-left text-primary"></i>&nbsp;<?php echo $sec->section_name; ?></b>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                                <br>
                                                <br>
                                                <p><a href="<?php echo $row->url; ?>" class="btn btn-primary book-btn" role="button" target="_blank"><?php echo _l('view_book'); ?></a></p>
                                            </div>
                                            <div class="col-md-4">
                                                <i class="fa fa-book book-style"></i>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                <?php endif; endforeach; endif; endforeach; ?>
                <?php else: ?>
                    <h4 class="text-center"><?php echo _l('smtp_encryption_none'); ?>...</h4>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<script>
    var url = 'http://library.lawyernet.net/library/api/search';
    // var url = 'http://localhost/library/api/search'

    function getswabek() {
        $('#tabBody0').html('');
        $('#tabBody1').html('');
        $('#tabBody2').html('');
        $("#tabBody0").append('<div class="dt-loader"></div>');
        $("#tabBody1").append('<div class="dt-loader"></div>');
        $("#tabBody2").append('<div class="dt-loader"></div>');
        $.ajax({
            url: url,
            data: {
                text: '<?php echo $search?>',
                type: 13
            },
            type: "POST",
            success: function (data) {
                response = JSON.parse(data);
                $('#tabBody0').html('');
                $.each(response, function (key, value) {
                    $('#tabBody0').append(`
                        <div class="thumbnail book-body">
                            <div class="row">
                                <div class="col-md-8 caption">
                                    <a href="${value['link']}" target="_blank">
                                        <h4>${value['name']}</h4>
                                    </a>
                                </div>
                            </div>
                        </div>
                    `);
                });
               getalanzema();
            }
        });
    }

    function getalanzema() {
        $.ajax({
            url: url,
            data: {
                text: '<?php echo $search?>',
                type: 2
            },
            type: "POST",
            success: function (data) {
                response = JSON.parse(data);
                $('#tabBody1').html('');
                $.each(response, function (key, value) {
                    $('#tabBody1').append(`
                        <div class="thumbnail book-body">
                            <div class="row">
                                <div class="col-md-8 caption">
                                    <a href="${value['link']}" target="_blank">
                                        <h4>${value['name']}</h4>
                                    </a>
                                    <br>
                                   <h5>${value['title']}</h5>
                                   <br>
                                   <p>${value['description']}</p>
                                </div>
                            </div>
                        </div>
                    `);
                });
                getalmabada();
            }
        });
    }

    function getalmabada() {
        $.ajax({
            url: url,
            data: {
                text: '<?php echo $search?>',
                type: 12
            },
            type: "POST",
            success: function (data) {
                response = JSON.parse(data);
                $('#tabBody2').html('');
                $.each(response, function (key, value) {
                    $('#tabBody2').append(`
                        <div class="thumbnail book-body">
                            <div class="row">
                                <div class="col-md-8 caption">
                                    <a href="${value['link']}" target="_blank">
                                        <h4>${value['name']}</h4>
                                    </a>
                                    <br>
                                   <h5>${value['title']}</h5>
                                   <br>
                                   <p>${value['description']}</p>
                                </div>
                            </div>
                        </div>
                    `);
                });
            }
        });
    }

</script>
