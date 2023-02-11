<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php if ($project->settings->view_session_logs == 1 && $project->settings->edit_sessions == 1) : ?>
    <div class="row">
    <h2 class="no-mtop" id="session-edit-heading"><?php echo $session->name; ?></h2>
    <hr/>
    <div class="col-md-12 mtop10">
        <?php echo form_open_multipart('', array('id' => 'session-form')); ?>
        <?php echo form_hidden('action', 'edit_session'); ?>
        <?php echo form_hidden('session_id', $session->id); ?>
        <div class="checkbox checkbox-primary checkbox-inline task-add-edit-billable mbot20">
            <input type="checkbox" id="task_is_billable" name="billable" <?php if ($session->billable == 1) {
                echo 'checked';
            } ?> >
            <label for="task_is_billable"><?php echo _l('task_billable'); ?></label>
        </div>
        <div class="row">
            <div class="col-md-6">
                <?php
                $value = isset($session->session_number) ? $session->session_number : ''; ?>
                <?php echo render_input('session_number', 'session_number', $value, 'number'); ?>
            </div>
            <div class="col-md-6">
                <?php $value = (isset($session) ? $session->judicial_office_number : ''); ?>
                <?php echo render_input('judicial_office_number', 'judicial_office_number', $value, 'number'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <?php echo render_input('name', 'task_add_edit_subject', isset($session) ? $session->name : ''); ?>
            </div>
            <div class="col-md-6">
                <label for="session_type" class="control-label"><?php echo _l('session_type'); ?></label>
                <select name="session_type" class="selectpicker" id="session_type" data-width="100%"
                        data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                    <option value=""></option>
                    <?php $value = (isset($session) ? $session->session_type : ''); ?>
                    <option value="جلسة قضائية" <?php echo $value == 'جلسة قضائية' ? 'selected' : ''; ?>>جلسة
                        قضائية
                    </option>
                    <option value="جلسة خبراء" <?php echo $value == 'جلسة خبراء' ? 'selected' : ''; ?>>جلسة
                        خبراء
                    </option>
                    <option value="جلسة الحكم" <?php echo $value == 'جلسة الحكم' ? 'selected' : ''; ?>>جلسة
                        الحكم
                    </option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <?php echo render_date_input('startdate', 'session_date', isset($session) ? $session->startdate : ''); ?>
            </div>
            <div class="col-md-6">
                <label for="time" class="col-form-label"><?php echo _l('session_time'); ?></label>
                <input type="<?php echo (get_option('time_format') == 24) ? 'text' : 'time' ?>"
                       class="form-control" value="<?php echo isset($session) ? $session->time : ''; ?>" id="time"
                       name="time"
                       autocomplete="off">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="court_id" class="control-label"><?php echo _l('Court'); ?></label>
                    <select name="court_id" onchange="GetCourtJad()" class="selectpicker" id="court_id"
                            data-width="100%"
                            data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                        <?php if (isset($courts)) { ?>
                            <option value="<?php echo $default_courts ?>"></option>
                            <?php foreach ($courts as $court) { ?>
                                <option value="<?php echo $court['c_id'] ?>"><?php echo $court['court_name'] ?></option>
                            <?php }
                        } else { ?>
                            <option value="<?php echo $session->court_id ?>"></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-md-6" id="dept">
                <div class="form-group">
                    <label class="control-label"><?php echo _l('NumJudicialDept'); ?></label>
                    <select class="form-control custom_select_arrow" aria-invalid="false" name="dept"
                            placeholder="<?php echo _l('dropdown_non_selected_tex'); ?>">
                        <option selected disabled></option>
                        <?php $data = (isset($session) ? get_relation_data('myjudicial', $session->court_id) : array());
                        foreach ($data as $row) {
                            if ($session->dept == $row->j_id) { ?>
                                <option value="<?php echo $row->j_id ?>"
                                        selected><?php echo $row->Jud_number ?></option>
                            <?php }
                        } ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="cat_id" class="control-label"><?php echo _l('Categories'); ?></label>
                    <select class="form-control custom_select_arrow" id="cat_id" onchange="GetSubCat()"
                            name="cat_id"
                            placeholder="<?php echo _l('dropdown_non_selected_tex'); ?>">
                        <option selected disabled></option>
                        <?php if (isset($cats)) {
                            foreach ($cats as $row) { ?>
                                <option value="<?php echo $row->id; ?>" <?php echo $session->cat_id == $row->id ? 'selected' : ''; ?> ><?php echo $row->name; ?></option>
                            <?php }
                        } ?>
                    </select>
                </div>
            </div>
            <?php ?>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="subcat_id"
                           class="control-label"><?php echo _l('SubCategories'); ?></label>
                    <select class="form-control custom_select_arrow" id="subcat_id" name="subcat_id"
                            placeholder="<?php echo _l('dropdown_non_selected_tex'); ?>">
                        <option selected disabled></option>
                        <?php if (isset($subcats)) {
                            foreach ($subcats as $row) { ?>
                                <option value="<?php echo $row->id; ?>" <?php echo $session->subcat_id == $row->id ? 'selected' : '' ?>><?php echo $row->name; ?></option>
                            <?php }
                        } ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div id="childsubcat"></div>
            <div class="col-md-6">
                <?php echo render_input('file_number_court', 'file_number_in_court', isset($session->file_number_court) ? $session->file_number_court : '', 'number'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="judge_id" class="control-label"><?php echo _l('judge'); ?></label>
                    <select name="judge_id" class="selectpicker" id="judge_id" data-width="100%"
                            data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                        <option value=""></option>
                        <?php foreach ($judges as $judge) { ?>
                            <option value="<?php echo $judge['id'] ?>" <?php echo $session->dept ? 'selected' : ''; ?>><?php echo $judge['name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="task-hours <?php if (isset($session) && $session->rel_type == 'project' && total_rows(db_prefix() . 'projects', array('id' => $session->rel_id, 'billing_type' => 3)) == 0) {
                    echo '';
                } ?>">
                    <?php $value = (isset($session) ? $session->hourly_rate : 0); ?>
                    <?php echo render_input('hourly_rate', 'task_hourly_rate', $value); ?>
                </div>
            </div>
        </div>
        <div class="row">
            <?php if ($project->settings->view_team_members == 1) { ?>
                <div class="col-md-6  form-group ">
                    <label for="assignees"><?php echo _l('session_single_assignees_select_title'); ?></label>
                    <select class="selectpicker" multiple="true" name="assignees[]" id="assignees" data-width="100%"
                            data-live-search="true">
                        <?php foreach ($members as $member) { ?>
                            <option value="<?php echo $member['staff_id']; ?>" <?php if ($this->sessions_model->is_task_assignee($member['staff_id'], $session->id)) {
                                echo ' selected';
                            } ?>><?php echo get_staff_full_name($member['staff_id']); ?></option>
                        <?php } ?>
                    </select>
                </div>
            <?php } ?>
        </div>
        <div class="row">
            <div class="col-md-6">
                <?php echo render_input('session_link', 'session_link', isset($session) ? $session->session_link : '', 'link'); ?>
            </div>
            <div class="col-md-6">
                <label for="tags" class="control-label"><i class="fa fa-tag"
                                                           aria-hidden="true"></i> <?php echo _l('tags'); ?></label>
                <div class="tags-container">
                    <div class="tag-container ">
                        <input type="text" id="tags" placeholder="<?php echo _l('tag'); ?>"
                               value="<?php echo(isset($session) ? prep_tags_input(get_tags_in($session->id, 'task')) : ''); ?>"
                        >
                    </div>
                    <input type="text" class="hide" id="send-tags" name="tags">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-12">
                <label for="session_information"><?php echo _l('session_info'); ?></label>
                <textarea name="session_information" id="session_information" rows="10"
                          placeholder="<?php echo _l('session_info'); ?>"
                          class="form-control"><?php echo clear_textarea_breaks($session->description); ?></textarea>
            </div>
        </div>
        <?php echo render_custom_fields('sessions', $session->id, array('show_on_client_portal' => 1)); ?>
        <button type="submit" id="submit" class="btn btn-info pull-right"><?php echo _l('submit'); ?></button>
        <?php echo form_close(); ?>
    </div>
    <script>

        const tagContainer = document.querySelector('.tag-container');
        const input = document.querySelector('.tag-container input');
        let sendTags = "<?php echo(isset($session) ? prep_tags_input(get_tags_in($session->id, 'task')) : ''); ?>";
        var tags = [];

        function createTag(label) {
            const div = document.createElement('div');
            div.setAttribute('class', 'tag-input');
            div.style.cssText = 'cursor: default;padding: 5px;border: 1px solid #ccc;margin: 5px;display: flex;align-items: center;border-radius: 3px;background: #f2f2f2;';

            const span = document.createElement('span');
            span.innerHTML = label;

            const closeBtn = document.createElement('i');
            closeBtn.setAttribute('class', 'close-icon fa fa-close');
            closeBtn.style.cssText = 'font-size: 10px;margin-left: 5px; <?php  if (is_rtl(true)) {
                echo 'position: relative; right: 5px';
            } ?> ';
            closeBtn.setAttribute('data-item', label);

            div.appendChild(span);
            div.appendChild(closeBtn);

            return div;
        }


        function reset() {
            document.querySelectorAll('.tag-input').forEach(function (tag) {
                tag.parentElement.removeChild(tag);
            })

            document.getElementById('send-tags').value = '';
        }

        function addTags() {
            reset();
            tags.slice().reverse().forEach(function (tag) {
                const input = createTag(tag);
                tagContainer.prepend(input);
            })

            document.getElementById('send-tags').value = tags + ',';
        }

        if (typeof sendTags !== 'undefined') {
            tags = [...sendTags.split(",")];
            document.getElementById('send-tags').value = tags + ',';
            tags.slice().reverse().forEach(function (tag) {
                const input = createTag(tag);
                tagContainer.prepend(input);
            });
        }

        input.addEventListener('keyup', function (e) {
            if (e.key == 'Enter') {
                for (let i = 0; i < tags.length; i++) {
                    if (input.value == tags[i] || input.value == '') {
                        return false;
                    }
                }

                tags.push(input.value);
                addTags();
                input.value = '';
            }
        })

        document.addEventListener('click', function (e) {
            if (e.target.tagName == 'I') {
                const value = e.target.getAttribute('data-item');
                const index = tags.indexOf(value);

                tags = [...tags.slice(0, index), ...tags.slice(index + 1)];
                addTags();
            }
        })

        function GetCourtJad() {
            $('#dept').html('');
            id = $('#court_id').val();
            $.ajax({
                url: '<?php echo base_url("judicialByCourt/"); ?>' + id,
                success: function (data) {
                    $('#dept').html(data)
                }
            });
        }

        $(document).ready(function () {

            $(window).keydown(function (event) {
                if (event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });

            <?php if(get_option('time_format') == 24) {?>
            $('#time').datetimepicker({
                datepicker: false,
                format: 'H:i'
            });
            <?php } ?>

            //hide task-hours when change state task_billable by baraa
            $('#task_is_billable').change(function () {
                if (this.checked == true) {
                    $(".task-hours").show();
                } else {
                    $(".task-hours").hide();
                    ;
                }
            });

            $('#session-edit-heading').css({
                /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#226faa+0,2989d8+37,72c0d3+100 */
                'background': '#226faa',
                /* Old browsers */
                /* FF3.6-15 */
                /* Chrome10-25,Safari5.1-6 */
                'background': '-webkit-gradient(linear, left top, right top, from(#226faa), color-stop(37%, #2989d8), to(#72c0d3))',
                'background': 'linear-gradient(to right, #226faa 0%, #2989d8 37%, #72c0d3 100%)',
                /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
                'filter': 'progid:DXImageTransform.Microsoft.gradient(startColorstr="#226faa", endColorstr="#72c0d3", GradientType=1)',
                /* IE6-9 */
                'border-radius': '6px',
                'color': '#fff',
                'padding': '18px',
                'border-bottom-left-radius': '0',
                'border-bottom-right-radius': '0',
                'border-color': 'transparent',
                'position': 'relative',
                'top': '23px'

            });

            <?php if (is_rtl(true))
            { ?>
            $('#session-edit-heading').css({
                'background': 'linear-gradient(to left, #226faa 0%, #2989d8 37%, #72c0d3 100%)',
            })
            <?php  } ?>

            $('.tag-container').css({
                'padding': '10px',
                'padding-top': '0',
                'border-radius': '5px',
                'display': 'flex',
                'flex-direction': 'row',
                'flex-wrap': 'wrap'
            });

            $('input#tags').css({
                'flex': '1',
                'font-size': '16px',
                'padding': '5px',
                'outline': 'none',
                'border': '0',
                'border-left': '1.5px dashed #999',
            });

            <?php if (is_rtl(true))
            { ?>
            $('input#tags').css({
                'border-left': 'unset',
                'border-right': '1.5px dashed #999',
            })
            <?php  } ?>

            appValidateForm($('#session-form'), {
                name: 'required',
                startdate: 'required',
                time: 'required',
            });
        })

    </script>
<?php else :
    redirect(site_url() . 'clients/legal_services/' . $rel_id . '/' . $ServID);
endif; ?>