<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Show extends CI_Controller{

	public function __construct(){
        parent::__construct();
         #激活分析器以调试程序
        //$this->output->enable_profiler(TRUE);
    }

	public function index(){
		$this->load->view('main.html');
	}
	public function player(){
		$this->load->view('player.html');
	}
	public function more(){
    	$this->load->view('more.html');
    }

}