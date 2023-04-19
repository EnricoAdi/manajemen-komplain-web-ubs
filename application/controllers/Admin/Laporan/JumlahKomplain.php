<?php 
    class JumlahKomplain extends CI_Controller{
        
        public function __construct(){
            parent::__construct();
            $this->data['page_title'] = "Admin Page"; 
            $this->data['navigation'] = "Laporan"; 
            
            $this->load->library("form_validation");   


            middleware_auth(4); //hak akses admin

        }
        public function index(){
            
            $data = $this->data;
            $data['page_title'] = "Laporan Jumlah Komplain";
            $data['login'] = $this->UsersModel->getLogin();
            $data['departemens'] = $this->DivisiModel->fetch();

            $yearnow = date("Y"); 
            $data['yearnow'] = $yearnow;
            $this->load->view("templates/admin/header", $data);
            $this->load->view("admin/laporan/jumlah-komplain", $data);
            $this->load->view("templates/admin/footer", $data);
        }
    }
