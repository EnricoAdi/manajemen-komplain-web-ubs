<?php 
    class JumlahKomplain extends CI_Controller{
        
        public function __construct(){
            parent::__construct();
            $this->data['page_title'] = "Admin Page"; 
            $this->data['navigation'] = "Laporan"; 
            $this->data['login'] = $this->UsersModel->getLogin();
               

            middleware_auth(4); //hak akses admin

        }
        public function index(){ 
            $data = $this->data;

            $data['page_title'] = "Laporan Jumlah Komplain";
            $data['departemens'] = $this->DivisiModel->fetch();
            $data['selectedDepartemen'] =  $data['departemens'][0];
 
            $data['yearnow'] = date("Y"); 
            
            $data['bulanIni'] = date("F");  

            $bulanDalamAngka = date("m"); 
            $tahunDalamAngka = date("Y"); 

            $data['bulanDalamAngka'] = $bulanDalamAngka;
            $data['tahunDalamAngka'] = $tahunDalamAngka;
            
            loadView_Admin("admin/laporan/jumlah-komplain", $data); 
        }
    }
