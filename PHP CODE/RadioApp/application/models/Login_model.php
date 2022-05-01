<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {
    
    public function get_user($username,$password){
        
        $this->db->select('*');
        $this->db->from('admin');
        $this->db->where('username', $username);
        $query = $this->db->get();        
        $user = $query->result();
       
        if(!empty($user)){
             $pass=$this->encryption->decrypt($user[0]->password);
            if($password==$pass){
                return $user;
            } else {
                return array();
            }
        } else {
            return array();
        }
    }
}