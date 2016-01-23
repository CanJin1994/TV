<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//后台管理控制器
class Manage extends CI_Controller{
	//构造函数
    public function __construct()
    {
        parent::__construct();
        if(!($this->session->userdata('login_admin_id'))){
            redirect('admin/Admin/login');
        }
        $this->load->helper('form'); 
        $this->load->model('Video_model');
        #激活分析器以调试程序
        //$this->output->enable_profiler(TRUE);
    }
    
    //显示后台主页
	public function index(){
		$this->load->view('admin/main.html');
	}

    //显示视频列表页面
	public function videolist(){
        $data['videos'] = $this->Video_model->get_videolist();
		$this->load->view('admin/videolist.html',$data);
	}

    //显示视频上传页面
	public function videoupload(){
		$this->load->view('admin/videoupload.html');
    }
    //视频上传操作
	public function do_upload(){
		$config['upload_path']      = './upload/';
        $config['file_ext_tolower'] = TRUE;
         $config['allowed_types']    = 'mp4|ogg|webm';
        $config['max_size']     = 1024*1024*2;

        $this->load->library('upload', $config);

        if (! $this->upload->do_upload('userfile'))
        {
            $error = array('error' => $this->upload->display_errors());die;
        }
        else
        {
            $data['video_name'] = $this->input->post('video_name',TRUE);
            $data['video_desc'] = $this->input->post('video_desc',TRUE);
            $data['video_path'] = $this->upload->data('full_path');
            $data['video_author_id'] = $this->session->userdata('login_admin_id');
            $data['video_create_time'] = time();
            if($this->Video_model->add_video($data)){
                redirect('admin/Manage/index');
            }else{
                echo '添加视频错误';die;
            }
        }
	}
}