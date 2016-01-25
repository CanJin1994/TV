<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model{

	const TABLE_USER = 'user';
    
    public function dologin($data){
        $query = $this->db->where('username',$data['username'])->get(SELF::TABLE_USER);
        $row = $query->row();
        if(isset($row)){
          if($row->password === $data['password']){
                $this->session->set_userdata('login_user_id',$row->user_id);
                $this->session->set_userdata('login_user_username',$row->username);
                $this->session->set_userdata('login_user_nickname',$row->user_nickname);
                return TRUE;
          }else{
            return FALSE;
          }
        }else{
            return FALSE;
        }
    }

    public function logout(){
        $this->session->unset_userdata('login_user_id');
        $this->session->unset_userdata('login_user_username');
        $this->session->unset_userdata('login_user_nickname');
    }

    public function add_user($data){
        $query = $this->db->where('username',$data['username'])->get(SELF::TABLE_USER);
        $row = $query->row();
        if(isset($row)){
            echo "用户已存在";die;
        }else{
            return $this->db->insert(SELF::TABLE_USER,$data);
        }
    }
}