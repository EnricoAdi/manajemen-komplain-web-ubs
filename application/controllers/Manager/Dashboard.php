<?php
//Manager dashboard
class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->data['page_title'] = "Manager Page";
        $this->data['navigation'] = "Dashboard";

        $this->load->library("form_validation");


        middleware_auth(2); //hak akses manager
        $this->data['login'] = $this->UsersModel->getLogin();
    }
    public function index(){ 
        $data = $this->data;
        $data['page_title'] = "Dashboard Manager";
        loadView_Manager("manager/dashboard", $data);
    }
}
