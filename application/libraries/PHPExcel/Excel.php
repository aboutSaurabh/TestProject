<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed'); 
require_once APPPATH."/libraries/PHPExcel/PHPExcel.php";
class Excel extends PHPExcel {
	
	public function __construct() {
		parent::__construct();
	}
	 
	public function data($excel_path,$column_format=null)
    { 
          /* check format */ ;
          if(!file_exists($excel_path)){
				$message = "file not exist";
				set_flash_message('error', $message);
				return false;
          }
          
          /* load lib and get obj */     
          $objPHPExcel = PHPExcel_IOFactory::load($excel_path); 
          
          /* max column range */
          $max_column = count($column_format);
          $alpha_range = range('A', 'Z');
          $excel_columns = range('A', $alpha_range[$max_column-1]);
          
          
          /* max row range */
          foreach($excel_columns  as $column){
            $rows_max[] = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow($column);
          } 
          $excel_rows = range(1,max($rows_max));   
         
        /* get header(first_row) and remain rows in single array */ 
        foreach($excel_rows as $row){ 
            foreach($excel_columns as $column){
				$cell_value =  $objPHPExcel->getActiveSheet()->getCell($column.$row)->getValue();
				// $cell_val = trim(iconv("UTF-8","ISO-8859-1",$cell_value)," \t\n\r\0\x0B\xA0");
				$cell_val = trim(iconv('UTF-8', 'ASCII//TRANSLIT', utf8_encode($cell_value))," \t\n\r\0\x0B\xA0");
                 if($row==1){ //create header
                    $header[$column] = $cell_val; 
                 }elseif($column.$row=='A2'){ //inital header in first row 
                    $data[1] = $header_format = array_values($header);  
                    $data[$row][$header[$column]] =   $cell_val;
                    
                    /* check defin and excel format */
                    array_multisort($header_format,$column_format); 
                    if($column_format and ($header_format!= $column_format)){ 
					
                        $message = "Format not valid: there should only ".count($column_format)." columns in first row of excel ( \"".implode('", "',$column_format)."\")";
						set_flash_message('error', $message);
						return false;
                    }
                    
                 }else{ //create remain row after header 
                    $data[$row][$header[$column]] = $cell_val; 
                 }
            }
            /* unset row if empty whole row */
            if(isset($data[$row]) and empty(array_filter($data[$row]))){
                unset($data[$row]);
            }
        }
  
            
         // prd($arr);  
         return $data;  
    }
	 
}