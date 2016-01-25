<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Video_model extends CI_Model{

	const TABLE_VIDEO = 'video';
	const TABLE_CATE = 'video_cate';

	public function add_video($data){
		return $this->db->insert(SELF::TABLE_VIDEO,$data);
	}

	public function get_videolist(){
		$query = $this->db->select('*')->from(SELF::TABLE_VIDEO)->join(SELF::TABLE_CATE,'cate_id = video_cate_id')->order_by('video_create_time','DESC')->get();
		$row = $query->row();
		if(isset($row)){
			return $query->result_array();
		}else{
			return FALSE;
		}
	}

	public function get_videoinformation($video_id){
		$query = $this->db->where('video_id',$video_id)->get(SELF::TABLE_VIDEO);
		$row = $query->row();
		if(isset($row)){
			return $query->row_array();
		}else{
			return FALSE;
		}
	}

	public function get_cate_videoinformation($cate_id){
		$query = $this->db->where('video_cate_id',$cate_id)->order_by('video_create_time','DESC')->get(SELF::TABLE_VIDEO);
		$row = $query->row();
		return $query->result_array();
	}

}