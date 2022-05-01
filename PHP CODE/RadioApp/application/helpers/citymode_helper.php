<?php

defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('is_city_mode_enabled')) {
 
   function is_city_mode_enabled() { 
        $ci =& get_instance();
        $result= $ci->db->where('type', 'city_mode')->get('settings')->result_array();
        return $result[0]['message'];
    }
  
}

