<?php

class Users extends CI_Controller {

    protected $usersCreate = 'Users.Create';
    protected $usersEdit = 'Users.Edit';
    protected $usersView = 'Users.View';
    protected $usersDelete = 'Users.Delete';

    function __construct() {
        parent::__construct();
        //prd(auth("User"));

        if (!$this->auth->_is_logged_in()) {

            redirect('login');
        }
        $this->load->library('form_validation');
        $this->load->model('users_model');
    }
   


    function dashboard() {
      // $data  =  $this->users_model->viewDetails(100);
         $data = $this->users_model->fileData(10);
       $data['number_of_record']  =  $this->users_model->productdetails(); 
        //prd($data);
        $data['temp'] = 'auth';
        //$this->load->view('header');
        $this->load->view('dashboard', $data);
    }
    function view() {
       $data  =  $this->users_model->viewDetails(100);
        
        //prd($data);
      $this->load->view('view', $data);
    }
    function uploadfile() {
        $final_file_path = '';
        $data = '';
        if(!empty($_SESSION["file_name"])){
               unset($_SESSION["file_name"]);
        }
     
        $file = (!empty($_FILES['file']['name'])) ? $_FILES['file']['name'] : $_SESSION["file_name"];
        $ext = pathinfo($file, PATHINFO_EXTENSION);

        if ($ext == 'xls' || $ext == 'csv') {
            if (empty($_SESSION["file_name"])) {
                $path = FCPATH . 'assets/uploads/uploaded_xls/';

                if (!is_dir($path)) {
                    mkdir($path, 0777, true);
                }

                $file_name = time() . $_FILES['file']['name'];
                $final = $path . '/' . $file_name;
                $final_file_path = $final;
                if (move_uploaded_file($_FILES['file']['tmp_name'], $final)) {
                    $_SESSION["file_name"] = $file_name;
                }
                  //echo move_uploaded_file($_FILES['file']['tmp_name'], $final);
            }
          
           // prd($_SESSION["file_name"]);
            if (!empty($_SESSION["file_name"])) {
                $inputFileName = FCPATH . 'assets/uploads/uploaded_xls/' . @$_SESSION["file_name"];
                $uplodedPath = FCPATH . 'assets/uploads/uploaded_xls/';
                if (!is_dir($uplodedPath)) {
                    mkdir($uplodedPath, 0777, true);
                }

              
                $this->load->library('PHPExcel/PHPExcel');
                $i = 1;
                // $column = array('name', 'email', 'mobile', 'group');
                $column = array('name', 'description');
                $excel_data = $this->data($inputFileName, $column);
                $data=array();
                $data['header'] = !empty($excel_data[1]) ? $excel_data[1] : false;
               
 
                unset($excel_data[1]);
                $final_data = array();
                foreach ($excel_data as $key => $res) {

                    $validat_data['name'][] = $res['name'];
                    $validat_data['description'][] = $res['description'];
                }
                $arr_data = array_values($excel_data);
                
                    if (!empty($_POST['save'])) {
                      $validData =   $this->formValidation($validat_data,$final_file_path);
                      if($validData==1){
                          
                        $uniqid = uniqid();
                        $fileInfo["fileName"] =$_SESSION["file_name"];
                        $fileInfo["batchId"] =$uniqid;
                        $fileInfo["createdDate"] = db_date_time(); 
                        $fileInfo["status"] = 0; 
                        
                       $resp =  $this->users_model->saveFileFino($fileInfo);
                        $finalResult = array();
                        
                        if(!empty($arr_data)){
                            foreach ($arr_data as $key=>$value){
                                $finalResult[$key]["name"] = $value["name"];
                                $finalResult[$key]["description"] = $value["description"];
                                $finalResult[$key]["file_id"] = $resp;
                                $finalResult[$key]["created_on"] = $finalResult[$key]["modified"]  = db_date_time();
                                $finalResult[$key]["file_id"] = $resp;
                                $finalResult[$key]["status"] = 0;
                            }
                        }
                        $this->db->insert_batch('productdetails', $finalResult); 
                     //   echo "<pre>"; print_r($finalResult);die;
                           set_flash_message($type = 'success', $message = 'File successfully uploaded');
                           unlink($final_file_path);
                           unset($_SESSION["file_name"]);
                           
                           redirect("dashboard");
                      }
                        
                   // echo  "<pre>";  print_r($validData);   die("nbnbn");
                    }
            }
        } else {
             set_flash_message($type = 'error', $message = 'File formate not valid.');
           

          redirect("dashboard");
        }
    }

    function formValidation($post_data,$final_file_path) {

        $this->form_validation->set_data($post_data);
        $this->form_validation->set_rules($this->users_model->custom_form_validation_rules($post_data));
        $res = true;
        if ($this->form_validation->run() === false) {
            $data['data'] = $this->form_validation->error_array();
            set_flash_message($type = 'error', $message = 'All field value is required please validate and upload file');
            unlink($final_file_path);
            unset($_SESSION["file_name"]);

            redirect("dashboard");
           // prd($data);
            return false;
        } else {
            return TRUE;
        }
    }
    function downloadExcel(){
         $data  =  $this->users_model->viewDetails(100);
         $statusData = statusData();
         //prd($statusData);
        $file=date('d M Y h:i:s', strtotime(time()))."-productList.xls";
        $html="<table  ><tr><td>Product Name</td><td>Description</td><td>Created Date</td><td>Status</td></tr>";
        if(!empty($data["records"])){
            $res = $data["records"];
            foreach ($res as $key=>$value){
                 $html.="<tr><td>".$value->name."</td><td>".$value->description."</td><td>".date('d M Y', strtotime($value->created_on))."</td><td>".$statusData[$value->status]."</td></tr>";
            }
           
        }
         
         
         $html.="</table>";
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=$file");
        echo $html;
    }
    public function data($excel_path, $column_format = null) {
        /* check format */;
        if (!file_exists($excel_path)) {
            $message = "file not exist";
            set_flash_message('error', $message);
            return false;
        }

        /* load lib and get obj */
        $objPHPExcel = PHPExcel_IOFactory::load($excel_path);

        /* max column range */
        $max_column = count($column_format);
        $alpha_range = range('A', 'Z');
        $excel_columns = range('A', $alpha_range[$max_column - 1]);


        /* max row range */
        foreach ($excel_columns as $column) {
            $rows_max[] = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow($column);
        }
        $excel_rows = range(1, max($rows_max));

        /* get header(first_row) and remain rows in single array */
        foreach ($excel_rows as $row) {
            foreach ($excel_columns as $column) {
                $cell_value = $objPHPExcel->getActiveSheet()->getCell($column . $row)->getValue();
                // $cell_val = trim(iconv("UTF-8","ISO-8859-1",$cell_value)," \t\n\r\0\x0B\xA0");
                $cell_val = trim(iconv('UTF-8', 'ASCII//TRANSLIT', utf8_encode($cell_value)), " \t\n\r\0\x0B\xA0");
                if ($row == 1) { //create header
                    $header[$column] = $cell_val;
                } elseif ($column . $row == 'A2') { //inital header in first row 
                    $data[1] = $header_format = array_values($header);
                    $data[$row][$header[$column]] = $cell_val;

                    /* check defin and excel format */
                    array_multisort($header_format, $column_format);
                    if ($column_format and ( $header_format != $column_format)) {
                       //	pr($column_format);
                       //prd($header_format);
                        $url = base_url('/assets/uploads/formate.csv');
                        $message = "Format not valid: there should only " . count($column_format) . " columns in first row of excel  \"" . implode(', ', $column_format) . "\"  " . anchor($url, 'click here download formate', 'class="link-class"');
                        set_flash_message('error', $message);
                        redirect("dashboard");
                        //return false;
                    }
                } else { //create remain row after header 
                    $data[$row][$header[$column]] = $cell_val;
                }
            }
            /* unset row if empty whole row */
            if (isset($data[$row]) and empty(array_filter($data[$row]))) {
                unset($data[$row]);
            }
        }


        // pr($data); 
        return $data;
    }

}
