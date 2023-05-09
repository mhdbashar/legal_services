<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Knowledge_base extends ClientsController
{
    public function __construct()
    {
        parent::__construct();

        if (is_staff_logged_in() && get_option('use_knowledge_base') == 0) {
            set_alert('warning', 'Knowledge base is disabled, navigate to Setup->Settings->Customers and set Use Knowledge Base to YES.');
        }

        hooks()->do_action('customers_area_knowledge_base_construct');
        $this->load->model('knowledge_base_model');
        $this->load->helper('my_knowledge_base_helper');
        $this->load->model('api_lib/Api_model', 'api_model');

    }

    public function index($slug = '')
    {
        $this->checkKnowledgeBaseAccess();
        $data['articles'] = get_all_knowledge_base_articles_grouped(true);
        $data['main_groups'] = get_kb_main_groups();
        $data['knowledge_base_search'] = true;
        $data['title'] = _l('clients_knowledge_base');
        $this->view('knowledge_base');
        $this->data($data);
        $this->layout();
    }

    private function checkKnowledgeBaseAccess()
    {
        if (get_option('use_knowledge_base') == 1 && !is_client_logged_in() && get_option('knowledge_base_without_registration') == 0) {
            if (is_client_logged_in() || is_staff_logged_in()) {
//                set_alert(
//                    'warning',
//                    'Knowledge base is available only for logged in contacts, you are accessing this page as staff member only for preview.'
//                );
            } else {
                // Knowedge base viewable only for registered customers
                // Redirect to login page so they can login to view
                redirect_after_login_to_current_url();
                redirect(site_url('authentication/login'));
            }
        } elseif (!is_knowledge_base_viewable()) {
            show_404();
        }
    }

    public function advance_search()
    {
        $this->checkKnowledgeBaseAccess();
        $data['country'] = get_kb_main_groups();
        $this->view('advance_search');
        $this->data($data);
        $this->layout();
    }

    public function search()
    {
//        $this->checkKnowledgeBaseAccess();

        $q = $this->input->get('q');

        $data['articles'] = get_all_knowledge_base_articles_grouped(true, [], $q);
        $data['search_results'] = true;
        $data['title'] = _l('showing_search_result', $q);
//        $data['knowledge_base_search'] = true;
        $this->view('knowledge_base');
        $this->data($data);
        $this->layout();
    }

    public function article($id)
    {
        $this->checkKnowledgeBaseAccess();

        $data['article'] = $this->knowledge_base_model->get($id);

        if (!$id) {
            redirect(site_url('knowledge-base'));
        }

        if (!$data['article'] || $data['article']->active_article == 0) {
            show_404();
        }

//        $data['knowledge_base_search'] = true;
//        $data['related_articles'] = $this->knowledge_base_model->get_related_articles($data['article']->articleid);
        add_views_tracking('kb_article', $data['article']->articleid);
        $data['title'] = $data['article']->subject;
        $data['fields'] = $this->knowledge_base_model->get_content($id);
//        if ($data['article']->type == 13) {
//            $data['links'] = $this->knowledge_base_model->get_links($id);
//        }
        $this->view('knowledge_base_article');
        $this->data($data);
        $this->layout();
    }

    public function category($id)
    {
        $this->checkKnowledgeBaseAccess();

        $where_kb = 'articlegroup IN (SELECT groupid FROM ' . db_prefix() . 'knowledge_base_groups WHERE groupid="' . $id . '")';
        $data['category'] = kb_group_name($id);
        $data['articles'] = get_all_knowledge_base_articles_grouped(true, $where_kb);
        $data['childe_groups'] = kb_childe_group($id);
        $data['title'] = count($data['articles']) == 1 ? $data['articles'][0]['name'] : _l('clients_knowledge_base');
        $data['knowledge_base_search'] = true;
        $this->data($data);
        $this->view('knowledge_base');
        $this->layout();
    }

    public function add_kb_answer()
    {
        if (!is_knowledge_base_viewable()) {
            show_404();
        }
        // This is for did you find this answer useful
        if (($this->input->post() && $this->input->is_ajax_request())) {
            echo json_encode($this->knowledge_base_model->add_article_answer($this->input->post('articleid'), $this->input->post('answer')));
            die();
        }
    }

    public function get_custom_fields_ajax($id)
    {
        $custom_fields = get_custom_fields('kb_' . $id);
        echo json_encode($custom_fields);
    }


    public function get_main_group_ajax($id)
    {
        $main_group = kb_childe_group($id);
        echo json_encode($main_group);
    }


    public function get_articles_ajax($id)
    {
        $articles = get_all_article_by_type($id);
        echo json_encode($articles);
    }


    public function get_all_group_ajax()
    {
        $all_group = knowledge_all_groups();
        echo json_encode($all_group);
    }


    public function get_search_results_ajax()
    {
        $type = $this->input->post('type');
        $custom_id = $this->input->post('custom_id');
        $text = $this->input->post('text');
        $text = explode(' ', $text);
        $all_id = [];
        if ($custom_id == 0) {
            foreach ($text as $item) {
                $data = $this->api_model->search_like_content($item, $type);
                foreach ($data as $key => $val) {
                    $all_id[] = $val['id'];
                }
            }
            $values = array_count_values($all_id);
            arsort($values);
            $popular = array_slice(array_keys($values), 0, 30, true);
            $article = [];
            $i = 0;
            foreach ($popular as $id) {
                $article[$i]['link'] = site_url('knowledge-base/article/' . $id);
                $article[$i]['name'] = $this->knowledge_base_model->get($id)->subject;
                $custom = $this->api_model->get_knowledge_custom_fields($id);
                $article[$i]['title'] = $custom->title;
                $article[$i]['description'] = $custom->description;
                $i++;
            }
            echo json_encode($article);
            die();
        } elseif ($custom_id != 0) {
            foreach ($text as $item) {
                $data = $this->api_model->search_like_custom_fields_values($item, $type, $custom_id);
                foreach ($data as $key => $val) {
                    $all_id[] = $val['id'];
                }
            }
            $values = array_count_values($all_id);
            arsort($values);
            $popular = array_slice(array_keys($values), 0, 30, true);
            $article = [];
            $i = 0;
            foreach ($popular as $id) {
                $custom_value = $this->api_model->get_custom_fields_values($id);
                $article[$i]['link'] = site_url('knowledge-base/article/' . $custom_value->relid);
                $article[$i]['name'] = $this->knowledge_base_model->get($custom_value->relid)->subject;
                $article[$i]['title'] = $this->api_model->get_custom_fields($custom_value->fieldid)->name;
                $article[$i]['description'] = $custom_value->value;
                $i++;
            }
            echo json_encode($article);
            die();
        }

    }


    public function advance_searched($no)
    {
        $data = $this->input->post();
        $country = $data["country"];
        $main_group = $data["main_group"];
        $search_text = $data["search_text"];
//        $search_text = trim($search_text);
        unset($data["country"], $data["main_group"], $data["search_text"]);
        $all_id = [];
        $article = [];
//        echo '<pre>';
//        echo var_dump($search_text);
        if ($country == 1) {
            if ($main_group == 2 || $main_group == 13 || $main_group == 19) {
                foreach ($data as $fieldid => $value) {
                    if ($value != "") {

                    } else
                        unset($data[$fieldid]);
                }
                foreach ($data as $fieldid => $value) {
                    $knowlege = $this->api_model->search_custom_fields_values($fieldid, $main_group, $value);
                    foreach ($knowlege as $val) {
//                            $all_id[] = $val;
                        $all_id[] = $val->id;
                    }
                    break;
                }
                $allknowlege = $all_id;
                $all_id = [];
                foreach ($allknowlege as $relid) {
                    foreach ($data as $fieldid => $value) {
                        $knowlege = $this->api_model->search_custom_fields_values_by_relid($relid, $fieldid, $main_group, $value);
                        foreach ($knowlege as $val) {
//                            $all_id[] = $val;
                            $all_id[] = $val->id;
                        }
                    }
                }
//                echo var_dump($all_id);
                if (strlen($search_text) > 0) {
                    $values = array_count_values($all_id);
                    arsort($values);
                    $popular = array_slice(array_keys($values), 0, -1, true);
                    $texts = explode(' ', $search_text);
                    $all_id = [];
                    foreach ($popular as $knowledge_id) {
                        foreach ($texts as $text) {
                            $knowlege = $this->api_model->search_like_content_by_knowledge_id($knowledge_id, $main_group, $text);
                            foreach ($knowlege as $val) {
                                $all_id[] = $val;
                            }
                        }
                    }
                    $values = array_count_values($all_id);
                    arsort($values);
                    $popular = array_slice(array_keys($values), 0, 50, true);
                    $i = 0;
                    foreach ($popular as $custom_id) {
                        $custom = $this->api_model->get_knowledge_custom_fields($custom_id);
                        $article[$i]['link'] = site_url('knowledge-base/article/' . $custom->knowledge_id);
                        $article[$i]['name'] = $this->knowledge_base_model->get($custom->knowledge_id)->subject;
                        $article[$i]['title'] = $custom->title;
                        $article[$i]['description'] = $custom->description;
                        $i++;
                    }

                } else {
                    $values = array_count_values($all_id);
                    arsort($values);
                    $popular = array_slice(array_keys($values), 0, 50, true);
                    $i = 0;
                    foreach ($popular as $knowledge_id) {
                        $article[$i]['link'] = site_url('knowledge-base/article/' . $knowledge_id);
                        $article[$i]['name'] = $this->knowledge_base_model->get($knowledge_id)->subject;
                        $article[$i]['title'] = '';
                        $article[$i]['description'] = '';
                        $i++;
                    }
                }
//            } elseif ($main_group == 3) {


            } else {
                if (strlen($search_text) > 0) {
                    $texts = explode(' ', $search_text);
                    foreach ($texts as $item) {
                        if ($item == '' || $item == ' ')
                            continue;
                        $data = $this->api_model->search_like_description1($item, $main_group);
                        foreach ($data as $val) {
                            $all_id[] = $val;
                        }
                    }
                    $values = array_count_values($all_id);
                    arsort($values);
                    $popular = array_slice(array_keys($values), 0, 30, true);

                    //get link articles
                    $i = 0;
                    foreach ($popular as $id) {
                        $custom = $this->api_model->get_knowledge_custom_fields($id);
                        $article[$i]['link'] = site_url('knowledge-base/article/' . $custom->knowledge_id);
                        $article[$i]['name'] = $this->knowledge_base_model->get($custom->knowledge_id)->subject;
                        $article[$i]['title'] = $custom->title;
                        $article[$i]['description'] = $custom->description;
                        $i++;
                    }
                }
            }

        }
//        $this->checkKnowledgeBaseAccess();
        $data['result'] = $article;
        $this->view('advance_search_result');
        $this->data($data);
        $this->layout();

//        echo '<pre>';
//        echo var_dump($article);

    }

}
