<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    private $data = [];
    public function __construct()
    {
        parent::__construct();
        $this->data['page_title'] = "Home"; 
        $this->load->library("form_validation");
    } 
	public function index()
	{ 	 
		$list = $this->UsersModel->fetch();
        $data['page_title'] = "Home";
		$data['list'] = $list; 
		$this->load->view('templates/header',$data);
		$this->load->view('welcome_message');
		$this->load->view('templates/footer',$data);
	}
}
