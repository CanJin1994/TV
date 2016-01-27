<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ip_model extends CI_model{

	const TABLE_IP = 'ip_address';

	public function add_ip($ip_address){
		$query = $this->db->where('ip_address',$ip_address)->get(SELF::TABLE_IP);
		$row = $query->row();
		if(isset($row)){
			if(time() - $row->update_time > 3600*2){
				//同ip，距上次登录超过2小时,计数加一
				$data['update_time'] = time();
				$data['visit_count'] = $row->visit_count + 1;
				$this->db->where('ip_id',$row->ip_id)->update(SELF::TABLE_IP,$data);
			}
			$this->session->set_userdata('ip_address', $ip_address);
		}else{
			//首次登陆,将ip_address加到表中
			$data['ip_address'] = $ip_address;
			$data['update_time'] = time();
			$data['visit_count'] = 1;
			$this->session->set_userdata('ip_address', $ip_address);
			return $this->db->insert(SELF::TABLE_IP,$data);
		}
	}
}