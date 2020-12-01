<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth {

    private $ci;

    function __construct() {
        $this->ci = & get_instance();
        $this->ci->load->database();
        $this->ci->load->library('session');
        $this->update_session();
    }

    function _is_logged_in() {
		//prd($_SESSION['id']);
        $logged_in = (isset($_SESSION['logged_in']) and isset($_SESSION['site']) and $_SESSION['site'] == base_url('')) ? true : false;
	
        if (!$logged_in and isset($_COOKIE['logged_in'])) {
            $this->remember_login();
        } else {
			$user_id = !empty($_SESSION['id'])?$_SESSION['id']:false;
			$check_details = $this->ci->db->where(array("status"=>"1","id"=>$user_id))->get("users")->row();
			//prd($check_details);
			if(empty($check_details) && isset($_SESSION['logged_in'])){
				$this->logout();
			}else{
				 return $logged_in;
			}
           
        }
    }

    function check_login() {
        if ($this->_is_logged_in()) {
            $role_id = $this->ci->session->userdata('role_id');
            $destination = $this->ci->session->userdata('destination');
            // print_R($destination); die();
            $this->redirect_role($destination);
        } else {
            return false;
        }
    }

    function remember_login() {
        $user_cookie = ($_COOKIE['logged_in'] and isset($_COOKIE['userid']) and isset($_COOKIE['site']) and $_COOKIE['site'] == base_url()) ? true : false;
		
        if ($user_cookie) {
            $userdata = $this->ci->db->where('id', $_COOKIE['userid'])->get('user_details')->first_row();
            $this->set_user_data_session($userdata);
            $this->redirect_role($userdata->destination);
        } else {
            return false;
        }
    }

    function set_user_data_session($userdata) {
        $userdata->site = base_url();
        $userdata->logged_in = TRUE;
        $this->ci->session->set_userdata((array) $userdata);
    }


    function update_session() {
        $current_user = current_user();
        if (!empty($current_user['email'])) {
            $userdata = $this->ci->db->where(array('email' => $current_user['email'], 'status' => '1'))->get('users')->row();
			
          
        }
    }



    function redirect_role($destination) {
        redirect($destination);
    }

    function auth_login($login = null, $password = null, $remember = false, $user=false,$url_type=false,$url=false) {
        //is empty 
		if($url_type!="verify"){
			if (empty($login) || empty($password)) {
				$this->ci->session->set_flashdata('message', array('status' => 'error', 'message' => 'Username and Password fields must be filled out.'));
				return false;
			}
		}
	
        if($user)
        {
            // getting user data by username, pass, status,role_id
          
 $userdata = $this->ci->db->select('users.*')->where(array('users.email' => $login, 'users.status' => '1'))->get('users')->first_row();  		   
        }else{
          
 $userdata = $this->ci->db->select('users.*')->where(array('users.email' => $login, 'users.status' => '1'))->get('users')->first_row();  			   
        }
       // prd($userdata);
        //save last login date
        $data = array('last_login' =>date('Y-m-d H:i:s'));
        $this->ci->db->update('users', $data, array('id' => $userdata->id));

        /* check password */
		if($url_type!="verify"){
			if (!empty($userdata->password) and ! password_verify($password, $userdata->password)) {
				set_flash_message('error', 'Sorry! Username and Password not matching');
				return false;
			}
		}

		//prd($userdata);
        // is username pass exist	   
        if ($userdata) {
            //The login was successfully validated, so setup the session		 
            $this->set_user_data_session($userdata);

            // if rememebe then set cooki for 1m
			if(!empty($login_data)):
            if ($remember) {
                foreach ($login_data as $name => $val) {
                    setcookie($name, $val, time() + (86400 * 30));
                }

                $e_password = base64_encode($password);
                setcookie('password', $e_password, time() + (86400 * 30));
            } else {
                foreach ($login_data as $name => $val) {
                    setcookie($name, $val, time() - 3600);
                }
                setcookie("password", false, time() - 3600);
            }
		endif;
			if($url_type=="verify"){
				  set_flash_message($type = 'success', $message = 'Your account successful activated .');
				$this->redirect_role($url);
			}else{
				// $this->redirect_role($userdata->destination);
                                redirect("dashboard");
			}
           
        } else {
			   $check_email_status = $this->ci->db->select('users.*')->where(array('email' => $login, 'users.status!=' => 1))->get('users')->first_row(); 
			   //pr($check_email_status);die("ffff");
			   if(!empty($check_email_status)){
				   set_flash_message($type = 'error', $message = 'You account is temporary inactive, Please contact your Admin');
			   }else{
				   set_flash_message($type = 'error', $message = 'Sorry! Username and Password not matching');
			   }
            
            ($user) ? redirect('login') : redirect('login');
        }
    }

    function logout_no_redirect() {
        setcookie("logged_in", false, time() - 3600);
        $this->ci->session->unset_userdata(array('id', 'email', 'user_name', 'site', 'logged_in'));   
        return true;
    }

    function logout($change_pass = false) {

        $url = base_url("login");

        if ($this->logout_no_redirect()) {
            if ($_SESSION['flash_message']) {
                set_flash_message($_SESSION['flash_status'], $_SESSION['flash_message']);
            }
            redirect($url);
        }
    }
}
