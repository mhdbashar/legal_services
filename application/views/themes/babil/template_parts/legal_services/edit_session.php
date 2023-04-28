<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php if ($project->settings->view_session_logs == 1 && $project->settings->edit_sessions == 1) : ?>
    <div class="col-md-12">
    <h2 class="no-mtop" id="session-edit-heading"><?php echo $session->name; ?></h2>
    <hr/>
    <div class="col-md-12">
        <?php echo form_open_multipart('', array('id' => 'session-form')); ?>
        <?php echo form_hidden('action', 'edit_session'); ?>
        <?php echo form_hidden('session_id', $session->id); ?>
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
            <div class="col-md-12">
                <?php echo render_input('session_link', 'session_link', isset($session) ? $session->session_link : '', 'link'); ?>
            </div>
        </div>
        </hr>
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