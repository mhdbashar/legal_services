<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="jumbotron kb-search-jumbotron">
    <div class="kb-search">
        <div class="container">
            <!--            <a href="--><?php //echo site_url('Knowledge_base/advance_search')?><!--">-->
            <!--            <button class="btn btn-success"><h4>-->
            <?php //echo _l('البحث المتقدم'); ?><!--</h4></button>-->
            <!--            </a>-->
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="text-center">
                        <h2 class="mbot30 bold kb-search-heading"><?php echo _l('kb_search_articles'); ?></h2>
                        <!--                        --><?php //echo form_open(site_url('knowledge-base/search'),array('method'=>'GET','id'=>'kb-search-form')); ?>
                        <!--                        <div class="form-group has-feedback has-feedback-left">-->
                        <!--                            <div class="input-group">-->
                        <!--                                <input type="search" name="q" placeholder="-->
                        <?php //echo _l('have_a_question'); ?><!--" class="form-control kb-search-input" value="-->
                        <?php //echo $this->input->get('q'); ?><!--">-->
                        <!--                                <span class="input-group-btn">-->
                        <!--                                <button type="submit" class="btn btn-success kb-search-button">-->
                        <?php //echo _l('kb_search'); ?><!--</button>-->
                        <!--                            </span>-->
                        <!--                                <i class="glyphicon glyphicon-search form-control-feedback kb-search-icon"></i>-->
                        <!--                            </div>-->
                        <!--                        </div>-->
                        <!--                        --><?php //echo form_close(); ?>

                        <div class="form-group has-feedback has-feedback-left">
                            <div class="input-group">
                                <input type="search" id="text" name="text"
                                       placeholder="<?php echo _l('have_a_question'); ?>"
                                       class="form-control kb-search-input"
                                       value="">
                                <span class="input-group-btn">
                                        <button type="submit" onclick="search()"
                                                class="btn btn-success kb-search-button"><?php echo _l('kb_search'); ?></button>
                                    </span>
                                <i class="glyphicon glyphicon-search form-control-feedback kb-search-icon"></i>
                            </div>
                        </div>
                        <button
                                class="btn btn-success kb-search-button" data-toggle="collapse" data-target="#filters"
                        ><?php echo _l('filters'); ?></button>

                    </div>

                    <div id="filters" class="hide"
                         data-parent="#accordion">
                        <?php $groups = kb_main_groups();
                        foreach ($groups as $group) {
                            ?>
                            <div class="checkbox">
                                <input type="checkbox" value="<?= $group->groupid ?>"
                                       name="filters[<?= $group->groupid ?>]">
                                <label for="cf_events"><?= $group->name ?></label>
                            </div>
                        <?php } ?>

                    </div>
                </div>
                <div id="search" class="col-md-12 kb-search-results"></div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>

<script>
    $(function () {

        // $("input[name='filters[]']").on('change', function () {
        //     var type = [];
        //     $('#filters :checkbox:checked').each(function (i) {
        //         type[i] = $(this).val();
        //     });
        // });
    });

    function search() {
        $('#search').html('');

        var non = '<h4 class="text-center"><?php echo _l("smtp_encryption_none"); ?>...</h4>';
        var url = 'https://library.lawyernet.net/api_lib/search1';
        var search = $('#text').val();
        var type = [];
        $('#filters :checkbox:checked').each(function (i) {
            type[i] = $(this).val();
        });
        $('#search').append(`
                    <h2 id="search_result"><?php echo _l('showing_search_result'); ?> ${search}</h2>
                    <hr /><div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
                        <ul class="list-unstyled articles_list">
                 `);
        if (type.length > 0) {
            $('#filters :checkbox:checked').each(function (i) {
                $.ajax({
                    url: url,
                    data: {
                        text: search,
                        type: $(this).val()
                    },
                    type: "POST",
                    time: 300,
                    success: function (data) {
                        response = JSON.parse(data);
                        if (response != 0) {
                            $.each(response, function (key, value) {
                                $('#search').append(`
                        <div class="col-md-4 article-box">
                            <div class="text-center pt-3 card">
                                <img alt="category" src="<?php echo base_url() ?>assets/images/book.png" width="150"
                                     height="150"><br>
                                <div style="color:#093a64;font-weight: 900;font-size:13px;">
                                    <a href="${value['link']}">${value['name']}
                                    </a></div>
                            </div>
                        </div>
                                `);
                            });
                        }
                    }
                });
            });
        } else {
            $('#filters :checkbox').each(function (i) {
                $.ajax({
                    url: url,
                    data: {
                        text: search,
                        type: $(this).val()
                    },
                    type: "POST",
                    time: 300,
                    success: function (data) {
                        response = JSON.parse(data);
                        $.each(response, function (key, value) {
                            $('#search').append(`
                        <div class="col-md-4 article-box">
                            <div class="text-center pt-3 card">
                                <img alt="category" src="<?php echo base_url() ?>assets/images/book.png" width="150"
                                     height="150"><br>
                                <div style="color:#093a64;font-weight: 900;font-size:13px;">
                                    <a href="${value['link']}">${value['name']}
                                    </a></div>
                            </div>
                        </div>
                        `);
                        });
                    }
                });
            });
        }
        $('#search').append(`
        </ul></div></div></div>
                 `);
    }
</script>