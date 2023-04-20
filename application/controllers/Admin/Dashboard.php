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

            $bulanDalamAngka = date("m"); 
            $tahunDalamAngka = date("Y"); 
            
            $totalKomplainBulanIni = $this->KomplainAModel->getTotalKomplainByMonth($bulanDalamAngka, $tahunDalamAngka); 
            $divisiTerbanyak = $this->KomplainAModel->divisiKomplainTerbanyakByMonth($bulanDalamAngka, $tahunDalamAngka);


            if($divisiTerbanyak==null){
                $divisiTerbanyak = "Belum ada";
            }else{
                $divisiTerbanyak = $divisiTerbanyak->NAMA;
            } 

            $jumlahKomplainDivisiByMonth = $this->KomplainAModel->jumlahKomplainDivisiByMonth($bulanDalamAngka, $tahunDalamAngka);
 
            $data['bulanDalamAngka'] = $bulanDalamAngka;
            $data['tahunDalamAngka'] = $tahunDalamAngka;
            $data['totalKomplainBulanIni'] = $totalKomplainBulanIni;
            $data['divisiTerbanyak'] = $divisiTerbanyak;
            loadView_Admin("admin/dashboard", $data);  
        }
        public function jumlahKomplainDivisiByMonth($bulanDalamAngka, $tahunDalamAngka){
            $res = getjumlahKomplainDivisiByMonth($bulanDalamAngka, $tahunDalamAngka);
            echo json_encode($res);
        }
        public function jumlahKomplainMasukByYear($tahunDalamAngka){
            $res = getjumlahKomplainMasukByYear($tahunDalamAngka);
            echo json_encode($res);
        }
    }
?>

