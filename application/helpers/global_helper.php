<?php

if (!function_exists('db_date_time')) {
    function db_date_time($date_time = false) {
        return $date_time ? date('Y-m-d H:i:s', strtotime($date_time)) : date('Y-m-d H:i:s');
    }
}


if (!function_exists('pr')) {
    function pr($arr = 'No Data') {
        echo "<pre>";
        print_r($arr);
        echo "</pre>";
    }
}

if (!function_exists('prd')) {
    function prd($arr = 'No Data') {
        echo "<pre>";
        print_r($arr);
        echo "</pre>";
        die;
    }
}




if (!function_exists('current_user')) {
    function current_user() {
        $thiss = &get_instance();
        return $thiss->session->userdata();
    }
}

if (!function_exists('user_data')) {
    function user_data($id) {
        $thiss = &get_instance();
        $res = $thiss->db->where('id', $id)->get('users')->row();
        return $res;
    }
}






if (!function_exists('print_task_status')) { //javascript href link print
    function print_task_status($val) {
        if ($val == 1) {
            echo '<span class="label label-success">Approved</span>';
        } elseif ($val == 0) {

            echo'<span class="label label-warning">Pending</span>';
        } else {
            echo'<span class="label label-danger">Rejected</span>';
        }
    }
}

if (!function_exists('pagination_formatting')) {
    function pagination_formatting() {
        $CI = &get_instance();
        $CI->page_config['full_tag_open'] = '<div class="pagging text-center"><nav><ul class="pagination justify-content-end">';
        $CI->page_config['full_tag_close'] = '</ul></nav></div>';
        $CI->page_config['first_link'] = true;
        $CI->page_config['last_link'] = true;
        $CI->page_config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
        $CI->page_config['num_tag_close'] = '</span></li>';
        $CI->page_config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $CI->page_config['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>';
        $CI->page_config['next_link'] = 'Next';
        $CI->page_config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
        $CI->page_config['next_tagl_close'] = '<span aria-hidden="true">&raquo;</span></span></li>';
        $CI->page_config['prev_link'] = 'Previous';
        $CI->page_config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
        $CI->page_config['prev_tagl_close'] = '</span></li>';
        $CI->page_config['first_tag_open'] = '<li class="page-item"><span class="page-link">';
        $CI->page_config['first_tagl_close'] = '</span></li>';
        $CI->page_config['last_tag_open'] = '<li class="page-item"><span class="page-link">';
        $CI->page_config['last_tagl_close'] = '</span></li>';

        return $CI->page_config;
    }
}

if (!function_exists('print_flash_message')) {
    function print_flash_message() {
        if (isset($_SESSION['flash_status']) and $_SESSION['flash_status'] == 'success') {

            echo '<div class="alert alert-dismissable sugg_msg alert-success "><button aria-hidden="true" data-dismiss="alert" class="close" type="button"></button> ';
            echo $_SESSION['flash_message'];
            echo '</div>';
        } elseif (isset($_SESSION['flash_status']) and $_SESSION['flash_status'] == 'error') {
            echo '<div class="alert alert-dismissable sugg_msg alert-danger"><button aria-hidden="true" data-dismiss="alert" class="close" type="button"></button>';
            echo $_SESSION['flash_message'];
            echo '</div>';
        }
       unset($_SESSION['flash_status']);
       unset($_SESSION['flash_message']);
    }
}


if (!function_exists('set_flash_message')) {
    function set_flash_message($type = 'error', $message = 'There is something wrong, Please contact to admin.') {

        $thiss = &get_instance();
        $thiss->session->set_flashdata(array('flash_message' => $message, 'flash_status' => $type));
    }
}



if (!function_exists('user_ip')) {
    function user_ip() {
        $ip = '';
        if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
            //check for ip from share internet
            $ip = $_SERVER["HTTP_CLIENT_IP"];
        } elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            // Check for the Proxy User
            $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } else {
            $ip = $_SERVER["REMOTE_ADDR"];
        }
        return $ip;
    }
}




if (!function_exists('status')) {
    function status() {
        return array('' => 'Select status', 1 => 'Active', 2 => 'Inactive');
    }
}
if (!function_exists('statusData')) {
    function statusData() {
        return array(0 => 'InComplete', 1 => 'Completed', 2 => 'InProgress');
    }
}
if (!function_exists('print_status')) { //javascript href link print
    function print_status($val) {

        if ((int) $val == 1) {
            echo '<span class="badge badge-success">Completed</span>';
        }
        else if ((int) $val == 0) {
            echo '<span class="badge badge-warning">Pending</span>';
        }
        else if ((int) $val == 2) {
            echo '<span class="badge badge-warning">InProgress</span>';
        }
       else{
            echo '<span class="dash">-</span>';
        }
    }
}

