<?php 
    class PerTopik extends CI_Controller{
        
        public function __construct(){
            parent::__construct();
            $this->data['page_title'] = "Admin Page"; 
            $this->data['navigation'] = "Laporan"; 
            
            $this->load->library("form_validation");   


            middleware_auth(4); //hak akses admin

        }
        
        public function index(){
            
            $data = $this->data;
            $data['page_title'] = "Laporan Per Topik";
            $data['login'] = $this->UsersModel->getLogin();
            $dateNow = date("Y-m-d");
            $data['dateNow'] = $dateNow;
            $this->load->view("templates/admin/header", $data);
            $this->load->view("admin/laporan/per-topik", $data);
            $this->load->view("templates/admin/footer", $data);
        }
    }
