<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Video_model extends CI_Model{
	//视频表,视频分类表,用户偏好表
	const TABLE_VIDEO = 'video';
	const TABLE_CATE = 'video_cate';
	const TABLE_USER_PREFER = 'userprefer';
	//添加新视频
	public function add_video($data){
		return $this->db->insert(SELF::TABLE_VIDEO,$data);
	}
	//视频播放次数加一
	public function add_plays($video_id){
		$query = $this->db->where('video_id',$video_id)->get(SELF::TABLE_VIDEO);
		$row = $query->row();
		$data['video_plays'] = $row->video_plays + 1 ;
		$this->db->where('video_id',$video_id)->update(SELF::TABLE_VIDEO,$data);
	}
	//记录用户偏好
	public function add_userprefer($user_id,$video_cate_id){
		$query = $this->db->where('user_id',$user_id)->get(SELF::TABLE_USER_PREFER);
		$row = $query->row();
		//用户第一次访问，先创建用户偏好表
		if(! isset($row)){
			$prefer['user_id'] = $user_id;
			$this->db->insert(SELF::TABLE_USER_PREFER,$prefer);
			//重新获取数据
			$query = $this->db->where('user_id',$user_id)->get(SELF::TABLE_USER_PREFER);
			$row = $query->row();
		}
		switch ($video_cate_id) {
			case 1:
				$cate = 'variety';
				break;
			case 2:
				$cate = 'tv';
				break;
			case 3:
				$cate = 'movie';
				break;
			case 4:
				$cate = 'cartoon';
				break;
			case 5:
				$cate = 'sport';
				break;
			case 6:
				$cate = 'other';
				break;
		}
		$data[$cate] = $row->$cate + 1 ;
		$this->db->where('user_id',$user_id)->update(SELF::TABLE_USER_PREFER,$data);
	}
	//得到所有视频信息
	public function get_videolist(){
		$query = $this->db->select('*')->from(SELF::TABLE_VIDEO)->join(SELF::TABLE_CATE,'cate_id = video_cate_id')->order_by('video_create_time','DESC')->get();
		$row = $query->row();
		if(isset($row)){
			return $query->result_array();
		}else{
			return FALSE;
		}
	}
	//获得$limit条 视频信息
	public function get_limit_information($video_cate_id,$limit){
		$query = $this->db->select('video_id,video_img_name')->where('video_cate_id',$video_cate_id)->order_by('video_plays','DESC')->limit($limit)->get(SELF::TABLE_VIDEO);
		$row = $query->row();
		return $query->result_array();
	}
	//获得单条视频的信息
	public function get_videoinformation($video_id){
		$query = $this->db->where('video_id',$video_id)->get(SELF::TABLE_VIDEO);
		$row = $query->row();
		if(isset($row)){
			return $query->row_array();
		}else{
			return FALSE;
		}
	}
	//获得一个分类的视频信息
	public function get_cate_videoinformation($cate_id){
		$query = $this->db->where('video_cate_id',$cate_id)->order_by('video_create_time','DESC')->get(SELF::TABLE_VIDEO);
		$row = $query->row();
		return $query->result_array();
	}

}