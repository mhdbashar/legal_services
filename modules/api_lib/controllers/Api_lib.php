<?php

defined('BASEPATH') or exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class Api_lib extends ClientsController
{
    public function __construct()
    {
        parent::__construct();
        hooks()->do_action('customers_area_knowledge_base_construct');
        $this->load->helper('my_knowledge_base_helper');
        $this->load->model('knowledge_base_model');
        $this->load->model('api_model');
    }

//    public function copy_type(){
//        $text  = $this->api_model->copy();
//        echo $text;exit();
//    }
    public function article($id)
    {

        $data['article'] = $this->knowledge_base_model->get($id);

        if (!$id) {
            redirect(site_url('knowledge-base'));
        }

        if (!$data['article'] || $data['article']->active_article == 0) {
            show_404();
        }

        $data['knowledge_base_search'] = true;
        $data['related_articles'] = $this->knowledge_base_model->get_related_articles($data['article']->articleid);
        add_views_tracking('kb_article', $data['article']->articleid);
        $data['title'] = $data['article']->subject;
        $data['fields'] = $this->knowledge_base_model->get_content($id);
//        $this->view('knowledge_base_article');
//        $this->data($data);
//        $this->layout();
        return $data;
    }

    public function search()
    {
        $text = $this->input->post('text');
        $type = $this->input->post('type');
        $text = explode(' ', $text);
        $all_id = [];
        if ($type == 13) {
            foreach ($text as $item) {
                if ($item == '' || $item == ' ')
                    continue;
                $data = $this->api_model->search_like_content($item, $type);
                foreach ($data as $key => $val) {
                    $all_id[] = $val['id'];
                }
            }
            $values = array_count_values($all_id);
            arsort($values);
            $popular = array_slice(array_keys($values), 0, 30, true);

            //get link articles
            $article = [];
            $i = 0;
            foreach ($popular as $id) {
//                $custom = $this->api_model->get_knowledge_custom_fields($id);
                $article[$i]['link'] = site_url('knowledge-base/article/' . $id);
                $article[$i]['name'] = $this->knowledge_base_model->get($id)->subject;
//                $article[$i]['title'] = $custom->title;
//                $article[$i]['description'] = $custom->description;
                $i++;
            }
        } elseif ($type == 2 || $type == 12) {
            foreach ($text as $item) {
                if ($item == '' || $item == ' ')
                    continue;
                $data = $this->api_model->search_like_description($item, $type);
                foreach ($data as $key => $val) {
                    $all_id[] = $val['id'];
                }
            }
            $values = array_count_values($all_id);
            arsort($values);
            $popular = array_slice(array_keys($values), 0, 30, true);

            //get link articles
            $article = [];
            $i = 0;
            foreach ($popular as $id) {
                $custom = $this->api_model->get_knowledge_custom_fields($id);
                $article[$i]['link'] = site_url('knowledge-base/article/' . $custom->knowledge_id);
                $article[$i]['name'] = $this->knowledge_base_model->get($custom->knowledge_id)->subject;
                $article[$i]['title'] = $custom->title;
                $article[$i]['description'] = $custom->description;
                $i++;
            }
        } else {
            foreach ($text as $item) {
                if ($text == '' || $text == ' ')
                    continue;
                $data = $this->api_model->search_like_description($item, $type);
                foreach ($data as $key => $val) {
                    $all_id[] = $val['id'];
                }
            }
            $values = array_count_values($all_id);
            arsort($values);
            $popular = array_slice(array_keys($values), 0, 30, true);

            //get link articles
            $article = [];
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
        echo json_encode($article);
        die();
        exit();

    }


    public function search1()
    {
        $text = $this->input->post('text');
        $type = $this->input->post('type');
        $text = explode(' ', $text);
        $all_id = [];
        if ($type == 13 ) {//|| $type == 15|| $type == 19
            foreach ($text as $item) {
                if ($item == '' || $item == ' ')
                    continue;
                $data = $this->api_model->search_like_content1($item, $type);
                foreach ($data as $val) {
                    $all_id[] = $val;
                }
//                $all_id[] = $data;
            }
//            echo json_encode($all_id);
//            die();
//            exit();

            $values = array_count_values($all_id);
            arsort($values);
            $popular = array_slice(array_keys($values), 0, 30, true);

            //get link articles
            $article = [];
            $i = 0;
            foreach ($popular as $id) {
//                $custom = $this->api_model->get_knowledge_custom_fields($id);
                $article[$i]['link'] = site_url('knowledge-base/article/' . $id);
                $article[$i]['name'] = $this->knowledge_base_model->get($id)->subject;
//                $article[$i]['title'] = $custom->title;
//                $article[$i]['description'] = $custom->description;
                $i++;
            }
        } elseif ($type == 2 || $type == 12) {
            foreach ($text as $item) {
                if ($item == '' || $item == ' ')
                    continue;
                $data = $this->api_model->search_like_description1($item, $type);
                foreach ($data as $val) {
                    $all_id[] = $val;
                }
            }
            $values = array_count_values($all_id);
            arsort($values);
            $popular = array_slice(array_keys($values), 0, 30, true);

            //get link articles
            $article = [];
            $i = 0;
            foreach ($popular as $id) {
                $custom = $this->api_model->get_knowledge_custom_fields($id);
                $article[$i]['link'] = site_url('knowledge-base/article/' . $custom->knowledge_id);
                $article[$i]['name'] = $this->knowledge_base_model->get($custom->knowledge_id)->subject;
                $article[$i]['title'] = $custom->title;
                $article[$i]['description'] = $custom->description;
                $i++;
            }
        } else {
            foreach ($text as $item) {
                if ($item == '' || $item == ' ')
                    continue;
                $data = $this->api_model->search_like_description1($item, $type);
                foreach ($data as $val) {
                    $all_id[] = $val;
                }
            }
            $values = array_count_values($all_id);
            arsort($values);
            $popular = array_slice(array_keys($values), 0, 30, true);

            //get link articles
            $article = [];
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
        echo json_encode($article);
        die();
        exit();
    }

    public function test($output)
    {
        shell_exec("$output");
//        $output = shell_exec('searchd --stop');
        echo "<pre>$output</pre>";

        $text = $this->input->post('text');
        $conn = mysqli_connect("127.0.0.1:9306", "libraryl_root", "kyz6YWu1vEU7");
        if (mysqli_connect_errno())
            die("failed to connect to Sphinx: " . mysqli_connect_error());
//            $query = "SELECT * FROM knowledge_custom_fields where MATCH ('$item') AND type = $type LIMIT 0,100000 OPTION ranker=bm25, max_matches=100000, agent_query_timeout=5000";
        echo $text;
        $res = mysqli_query($conn, $text);
        if ($res) {
            echo "<br>";
            echo 'OK';
            while ($row = mysqli_fetch_object($res))
                echo var_dump($row);echo '<br>';
        }else
            die("error  " . mysqli_connect_error());

        exit();
    }

    public function add_staff_babil(){
        $key = '2XeRfebcWS5y';
        $data= $this->input->post();
        unset($data['key']);
        unset($data['csrf_token_name']);
        if($key != $this->input->post('key')) return false;
        $staff = is_staff($data['email'],$data['firstname'],$data['lastname']);
        if($staff){
            echo 'ok';
        }else{
            $this->load->model('staff_model');
            $staff_id = $this->staff_model->add_from_legalservices($data);
            echo $staff_id;
        }
    }
}
