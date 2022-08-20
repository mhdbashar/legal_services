<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Knowledge_base extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('knowledge_base_model');
        $this->load->helper('my_knowledge_base_helper');

    }

    /* List all knowledgebase articles */
    public function index()
    {
        if (!has_permission('knowledge_base', '', 'view')) {
            access_denied('knowledge_base');
        }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('kb_articles');
        }
        $data['groups']    = $this->knowledge_base_model->kb_main_group(1);// 1 المملكة العربية السعودية
        $data['bodyclass'] = 'top-tabs kan-ban-body';
        $data['title']     = _l('kb_string');
        $this->load->view('admin/knowledge_base/articles', $data);
//        echo '<pre>';echo print_r($data);exit();
    }

    /* Add new article or edit existing*/
    public function article($id = '')
    {
        if (!has_permission('knowledge_base', '', 'view')) {
            access_denied('knowledge_base');
        }
        if ($this->input->post()) {
            $data                = $this->input->post();

//            $data['description'] = html_purify($this->input->post('description', false));

            if ($id == '') {
                if (!has_permission('knowledge_base', '', 'create')) {
                    access_denied('knowledge_base');
                }
                $id = $this->knowledge_base_model->add_article($data);
                if ($id) {
                    set_alert('success', _l('added_successfully', _l('kb_article')));
                    redirect(admin_url('knowledge_base/article/' . $id));
                }
            } else {
                if (!has_permission('knowledge_base', '', 'edit')) {
                    access_denied('knowledge_base');
                }
                $success = $this->knowledge_base_model->update_article($data, $id);
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('kb_article')));
                }
                redirect(admin_url('knowledge_base/article/' . $id));
            }
        }
        if ($id == '') {
            $title = _l('add_new', _l('kb_article_lowercase'));
        } else {
            $article         = $this->knowledge_base_model->get($id);
            $data['article'] = $article;
            $data['fields'] = $this->knowledge_base_model->get_content($id);
            $title           = _l('edit', _l('kb_article')) . ' ' . $article->subject;
        }

        $this->app_scripts->add('tinymce-stickytoolbar',site_url('assets/plugins/tinymce-stickytoolbar/stickytoolbar.js'));

        $data['bodyclass'] = 'kb-article';
        $data['kb_base_gruop'] = kb_main_groups();
        $data['title']     = $title;
        $this->load->view('admin/knowledge_base/article', $data);
    }

    public function view($slug)
    {
        if (!has_permission('knowledge_base', '', 'view')) {
            access_denied('View Knowledge Base Article');
        }

        $data['article'] = $this->knowledge_base_model->get(false, $slug);

        if (!$data['article']) {
            show_404();
        }

        $data['related_articles'] = $this->knowledge_base_model->get_related_articles($data['article']->articleid, false);

        add_views_tracking('kb_article', $data['article']->articleid);
        $data['title'] = $data['article']->subject;
        $this->load->view('admin/knowledge_base/view', $data);
    }

    public function add_kb_answer()
    {
        // This is for did you find this answer useful
        if (($this->input->post() && $this->input->is_ajax_request())) {
            echo json_encode($this->knowledge_base_model->add_article_answer($this->input->post('articleid'), $this->input->post('answer')));
            die();
        }
    }

    /* Change article active or inactive */
    public function change_article_status($id, $status)
    {
        if (has_permission('knowledge_base', '', 'edit')) {
            if ($this->input->is_ajax_request()) {
                $this->knowledge_base_model->change_article_status($id, $status);
            }
        }
    }

    public function update_kan_ban()
    {
        if (has_permission('knowledge_base', '', 'edit')) {
            if ($this->input->post()) {
                $success = $this->knowledge_base_model->update_kan_ban($this->input->post());
                $message = '';
                if ($success) {
                    $message = _l('updated_successfully', _l('kb_article'));
                }
                echo json_encode([
                    'success' => $success,
                    'message' => $message,
                ]);
                die();
            }
        }
    }

    public function change_group_color()
    {
        if (has_permission('knowledge_base', '', 'edit')) {
            if ($this->input->post()) {
                $this->knowledge_base_model->change_group_color($this->input->post());
            }
        }
    }

    /* Delete article from database */
    public function delete_article($id)
    {
        if (!has_permission('knowledge_base', '', 'delete')) {
            access_denied('knowledge_base');
        }
        if (!$id) {
            redirect(admin_url('knowledge_base'));
        }
        $article         = $this->knowledge_base_model->get($id);
        $response = $this->knowledge_base_model->delete_article($id);
        if ($response == true) {
            if($article){
                $this->db->where(['fieldto'=>'kb_'.$article->type,'relid'=>$article->articleid]);
                $this->db->delete(db_prefix().'customfieldsvalues');
            }
            set_alert('success', _l('deleted', _l('kb_article')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('kb_article_lowercase')));
        }
        redirect(admin_url('knowledge_base'));
    }

    /* View all article groups */
    public function manage_groups()
    {
        if (!has_permission('knowledge_base', '', 'view')) {
            access_denied('knowledge_base');
        }
        $data['groups'] = $this->knowledge_base_model->get_kbg();
        $data['title']  = _l('als_kb_groups');
        $this->load->view('admin/knowledge_base/manage_groups', $data);
    }

    /* Add or edit existing article group */
    public function group($id = '')
    {
        if (!has_permission('knowledge_base', '', 'view')) {
            access_denied('knowledge_base');
        }
        if ($this->input->post()) {
            $post_data        = $this->input->post();
            $article_add_edit = isset($post_data['article_add_edit']);
            if (isset($post_data['article_add_edit'])) {
                unset($post_data['article_add_edit']);
            }
            if (!$this->input->post('id')) {
                if (!has_permission('knowledge_base', '', 'create')) {
                    access_denied('knowledge_base');
                }
                $id = $this->knowledge_base_model->add_group($post_data);
                if (!$article_add_edit && $id) {
                    set_alert('success', _l('added_successfully', _l('kb_dt_group_name')));
                } else {
                    echo json_encode([
                        'id'      => $id,
                        'success' => $id ? true : false,
                        'name'    => $post_data['name'],
                    ]);
                }
            } else {
                if (!has_permission('knowledge_base', '', 'edit')) {
                    access_denied('knowledge_base');
                }

                $id = $post_data['id'];
                unset($post_data['id']);
                $response = $this->knowledge_base_model->update_group($post_data, $id);
//                $response = $this->knowledge_base_model->delete_group($id);
                if (is_array($response) && isset($response['referenced'])) {
                    set_alert('danger', _l('is_referenced', _l('kb_dt_group_name')));
                } elseif ($response == true) {
                    set_alert('success', _l('updated_successfully', _l('kb_dt_group_name')));
                } else {
                    set_alert('warning', _l('problem_deleting', mb_strtolower(_l('kb_dt_group_name'))));
                }

//                if ($success) {
//                    set_alert('success', _l('updated_successfully', _l('kb_dt_group_name')));
//                }
            }
            die;
        }
    }

    /* Change group active or inactive */
    public function change_group_status($id, $status)
    {
        if (has_permission('knowledge_base', '', 'edit')) {
            if ($this->input->is_ajax_request()) {
                $this->knowledge_base_model->change_group_status($id, $status);
            }
        }
    }

    public function update_groups_order()
    {
        if (has_permission('knowledge_base', '', 'edit')) {
            if ($this->input->post()) {
                $this->knowledge_base_model->update_groups_order();
            }
        }
    }

    /* Delete article group */
    public function delete_group($id)
    {
        if (!has_permission('knowledge_base', '', 'delete')) {
            access_denied('knowledge_base');
        }
        if (!$id) {
            redirect(admin_url('knowledge_base/manage_groups'));
        }
        $response = $this->knowledge_base_model->delete_group($id);
        if (is_array($response) && isset($response['referenced'])) {
            set_alert('danger', _l('is_referenced', _l('kb_dt_group_name')));
        } elseif ($response == true) {
            set_alert('success', _l('deleted', _l('kb_dt_group_name')));
        } else {
            set_alert('warning', _l('problem_deleting', mb_strtolower(_l('kb_dt_group_name'))));
        }
        redirect(admin_url('knowledge_base/manage_groups'));
    }

    public function get_article_by_id_ajax($id)
    {
        if ($this->input->is_ajax_request()) {
            echo json_encode($this->knowledge_base_model->get($id));
        }
    }

    public function groups_fields()
    {
        $id = $this->input->post();
        if($id['id'] == 'nezam'){
            $out = render_custom_fields('kb_'.$id['id']);
            $out .= '<div id="fld-0" class="row">';
            $out .= render_input('title[]','','التاريخ','text',[],[],'','hide');
            $out .= render_input('description[]','التاريخ','','text',['required'=>'required']);
//            $out .= '<a onclick="'."$('#fld-0').html('')".'" class="btn btn-danger pull-left">'._l('delete_field').'</a>';
            $out .= '<div class="clearfix"></div><hr class="hr-panel-heading" /></div>';

            $out .= '<div id="fld-1" class="row">';
            $out .= render_input('title[]','','الإعتماد','text',[],[],'','hide');
            $out .= render_input('description[]','الإعتماد','','text',['required'=>'required']);
//            $out .= '<a onclick="'."$('#fld-1').html('')".'" class="btn btn-danger pull-left">'._l('delete_field').'</a>';
            $out .= '<div class="clearfix"></div><hr class="hr-panel-heading" /></div>';

            $out .= '<div id="fld-2" class="row">';
            $out .= render_input('title[]','','تاريخ النشر','text',[],[],'','hide');
            $out .= render_input('description[]','تاريخ النشر','','text',['required'=>'required']);
//            $out .= '<a onclick="'."$('#fld-2').html('')".'" class="btn btn-danger pull-left">'._l('delete_field').'</a>';
            $out .= '<div class="clearfix"></div><hr class="hr-panel-heading" /></div>';

            $out .= '<div id="fld-3" class="row">';
            $out .= render_input('title[]','','النفاذ','text',[],[],'','hide');
            $out .= render_input('description[]','النفاذ','','text',['required'=>'required']);
//            $out .= '<a onclick="'."$('#fld-3').html('')".'" class="btn btn-danger pull-left">'._l('delete_field').'</a>';
            $out .= '<div class="clearfix"></div><hr class="hr-panel-heading" /></div>';

            $out .= '<div id="fld-4" class="row">';
            $out .= render_input('title[]','','التعديلات','text',[],[],'','hide');
            $out .= render_input('description[]','التعديلات','','text',['required'=>'required']);
//            $out .= '<a onclick="'."$('#fld-4').html('')".'" class="btn btn-danger pull-left">'._l('delete_field').'</a>';
            $out .= '<div class="clearfix"></div><hr class="hr-panel-heading" /></div>';

            $out .= '<div id="fld-5" class="row">';
            $out .= render_input('title[]','','الملحقات','text',[],[],'','hide');
            $out .= render_input('description[]','الملحقات','','text',['required'=>'required']);
//            $out .= '<a onclick="'."$('#fld-5').html('')".'" class="btn btn-danger pull-left">'._l('delete_field').'</a>';
            $out .= '<div class="clearfix"></div><hr class="hr-panel-heading" /></div>';

            $out .= '<div id="fld-6" class="row">';
            $out .= render_input('title[]','title','المادة الأولى','text',['required'=>'required']);
            $out .= render_textarea('description[]','subject','',array('append_plugins'=> 'stickytoolbar', 'required'=>'required'),array('append_plugins'=> 'stickytoolbar'),'','tinymce tinymce-manual');
            $out .= '<a onclick="'."$('#fld-6').html('')".'" class="btn btn-danger pull-left">'._l('delete_field').'</a>';
            $out .= '<div class="clearfix"></div><hr class="hr-panel-heading" /></div>';
        }
        elseif ($id['id'] == 'sawabk'){
            $out = render_custom_fields('kb_'.$id['id']);
            $out .= '<div id="fld-0" class="row">';
            $out .= render_input('title[]','','رقم القضية و تاريخها (هـ)','text',[],[],'','hide');
            $out .= render_input('description[]','رقم القضية و تاريخها (هـ)','','text',['required'=>'required']);
//            $out .= '<a onclick="'."$('#fld-0').html('')".'" class="btn btn-danger pull-left">'._l('delete_field').'</a>';
            $out .= '<div class="clearfix"></div><hr class="hr-panel-heading" /></div>';

            $out .= '<div id="fld-1" class="row">';
            $out .= render_input('title[]','','رقم الصك و تاريخه','text',[],[],'','hide');
            $out .= render_input('description[]','رقم الصك و تاريخه','','text',['required'=>'required']);
//            $out .= '<a onclick="'."$('#fld-1').html('')".'" class="btn btn-danger pull-left">'._l('delete_field').'</a>';
            $out .= '<div class="clearfix"></div><hr class="hr-panel-heading" /></div>';

            $out .= '<div id="fld-2" class="row">';
            $out .= render_input('title[]','','رقم الدعوى','text',[],[],'','hide');
            $out .= render_input('description[]','رقم الدعوى','','text',['required'=>'required']);
//            $out .= '<a onclick="'."$('#fld-2').html('')".'" class="btn btn-danger pull-left">'._l('delete_field').'</a>';
            $out .= '<div class="clearfix"></div><hr class="hr-panel-heading" /></div>';

            $out .= '<div id="fld-3" class="row">';
            $out .= render_input('title[]','','صدق الحكم من الاستئناف بالقرار','text',[],[],'','hide');
            $out .= render_input('description[]','صدق الحكم من الاستئناف بالقرار','','text',['required'=>'required']);
//            $out .= '<a onclick="'."$('#fld-3').html('')".'" class="btn btn-danger pull-left">'._l('delete_field').'</a>';
            $out .= '<div class="clearfix"></div><hr class="hr-panel-heading" /></div>';

            $out .= '<div id="fld-4" class="row">';
            $out .= render_input('title[]','','رقم القضية الابتدائية','text',[],[],'','hide');
            $out .= render_input('description[]','رقم القضية الابتدائية','','text',['required'=>'required']);
//            $out .= '<a onclick="'."$('#fld-4').html('')".'" class="btn btn-danger pull-left">'._l('delete_field').'</a>';
            $out .= '<div class="clearfix"></div><hr class="hr-panel-heading" /></div>';

            $out .= '<div id="fld-5" class="row">';
            $out .= render_input('title[]','','رقم القرار العاجل','text',[],[],'','hide');
            $out .= render_input('description[]','رقم القرار العاجل','','text',['required'=>'required']);
//            $out .= '<a onclick="'."$('#fld-5').html('')".'" class="btn btn-danger pull-left">'._l('delete_field').'</a>';
            $out .= '<div class="clearfix"></div><hr class="hr-panel-heading" /></div>';

            $out .= '<div id="fld-6" class="row">';
            $out .= render_input('title[]','','رقم الحكم الابتدائي','text',[],[],'','hide');
            $out .= render_input('description[]','رقم الحكم الابتدائي','','text',['required'=>'required']);
//            $out .= '<a onclick="'."$('#fld-6').html('')".'" class="btn btn-danger pull-left">'._l('delete_field').'</a>';
            $out .= '<div class="clearfix"></div><hr class="hr-panel-heading" /></div>';

            $out .= '<div id="fld-7" class="row">';
            $out .= render_input('title[]','','رقم قضية الاستئناف','text',[],[],'','hide');
            $out .= render_input('description[]','رقم قضية الاستئناف','','text',['required'=>'required']);
//            $out .= '<a onclick="'."$('#fld-7').html('')".'" class="btn btn-danger pull-left">'._l('delete_field').'</a>';
            $out .= '<div class="clearfix"></div><hr class="hr-panel-heading" /></div>';

            $out .= '<div id="fld-8" class="row">';
            $out .= render_input('title[]','','رقم حكم الاستئناف','text',[],[],'','hide');
            $out .= render_input('description[]','رقم حكم الاستئناف','','text',['required'=>'required']);
//            $out .= '<a onclick="'."$('#fld-8').html('')".'" class="btn btn-danger pull-left">'._l('delete_field').'</a>';
            $out .= '<div class="clearfix"></div><hr class="hr-panel-heading" /></div>';

            $out .= '<div id="fld-9" class="row">';
            $out .= render_input('title[]','','تاريخ الاستئناف (هـ)','text',[],[],'','hide');
            $out .= render_input('description[]','تاريخ الاستئناف (هـ)','','text',['required'=>'required']);
//            $out .= '<a onclick="'."$('#fld-9').html('')".'" class="btn btn-danger pull-left">'._l('delete_field').'</a>';
            $out .= '<div class="clearfix"></div><hr class="hr-panel-heading" /></div>';

            $out .= '<div id="fld-10" class="row">';
            $out .= render_input('title[]','','ملخص الحكم','text',[],[],'','hide');
            $out .= render_textarea('description[]','ملخص الحكم','',array('append_plugins'=> 'stickytoolbar', 'required'=>'required'),array('append_plugins'=> 'stickytoolbar'),'','tinymce tinymce-manual');
//            $out .= '<a onclick="'."$('#fld-10').html('')".'" class="btn btn-danger pull-left">'._l('delete_field').'</a>';
            $out .= '<div class="clearfix"></div><hr class="hr-panel-heading" /></div>';

            $out .= '<div id="fld-11" class="row">';
            $out .= render_input('title[]','','نص الحكم','text',[],[],'','hide');
            $out .= render_textarea('description[]','نص الحكم','',array('append_plugins'=> 'stickytoolbar', 'required'=>'required'),array('append_plugins'=> 'stickytoolbar'),'','tinymce tinymce-manual');
//            $out .= '<a onclick="'."$('#fld-11').html('')".'" class="btn btn-danger pull-left">'._l('delete_field').'</a>';
            $out .= '<div class="clearfix"></div><hr class="hr-panel-heading" /></div>';

            $out .= '<div id="fld-12" class="row">';
            $out .= render_input('title[]','','الأسباب','text',[],[],'','hide');
            $out .= render_textarea('description[]','الأسباب','',array('append_plugins'=> 'stickytoolbar', 'required'=>'required'),array('append_plugins'=> 'stickytoolbar'),'','tinymce tinymce-manual');
//            $out .= '<a onclick="'."$('#fld-12').html('')".'" class="btn btn-danger pull-left">'._l('delete_field').'</a>';
            $out .= '<div class="clearfix"></div><hr class="hr-panel-heading" /></div>';

            $out .= '<div id="fld-13" class="row">';
            $out .= render_input('title[]','','السند الشرعي والنظامي','text',[],[],'','hide');
            $out .= render_textarea('description[]','السند الشرعي والنظامي','',array('append_plugins'=> 'stickytoolbar', 'required'=>'required'),array('append_plugins'=> 'stickytoolbar'),'','tinymce tinymce-manual');
//            $out .= '<a onclick="'."$('#fld-13').html('')".'" class="btn btn-danger pull-left">'._l('delete_field').'</a>';
            $out .= '<div class="clearfix"></div><hr class="hr-panel-heading" /></div>';

            $out .= '<div id="fld-14" class="row">';
            $out .= render_input('title[]','','قرار الاستئناف','text',[],[],'','hide');
            $out .= render_textarea('description[]','قرار الاستئناف','',array('append_plugins'=> 'stickytoolbar', 'required'=>'required'),array('append_plugins'=> 'stickytoolbar'),'','tinymce tinymce-manual');
//            $out .= '<a onclick="'."$('#fld-14').html('')".'" class="btn btn-danger pull-left">'._l('delete_field').'</a>';
            $out .= '<div class="clearfix"></div><hr class="hr-panel-heading" /></div>';

        }
        else{
            $out = '';
            $out .= render_custom_fields('kb_'.$id['id']);
        }


        echo $out;

    }
    public function test($id)
    {
        $id = kb_all_main_group($id);
        echo var_dump($id);
        exit();
    }

    public function delete_all_article_for_group_by_type($type)
    {
        $all_article = get_all_article_by_type($type);
        foreach ($all_article as $article){
            $response = $this->knowledge_base_model->delete_article($article->articleid);
            if ($response == true) {
                $this->db->where(['fieldto'=>'kb_'.$article->type,'relid'=>$article->articleid]);
                $this->db->delete(db_prefix().'customfieldsvalues');
            }
        }
    }
}
