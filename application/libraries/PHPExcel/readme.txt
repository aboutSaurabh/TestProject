use belo method in ci cantroller
	
	
	
public function exc(){
	$excel_path =FCPATH.'assets/uploads/user_host.xls';
	$column = array('Computer Name','User Name');
	$this->load->library('PHPExcel/Excel','excel');	 
	$data = $this->excel->data($excel_path,$column);
	prd($data);
}
