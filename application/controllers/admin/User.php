<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 用户控制器
 */
class User extends CI_Controller{

	public function __construct(){
        parent::__construct();
        $this->load->model('User_model');
         #激活分析器以调试程序
        //$this->output->enable_profiler(TRUE);
    }

	//重定向index
	public function index(){
    	redirect('admin/User/login');
    }
    //用户注册页面
    public function register(){
    	$this->load->view('register.html');
    }

    //用户登录页面!!!!!!!!!!!!!!!!!!!!!
    public function login(){
    	$this->load->view('main.html');
    }
    //验证用户登录
	public function dologin(){
		$data['username'] = $this->input->post('username',TRUE);
		$data['password'] = sha1($this->input->post('password',TRUE));
		if($this->User_model->dologin($data)){
    		redirect('show/index');
    	}else{
            echo "登录失败";

        }
	}

	public function logout(){
        $this->User_model->logout();
        redirect('show/index');
    }   

}