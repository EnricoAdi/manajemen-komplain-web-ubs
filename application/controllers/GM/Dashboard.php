<?php
//GM dashboard
class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->data['page_title'] = "GM Page";
        $this->data['navigation'] = "Dashboard";

        $this->load->library("form_validation");


        middleware_auth(3); //hak akses GM
        $this->data['login'] = $this->UsersModel->getLogin();
    }

    public function index()
    {
        $data = $this->data;
        $data['page_title'] = "Dashboard GM";
        loadView_GM("GM/dashboard", $data);
    }
}
