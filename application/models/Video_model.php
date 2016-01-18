<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Video_model extends CI_Model{

	const TABLE_VIDEO = 'video';

	public function add_video($data){
		return $this->db->insert(SELF::TABLE_VIDEO,$data);
	}

	public function get_videolist(){
		$query = $this->db->get(SELF::TABLE_VIDEO);
		return $query->result_array();
	}

}