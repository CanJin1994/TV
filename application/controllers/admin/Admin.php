<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 管理员控制器
 */
class Admin extends CI_Controller{
    
	public function __construct(){
        parent::__construct();
        $this->load->model('Admin_model');
         #激活分析器以调试程序
        //$this->output->enable_profiler(TRUE);
    }

    //重定向到管理员登录页面
    public function index(){
    	redirect('admin/Admin/login');
    }
    //显示管理员登录页面
    public function login($status = ''){
        if($status){
            $data['error'] = '用户名密码错误!';
    	    $this->load->view('admin/login.html',$data);
        }else{
            $data['error'] = '';
            $this->load->view('admin/login.html',$data);
        }
    }
    //验证管理员登录
    public function dologin(){
    	$data['admin_username'] = $this->input->post('username',TRUE);
    	$data['admin_password'] = sha1($this->input->post('password',TRUE));
    	if($this->Admin_model->dologin($data)){
    		redirect('admin/Manage/index');
    	}else{
            redirect('admin/Admin/login/1');

        }
    }

    //管理员注销
    public function logout(){
        $this->Admin_model->logout();
        redirect('admin/Admin/login');
    }
}