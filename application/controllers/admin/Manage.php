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
        //上传图片取得图片存储路径
        $config['upload_path']      = './upload/images/';
        $config['file_ext_tolower'] = TRUE;
        $config['allowed_types']    = 'png|jpg|gif';
        $config['max_size']     = 1024*2;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (! $this->upload->do_upload('userfile1'))
        {   
            echo "图片上传失败" ;die;
        }
        else
        {   
            $data['video_img_name'] = $this->upload->data('file_name');
        }
        //上传视频取得视频存储路径，并插入数据库
		$config['upload_path']      = './upload/video/';
        $config['file_ext_tolower'] = TRUE;
        $config['allowed_types']    = 'mp4|ogg|webm';
        $config['max_size']     = 1024*1024*2;
        $this->upload->initialize($config);
        if (! $this->upload->do_upload('userfile2'))
        {   
            //失败最好删除1的文件
            $error = array('error' => $this->upload->display_errors());die;
        }
        else
        {   
            $data['video_cate_id'] = $this->input->post('video_cate_id');
            $data['video_name'] = $this->input->post('video_name',TRUE);
            $data['video_desc'] = $this->input->post('video_desc',TRUE);
            $data['video_filename'] = $this->upload->data('file_name');
            $data['video_author_id'] = $this->session->userdata('login_admin_id');
            $data['video_create_time'] = time();
            if($this->Video_model->add_video($data)){
                redirect('admin/Manage/videoupload');
            }else{
                echo '添加视频错误';die;
            }
        }
	}

}