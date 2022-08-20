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
        $data['related_articles']      = $this->knowledge_base_model->get_related_articles($data['article']->articleid);
        add_views_tracking('kb_article', $data['article']->articleid);
        $data['title'] = $data['article']->subject;
        $data['fields'] = $this->knowledge_base_model->get_content($id);
//        $this->view('knowledge_base_article');
//        $this->data($data);
//        $this->layout();
        return $data;
    }

    public function search(){
        $text = $this->input->post('text');
        $type = $this->input->post('type');
        $text = explode(' ',$text);
        $all_id = [];
        if($type == 13) {
            foreach ($text as $item) {
                if($item == '' || $item == ' ')
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
            echo json_encode($article);exit();
            die();
        }elseif($type == 2 || $type == 12){
            foreach ($text as $item) {
                if($item == '' || $item == ' ')
                    continue;
                $data = $this->api_model->search_like_description($item,$type);
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
                $article[$i]['link'] = site_url('knowledge-base/article/'.$custom->knowledge_id);
                $article[$i]['name'] = $this->knowledge_base_model->get($custom->knowledge_id)->subject;
                $article[$i]['title'] = $custom->title;
                $article[$i]['description'] = $custom->description;
                $i++;
            }
            echo json_encode($article);exit();
            die();
        }else{
            foreach ($text as $item) {
                if($text == '' || $text == ' ')
                    continue;
                $data = $this->api_model->search_like_description($item,$type);
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
                $article[$i]['link'] = site_url('knowledge-base/article/'.$custom->knowledge_id);
                $article[$i]['name'] = $this->knowledge_base_model->get($custom->knowledge_id)->subject;
                $article[$i]['title'] = $custom->title;
                $article[$i]['description'] = $custom->description;
                $i++;
            }
            echo json_encode($article);exit();
            die();
        }
    }
    public function test($type,$text)
    {
        $text = trim($text);
        $text = explode(' ',$text);
        $conn = mysqli_connect("127.0.0.1:9306", "libraryl_root", "kyz6YWu1vEU7", "libraryl_data");
        if (mysqli_connect_errno())
            die("failed to connect to Sphinx: " . mysqli_connect_error());
        foreach ($text as $item) {
//                $query = "SELECT knowledge_id as id FROM knowledge_custom_fields where MATCH ('12')  LIMIT 0,100000 OPTION ranker=bm25, max_matches=100000,agent_query_timeout=5000 ";
            $query = "SELECT * FROM knowledge_custom_fields where MATCH ('$item') AND type = $type LIMIT 0,100000 OPTION ranker=bm25, max_matches=100000, agent_query_timeout=5000";
            $res = mysqli_query($conn, $query);
            if ($res) {
//                     echo var_dump($res);
                echo '<pre>';
                while ($row = mysqli_fetch_row($res))

                    echo var_dump($row);
                echo '<br>';
            }
//                if($res) {
//                     echo var_dump($res);
//                }else
//                    echo 'faile';
        }
        exit();
    }


}
