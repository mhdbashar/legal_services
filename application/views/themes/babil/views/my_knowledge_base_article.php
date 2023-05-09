<?php defined('BASEPATH') or exit('No direct script access allowed');
$CI = &get_instance();
$CI->load->library('app_modules'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
<div class="panel_s section-knowledge-base" dir="rtl">
    <div class="panel-body">
        <div class="row kb-article">
            <div class="col-md-12<?php //if(count($related_articles) == 0){echo '12';}else{echo '8';} ?>">
                <h1 class="bold no-mtop kb-article-single-heading"><?php echo $article->subject; ?></h1>
                <small>
                    <?php echo _l('article_total_views'); ?>
                    : <?php echo total_rows(db_prefix() . 'views_tracking', array('rel_type' => 'kb_article', 'rel_id' => $article->articleid)); ?>
                </small>
                <hr class="no-mtop"/>
                <?php
                $custom_fields = get_custom_fields('kb_' . $article->type);
                if (count($custom_fields) > 0) {
                    ?>
                    <table class="table table-striped">
                        <thead>
                        </thead>
                        <tbody>

                        <?php
                        foreach ($custom_fields as $custom) {
                            if ($custom['id'] == 24 || $custom['id'] == 25 || $custom['id'] == 26 || $custom['id'] == 27 || $custom['id'] == 28)
                                continue;
                            $field = get_custom_field_value($article->articleid, $custom['id'], $custom['fieldto']);
                            ?>
                            <tr>
                                <td><?php echo $custom['name'] . ' :'; ?></td>
                                <?php if ($custom['type'] == 'date_picker') {
                                    if ($CI->app_modules->is_active('hijri')) { ?>
                                        <?php echo '<td>' . _d(to_hijri_date($field)) . 'هـ' . '    الموافق    ' . _d($field) . 'م' . '</td>'; ?>
                                    <?php } ?>
                                <?php } else { ?>
                                    <td><?php echo $field; ?></td>
                                <?php } ?>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                <?php } ?>
                <div class="mtop10 tc-content kb-article-content">
                    <?php if (isset($links)) { ?>
                        <hr class="row mright5 mtop0" style="width: 500px"/>
                        <h5>الإرتباطات</h5>
                        <?php foreach ($links as $link) {
                            ?>
                            <a target="_blank"
                               href="<?php echo site_url('knowledge-base/article/') . $link['knowledge_link_id'] ?>">
                                <?= get_knowledge_custom_field($link['ct_link_id'])->title ?> >>
                                <?= get_knowledge_article($link['knowledge_link_id'])->subject ?> >>
                                <?= kb_all_main_group_name($link['group_link_id']) ?>
                            </a>
                            <br>
                            <br>
                        <?php } ?>
                    <?php } ?>

                    <?php if (count($fields) > 0) {
                    foreach ($fields

                    as $d){
                    ?>
                    <div>
                        <h3 style="color: rgb(255 255 255);background-color: #51647c;height: 28px;padding: 4px;"
                            data-toggle="collapse" data-target="#demo<?= $d['id'] ?>">
                            <?php echo $d['title']; ?> <i style="margin-right: 8px;" class="fa fa-minus-circle"></i>

                        </h3>
                        <p id="demo<?= $d['id'] ?>" class="show"
                           data-parent="#accordion"><?php echo $d['description']; ?></p>
                        <br>
                        <button style="float: left;" class="fa fa-files-o"
                                onclick="copyElementText('demo<?= $d['id'] ?>')"
                                title="نسخ النص لهذه المادة"></button>
                        <br>
                        <?php
                        if ((count($d['links']) > 0 && has_contact_permission('knowledge_links')) || (count($d['links']) > 0 && is_staff_logged_in())) { ?>
                            <hr class="row mright5 mtop0" style="width: 500px"/>
                            <h5>الإرتباطات</h5>
                            <?php foreach ($d['links'] as $link) { ?>
                                <a target="_blank"
                                   href="<?php echo site_url('knowledge-base/article/') . $link['knowledge_link_id'] ?>">
                                    <?= get_knowledge_custom_field($link['ct_link_id'])->title ?> >>
                                    <?= get_knowledge_article($link['knowledge_link_id'])->subject ?> >>
                                    <?= kb_all_main_group_name($link['group_link_id']) ?>
                                </a>
                                <br>
                                <br>
                            <?php }
                        } ?>
                        <hr class="no-mtop"/>
                        <?php }
                        } ?>
                    </div>
                    <hr/>
                    <h4 class="mtop20"><?php echo _l('clients_knowledge_base_find_useful'); ?></h4>
                    <div class="answer_response"></div>
                    <div class="btn-group mtop15 article_useful_buttons" role="group">
                        <input type="hidden" name="articleid" value="<?php echo $article->articleid; ?>">
                        <button type="button" data-answer="1"
                                class="btn btn-success"><?php echo _l('clients_knowledge_base_find_useful_yes'); ?></button>
                        <button type="button" data-answer="0"
                                class="btn btn-danger"><?php echo _l('clients_knowledge_base_find_useful_no'); ?></button>
                    </div>
                </div>
                <?php hooks()->do_action('after_single_knowledge_base_article_customers_area', $article->articleid); ?>
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
  
  

  
  
  
  
  
  
  
  