<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Api_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
    }


    public function search_like_custom_fields_values($text, $type = '', $fieldid)
    {
        $this->db->select('id as id');
        if ($type != '') $this->db->where(['fieldto' => 'kb_' . $type, 'fieldid' => $fieldid]);
        $this->db->like('value', $text);
        $this->db->from(db_prefix() . 'customfieldsvalues');
        return $this->db->get()->result_array();
    }

    public function search_like_description($text, $type = '')
    {
//        $this->db->select('id as id');
//        if($type!='')$this->db->where(['type' => $type]);
//        $this->db->like('description',' '.$text.' ');
//        $this->db->from(db_prefix() . 'knowledge_custom_fields');
//        return $this->db->get()->result_array();

        $sql = "SELECT id as id
            FROM tblknowledge_custom_fields
            WHERE (type = $type) AND ( MATCH (description) AGAINST ('$text'))";

        $query = "SELECT id as id FROM tblknowledge_custom_fields 
                where (type = $type) AND (description LIKE '%$text%')";

        return $this->db->query($sql)->result_array();

    }

    public function search_like_content($text, $type = '')
    {
//        $this->db->select('knowledge_id as id');
//        if($type!='')$this->db->where(['type' => $type]);
//        $this->db->like('description',' '.$text.' ');
//        $this->db->from(db_prefix() . 'knowledge_custom_fields');
//        return $this->db->get()->result_array();

        $sql = "SELECT knowledge_id as id
            FROM tblknowledge_custom_fields
            WHERE (type = $type) AND (MATCH (description) AGAINST ('$text'))";

        $query = "SELECT knowledge_id as id FROM tblknowledge_custom_fields 
                where (type = $type) AND (description LIKE '%$text%') ";

        return $this->db->query($sql)->result_array();

    }

    public function get_knowledge_custom_fields($id)
    {
        $sql = "SELECT *
            FROM tblknowledge_custom_fields
            WHERE (id = $id)";
        return $this->db->query($sql)->row();

//        $this->db->where(['id' => $id]);
//        $this->db->from(db_prefix() . 'knowledge_custom_fields');
//        return $this->db->get()->row();
    }

    public function get_custom_fields_values($id)
    {
        $this->db->where(['id' => $id]);
        $this->db->from(db_prefix() . 'customfieldsvalues');
        return $this->db->get()->row();
    }

    public function get_custom_fields($id)
    {
        $this->db->where(['id' => $id]);
        $this->db->from(db_prefix() . 'customfields');
        return $this->db->get()->row();
    }



    public function copy()
    {
        $affected_rows = 0;
        $this->db->select('type,articleid');
        $this->db->from(db_prefix() . 'knowledge_base');
        $data = $this->db->get()->result_array();
        foreach ($data as $d) {
            $this->db->where('knowledge_id', $d['articleid']);
            $this->db->update(db_prefix() . 'knowledge_custom_fields', ['type' => $d['type']]);
            if ($this->db->affected_rows() > 0) {
                $affected_rows++;
            }
        }
        return $affected_rows;
    }

    public function search_like_content1($text, $type = '')
    {
        $conn = mysqli_connect("127.0.0.1:9306", "libraryl_root", "kyz6YWu1vEU7");
        if (mysqli_connect_errno())
            die("failed to connect to Sphinx: " . mysqli_connect_error());

        $query = "SELECT knowledge_id FROM knowledge_custom_fields 
                where (type = $type) AND (MATCH ('$text')) LIMIT 0,100000 
                OPTION ranker=bm25, max_matches=100000, agent_query_timeout=5000";
        $res = mysqli_query($conn, $query);
        $result = [];
        if ($res) {
            while ($row = mysqli_fetch_object($res))
                $result[] = $row->knowledge_id;
        }
        return $result;
    }

    public function search_like_description1($text, $type = '')
    {

        $conn = mysqli_connect("127.0.0.1:9306", "libraryl_root", "kyz6YWu1vEU7");
        if (mysqli_connect_errno())
            die("failed to connect to Sphinx: " . mysqli_connect_error());

        $query = "SELECT id FROM knowledge_custom_fields 
                where (type = $type) AND (MATCH ('$text')) LIMIT 0,100000 
                OPTION ranker=bm25, max_matches=100000, agent_query_timeout=5000";
        $res = mysqli_query($conn, $query);
        $result = [];
        if ($res) {
            while ($row = mysqli_fetch_object($res))
                $result[] = $row->id;
        }
        return $result;
    }

    public function search_custom_fields_values($fieldid, $fieldto, $value)
    {
        $fieldto = 'kb_' . $fieldto;

        $sql = "SELECT relid as id FROM tblcustomfieldsvalues
                where (fieldid = $fieldid) AND (fieldto = '$fieldto')
                AND (value LIKE '%$value%')";
        return $this->db->query($sql)->result();


//        $conn = mysqli_connect("127.0.0.1:9306", "libraryl_root", "kyz6YWu1vEU7");
//        if (mysqli_connect_errno())
//            die("failed to connect to Sphinx: " . mysqli_connect_error());
//
//        $query = "SELECT relid as id FROM customfieldsvalues
//                where (fieldid = $fieldid) AND (fieldto = $fieldto)
//                AND (MATCH ('$value')) LIMIT 0,100000
//                OPTION ranker=bm25, max_matches=100000, agent_query_timeout=5000";
//        $res = mysqli_query($conn, $query);
//        $result = [];
//        if ($res) {
//            while ($row = mysqli_fetch_object($res))
//                $result[] = $row->id;
//        }
//        return $result;
    }

    public function search_custom_fields_values_by_relid($relid, $fieldid, $fieldto, $value)
    {
        $fieldto = 'kb_' . $fieldto;
        $sql = "SELECT relid as id FROM tblcustomfieldsvalues
                where (fieldid = $fieldid) AND (fieldto = '$fieldto')
                AND (relid = $relid) AND (value LIKE '%$value%')";
        return $this->db->query($sql)->result();
//
//        $conn = mysqli_connect("127.0.0.1:9306", "libraryl_root", "kyz6YWu1vEU7");
//        if (mysqli_connect_errno())
//            die("failed to connect to Sphinx: " . mysqli_connect_error());
//
//        $query = "SELECT relid as id FROM customfieldsvalues
//                where (fieldid = $fieldid) AND (fieldto = $fieldto)
//                AND (relid = $relid) AND (MATCH ('$value')) LIMIT 0,100000
//                OPTION ranker=bm25, max_matches=100000, agent_query_timeout=5000";
//        $res = mysqli_query($conn, $query);
//        $result = [];
//        if ($res) {
//            while ($row = mysqli_fetch_object($res))
//                $result[] = $row->id;
//        }
//        return $result;
    }

    public function search_like_content_by_knowledge_id($knowledge_id, $type = '', $text)
    {
        $conn = mysqli_connect("127.0.0.1:9306", "libraryl_root", "kyz6YWu1vEU7");
        if (mysqli_connect_errno())
            die("failed to connect to Sphinx: " . mysqli_connect_error());

        $query = "SELECT id FROM knowledge_custom_fields 
                where (knowledge_id = $knowledge_id) AND (type = $type) AND (MATCH ('$text')) LIMIT 0,100000 
                OPTION ranker=bm25, max_matches=100000, agent_query_timeout=5000";
        $res = mysqli_query($conn, $query);
        $result = [];
        if ($res) {
            while ($row = mysqli_fetch_object($res))
                $result[] = $row->id;
        }
        return $result;
    }

}