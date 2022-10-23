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
        $data['groups'] = $this->knowledge_base_model->kb_main_group();
        $data['bodyclass'] = 'top-tabs kan-ban-body';
        $data['title'] = _l('kb_string');
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
            $data = $this->input->post();

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

            }
        }

        if ($id == '') {
            $title = _l('add_new', _l('kb_article_lowercase'));
        } else {
            $article = $this->knowledge_base_model->get($id);
            $data['article'] = $article;
            $data['fields'] = $this->knowledge_base_model->get_content($id);
            $title = _l('edit', _l('kb_article')) . ' ' . $article->subject;
        }

        $this->app_scripts->add('tinymce-stickytoolbar', site_url('assets/plugins/tinymce-stickytoolbar/stickytoolbar.js'));

        $data['bodyclass'] = 'kb-article';
        $data['kb_base_gruop'] = kb_main_groups();
        $data['title'] = $title;
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
        $article = $this->knowledge_base_model->get($id);
        $response = $this->knowledge_base_model->delete_article($id);
        if ($response == true) {
            if ($article) {
                $this->db->where(['fieldto' => 'kb_' . $article->type, 'relid' => $article->articleid]);
                $this->db->delete(db_prefix() . 'customfieldsvalues');
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
        if(is_staff_from_legalservices(get_staff_user_id())){
            redirect(admin_url('knowledge_base'));
        }
        $data['groups'] = $this->knowledge_base_model->get_kbg();
        $data['title'] = _l('als_kb_groups');
        $this->load->view('admin/knowledge_base/manage_groups', $data);
    }

    /* Add or edit existing article group */
    public function group($id = '')
    {
        if (!has_permission('knowledge_base', '', 'view')) {
            access_denied('knowledge_base');
        }
        if ($this->input->post()) {
            $post_data = $this->input->post();
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
                        'id' => $id,
                        'success' => $id ? true : false,
                        'name' => $post_data['name'],
                    ]);
                }
            } else {
                if (!has_permission('knowledge_base', '', 'edit')) {
                    access_denied('knowledge_base');
                }
                $id = $post_data['id'];
                unset($post_data['id']);
                $response = $this->knowledge_base_model->update_group($post_data, $id);
                if (is_array($response) && isset($response['referenced'])) {
                    set_alert('danger', _l('is_referenced', _l('kb_dt_group_name')));
                } elseif ($response == true) {
                    set_alert('success', _l('updated_successfully', _l('kb_dt_group_name')));
                } else {
                    set_alert('warning', _l('problem_deleting', mb_strtolower(_l('kb_dt_group_name'))));
                }
            }
            $this->update_all_main_group_id();
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
        $out = render_custom_fields('kb_' . $id['id']);
        echo $out;
    }


    public function delete_all_article_for_group_by_type($type)
    {
        $all_article = get_all_article_by_type($type);
        foreach ($all_article as $article) {
            $response = $this->knowledge_base_model->delete_article($article->articleid);
            if ($response == true) {
                $this->db->where(['fieldto' => 'kb_' . $article->type, 'relid' => $article->articleid]);
                $this->db->delete(db_prefix() . 'customfieldsvalues');
            }
        }
    }

    public function kb_activity()
    {
        if (!has_permission('knowledge_base', '', 'view')) {
            access_denied('knowledge_base');
        }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('knowlege_activity');
        }
        $this->load->view('admin/knowledge_base/kb_activity');
    }

    public function update_all_main_group_id(){
        $groups = get_kb_groups();
        foreach ($groups as $group){
            if($group['parent_id'] == 0) {
                $this->db->where('groupid', $group['groupid']);
                $this->db->update(db_prefix() . 'knowledge_base_groups', ['main_group_id'=>$group['groupid']]);
                continue;
            }
            if($group['is_main'] == 1) {
                $this->db->where('groupid', $group['groupid']);
                $this->db->update(db_prefix() . 'knowledge_base_groups', ['main_group_id'=>$group['parent_id']]);
                continue;
            }
            $parent_id = $group['parent_id'];
            for ($i = 0; $i < 11; $i++) {
                $this->db->where('groupid', $parent_id);
                $main_group = $this->db->get(db_prefix() . 'knowledge_base_groups')->row();
                if($main_group) {
                    if($main_group->is_main==1) {
                        $this->db->where('groupid', $group['groupid']);
                        $this->db->update(db_prefix() . 'knowledge_base_groups', ['main_group_id'=>$main_group->groupid]);
                        break;
                    }
                    $parent_id = $main_group->parent_id;
                }else{
                    break;
                }
            }
        }
    }

    public function get_kb_all_childe_group_ajax()
    {
        $group_id = $this->input->post('id');
        $groups = kb_all_childe_group($group_id);
        foreach ($groups as $key => $group) {
            $groups[$key]['full_name'] = kb_all_main_group_name($group['groupid']);
        }
        echo json_encode($groups);
    }

}
