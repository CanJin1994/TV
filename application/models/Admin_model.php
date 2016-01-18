<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model{

    const TABLE_ADMIN = 'admin';
    
    public function dologin($data){
        $query = $this->db->where('admin_username',$data['admin_username'])->get(SELF::TABLE_ADMIN);
        $row = $query->row();
        if(isset($row)){
          if($row->admin_password === $data['admin_password']){
                $this->session->set_userdata('login_admin_id',$row->admin_id);
                $this->session->set_userdata('login_admin_username',$row->admin_username);
                return TRUE;
          }else{
            return FALSE;
          }
        }else{
            return FALSE;
        }
    }

    public function logout(){
        $this->session->unset_userdata('login_admin_id');
        $this->session->unset_userdata('login_admin_username');
    }
}