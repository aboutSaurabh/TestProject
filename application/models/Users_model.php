<?php

class Users_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function fileData($limit) {
        $this->load->library('pagination');
        $per_page = isset($_GET['per_page']) ? $_GET['per_page'] : false;
        unset($_GET['per_page']);
        $query_string = http_build_query($_GET);
        $site_url = !$query_string ? site_url('dashboard') : site_url('dashboard?' . $query_string);
        if ($per_page) {
            $_GET['per_page'] = $per_page;
        }
        $num_rows = $this->details();
        $config = pagination_formatting();
        $config['base_url'] = $site_url;
        $config['total_rows'] = $num_rows;
        $config['per_page'] = $limit;
        $config['num_links'] = 5;
        $config['use_page_numbers'] = TRUE;
        $config['page_query_string'] = TRUE;
        $this->pagination->initialize($config);
        $offset = isset($_GET['per_page']) ? ($_GET['per_page'] - 1) * $limit : 0;

        $data['records'] = $getting = $this->details(false, $limit, $offset);
        $data['result_summary'] = "Showing records " . ($offset + 1) . " - " . ($offset + count($getting)) . " (" . $num_rows . " total)";

        return $data;
    }

    public function details($count = true, $limit = false, $offset = false) {
        $filter = $this->input->get(array("title"));
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
       
        $this->db->select('*');
         if (!empty($filter['title'])) {
            $title = trim($filter['title']);
            $where = "( filedetails.batchId LIKE '%$title%' )"; 
            $this->db->where($where);
        }
        $query = $this->db->order_by('id', 'desc')->get('filedetails');

        if ($count) {
            $res = $query->num_rows();

            return $res;
        } else {
            $res = $query->result();
            return $res;
        }
    }

    public function productdetails() {
        $filter = $this->input->get("*");
        $this->db->select('productdetails.id,productdetails.file_id,productdetails.name');
        $query = $this->db->order_by('id', 'desc')->get('productdetails');
        $res = $query->result();
      //  prd($res);
        if(!empty($res)){
            $resp = array();
            $final = array();
            foreach ($res as $key=>$value){
                $resp[$value->file_id][$key] = $value;
            }
            $data  = $resp;
          //  prd($resp);
           // $data= array_column($res, "totalRecord","file_id");
        }else{
          $data = array();  
        }
        return $data;
        
    }
    function viewDetails($limit) {
        $this->load->library('pagination');
        $per_page = isset($_GET['per_page']) ? $_GET['per_page'] : false;
        unset($_GET['per_page']);
        $query_string = http_build_query($_GET);
        $site_url = !$query_string ? site_url('admin/users/view') : site_url('admin/users/view?' . $query_string);
        if ($per_page) {
            $_GET['per_page'] = $per_page;
        }
        $num_rows = $this->getBarchResult();
        $config = pagination_formatting();  
        $config['base_url'] = $site_url;
        $config['total_rows'] = $num_rows;
        $config['per_page'] = $limit;
        $config['num_links'] = 5;
        $config['use_page_numbers'] = TRUE;
        $config['page_query_string'] = TRUE;
        $this->pagination->initialize($config);
        $offset = isset($_GET['per_page']) ? ($_GET['per_page'] - 1) * $limit : 0;

        $data['records'] = $getting = $this->getBarchResult(false, $limit, $offset);
        $data['result_summary'] = "Showing records " . ($offset + 1) . " - " . ($offset + count($getting)) . " (" . $num_rows . " total)";

        return $data;
    }
    public function getBarchResult($count = true, $limit = false, $offset = false) {
        $filter = $this->input->get();

        //prd($filter);
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        $this->db->select('*');
        $query = $this->db->order_by('id', 'desc')->get('productdetails');
        if(!empty($filter['id'])){
            $this->db->where('file_id',$filter['id']);
        }
        if ($count) {
            $res = $query->num_rows();

            return $res;
        } else {
            $res = $query->result();
           // echo $this->db->last_query(); die();
            return $res;
        }
    }

   
    public function custom_form_validation_rules($data) {
        //   echo "<pre>"; print_r($data); die();
        $arr = array();
        if (!empty($data)) {

            foreach ($data['name'] as $key => $val) {

                $arr[] = array(
                    'field' => 'name[' . $key . ']',
                    'label' => 'user name',
                    'rules' => 'required|trim',
                );
            }
            foreach ($data['description'] as $key => $val) {
                $arr[] = array(
                    'field' => 'description[' . $key . ']',
                    
                    'label' => 'description',
                    'rules' => 'required', 'trim', 'max_length[500]',
                    'errors' => "Description not empty",
                );
            }
        }
      
        return $arr;
    }
    function login_validation()
    {
        $this->load->library('form_validation');
        $arr[] = array(
                'field' => 'email',
                'label' => 'email',
                'rules' => 'required'
            );
        $arr[] = array(
                'field' => 'password',
                'label' => 'password',
                'rules' => 'required'
            );
       // echo "<pre>"; print_r($_POST); die("ghghghh");
        $this->form_validation->set_rules($arr);
        return $this->form_validation->run();
    }

    function saveFileFino($data) {

        $res = $this->db->insert("filedetails", $data);
        $this->db->trans_complete();
        return $this->db->insert_id();
        // echo "<pre>"; print_r($res);die;
    }
    function getFileInformation(){
          $this->db->select('*');
        $this->db->where('status',0);
          $query = $this->db->order_by('id', 'desc')->get('filedetails');
      // $this->db->last_query();
            $res = $query->result();
            return $res;
    }
      function getProductdetails($id){
          $this->db->select('*');
            $this->db->where('status',0);
        $this->db->where('file_id',$id);
          $query = $this->db->order_by('id', 'desc')->get('productdetails');
      // $this->db->last_query();
            $res = $query->result();
            return $res;
    }

}
