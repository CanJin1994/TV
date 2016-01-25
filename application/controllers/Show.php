<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Show extends CI_Controller{

	public function __construct(){
        parent::__construct();
        $this->load->model('Video_model');
         #激活分析器以调试程序
        //$this->output->enable_profiler(TRUE);
    }
    
    //显示主页
	public function index(){
		//第一个参数cate_id 第二个参数显示条数
		$data['varietys'] = $this->Video_model->get_limit_information(1,5);
		$data['tvs'] = $this->Video_model->get_limit_information(2,5);
		$data['movies'] = $this->Video_model->get_limit_information(3,5);
		$data['cartoons'] = $this->Video_model->get_limit_information(4,5);
		$data['sports'] = $this->Video_model->get_limit_information(5,5);
		$data['others'] = $this->Video_model->get_limit_information(6,5);
		$this->load->view('main.html',$data);
	}
	//展示一个视频
	public function play($video_id){	
		//视频存在播放，不存在返回主页
		if($data = $this->Video_model->get_videoinformation($video_id)){
    		$this->load->view('play.html',$data);
    	}else{
    		redirect('Show/index');
    	}
		
	}
	//展示一个分类的视频
	public function more($cate){
		//根据传入的参数，给cate_id赋值
		//直接传cate_id链接不美观
		switch ($cate)
		{
			case 'variety':
				$cate_id = '1';
				$data['cate'] = '综艺';
				break;  
			case 'tv':
				$cate_id = '2';
				$data['cate'] = '电视剧';
				break;
			case 'movie':
				$cate_id = '3';
				$data['cate'] = '电影';
				break;
		  	case 'cartoon':
		  		$cate_id = '4';
		  		$data['cate'] = '动漫';
		  		break;
		  	case 'sport':
		  		$cate_id = '5';
		  		$data['cate'] = '体育';
		  		break;
		  	case 'other':
		  		$cate_id = '6';
		  		$data['cate'] = '其他';
		  		break;
		  	default :
		  		redirect('Show/index');
		}
		//因为上面switch语句实际上已经进行非法参数过滤了 所以下面可以不需要判断语句
		$data['videos'] = $this->Video_model->get_cate_videoinformation($cate_id);
    	$this->load->view('more.html',$data);
    	
    }

}