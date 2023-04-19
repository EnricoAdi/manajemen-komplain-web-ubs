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
            
            $data['bulanIni'] = date("F"); 
            $data['tahunIni'] = date("Y"); 
            $totalKomplainBulanIni = 10;
            $divisiTerbanyak = "Kalung";
            $data['totalKomplainBulanIni'] = $totalKomplainBulanIni;
            $data['divisiTerbanyak'] = $divisiTerbanyak;
            loadView_Admin("admin/dashboard", $data);  
        }
    }
?>

