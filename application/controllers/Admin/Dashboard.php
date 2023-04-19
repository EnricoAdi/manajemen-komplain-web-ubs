<?php
    //admin dashboard
    class Dashboard extends CI_Controller {
        public function __construct(){
            parent::__construct();
            $this->data['page_title'] = "Admin Page"; 
            $this->data['navigation'] = "Dashboard"; 
            
            $this->load->library("form_validation");   


           middleware_auth(4); //hak akses admin

        }
        
        public function index(){
            $data = $this->data;
            $data['page_title'] = "Dashboard Admin";
            $data['login'] = $this->UsersModel->getLogin(); 
 
            $this->load->view("templates/admin/header", $data);
            $this->load->view("admin/dashboard", $data);
            $this->load->view("templates/admin/footer", $data);
 
        }
    }
?>

