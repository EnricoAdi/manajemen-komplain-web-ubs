<?php
    //dashboard user 
    class Dashboard extends CI_Controller {
        public function __construct(){
            parent::__construct();
            $this->data['page_title'] = "User Page";
            $this->data['navigation'] = "Dashboard";  

            middleware_auth(1); //hak akses user 
            $this->data['login'] = $this->UsersModel->getLogin(); 
            $this->load->library("form_validation");  
            $this->load->library('session'); 

        }
        
        public function index(){
            $data = $this->data;
            $data['page_title'] = "Dashboard End User";
            

            $this->load->view("templates/user/header", $data);
            $this->load->view("user/dashboard", $data);
            $this->load->view("templates/user/footer", $data);
 
        }
    }
?>

