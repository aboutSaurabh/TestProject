<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

        function __construct() {
            parent::__construct();
            $this->load->model('users_model');
             if ($this->auth->_is_logged_in()) {

           // redirect('dashboard');
        }
            $this->load->library('form_validation');
        }
	public function index()
	{
             redirect('/login/');
		//$this->load->view('welcome_message');
	}
        
        function login() {
   //     print_r($_SESSION);   die("hi saurabh");
        if ($this->auth->_is_logged_in()) {
            //set_flash_message('error', 'You are already logged in!');
            redirect('dashboard');
        }
    //
        if (isset($_POST['login'])) {
              
            if ($this->users_model->login_validation() == false) {
                set_flash_message($type = 'error', $message = 'Please enter all required field.');
                /* return false; */
            } else {
                $this->auth->auth_login($this->input->post('email'), $this->input->post('password'), 1, false);
            }
        }
        $data['temp'] = 'auth';
       //$this->load->view('header');
        $this->load->view('login/index', $data);
       // $this->load->view('footer');
    }
      function logout() {
          //die("ihhi");
          //unset($_SESSION);
         // redirect("login");
       $this->auth->logout();
    } 
 
}
