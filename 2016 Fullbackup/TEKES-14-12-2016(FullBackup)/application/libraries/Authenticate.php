<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Authenticate {

    function isAdmin() {
        $CI = & get_instance();
        $CI->load->library('session');
        $sess_data = $CI->session->all_userdata();
        $sess_id = $CI->session->userdata('user_id');
        if ($sess_id == NULL) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

}
