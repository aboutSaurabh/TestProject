<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('users_model');

        $this->load->library('form_validation');
    }

    function cron() {

       $final_resp["data"] =array();
       $final_resp["status"] =0;
      
        $final_resp["msg"] ="";
        $finalFileData = array();
        $lock = 0;
    if ($lock === 0) {
        $data = $this->users_model->getFileInformation();
         
        if (!empty($data)) {
             $lock=1;
            $i = 0;
          
              
                foreach ($data as $key=>$value) {
                    $i++;
                    $file_id = $value->id;
                    $result = $this->users_model->getProductdetails($file_id);
                    $k=0;
                    if (!empty($result)) {
                        $update = array();
                        foreach ($result as $val) {
                            $k++;
                            $update["status"] = 1;
                            $this->db->where("id", $val->id)->update("productdetails", $update);
                          //  echo $this->db->last_query();
                          //  echo "<br/>";
                        }
                    }
                     if (!empty($result) && $k <= count($result)) {
                    $updateFiledetails["status"] = 1;
                   $this->db->where("id", $file_id)->update("filedetails", $updateFiledetails);
                     }
                    // pr($result);
                     $finalFileData["id"] = $value->id;
                    $finalFileData["status"] = 1;
                }

            if (count($data) <= $i) {
                $lock =0;
            }
            //$respArray = array("id"=>)
            $final_resp["data"] = $finalFileData;
            $final_resp["status"] = 1;
            // json_encode($final_resp);
        }else{
              $final_resp["data"] = array();
            $final_resp["status"] = 0;
           //echo json_encode($final_resp);
        }
         
       
    }else{
        //die("ff");
        $final_resp["data"] = array();
        $final_resp["status"] = 0;
        $final_resp["msg"] = "cron runing please wait";
        
    }
    
   // echo "dfdfdfd__".$lock;
   // prd($data);
    echo json_encode($final_resp);
    }
    

}
