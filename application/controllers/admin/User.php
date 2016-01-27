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
    
    //用户登录页面
    public function login($error= ''){
        if($error){
            $data['error'] = '用户名密码错误';
    	    $this->load->view('login.html',$data);
        }else{
            $data['error'] = '';
            $this->load->view('login.html',$data);
        }
    }
    //验证用户登录
	public function dologin(){
		$data['username'] = $this->input->post('username',TRUE);
		$data['password'] = sha1($this->input->post('password',TRUE));
		if($this->User_model->dologin($data)){
    		redirect('Show/index');
    	}else{
            redirect('admin/User/login'.'/'.'error');
        }
	}

    //用户注册页面
    public function register(){
        $this->load->view('register.html');
    }
    //进行用户注册
    public function doregister(){
        //验证可以优化!!!!!!!!!!!!!!!!!!!!!!!!!!
        $data['user_nickname'] = $this->input->post('user_nickname',TRUE);
        $data['username'] = $this->input->post('username',TRUE);
        $data['password'] = $this->input->post('password',TRUE);
        $password1 = $this->input->post('password1',TRUE);
        if($data['user_nickname']){
            if($data['password'] == $password1){
                if($this->User_model->add_user($data)){
                    if($this->User_model->dologin($data)){
                        redirect('Show/index');
                    }
                }else{
                   echo "注册失败"; 
                }
            }else{
                echo "两次输入密码不一致";
            }
        }else{
            echo "昵称不能为空";
        }
    }

	public function logout(){
        $this->User_model->logout();
        redirect('admin/User/login');
    }   

}