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
            
            $data['bulanIni'] = date("F"); 
            $data['tahunIni'] = date("Y"); 

            $bulanDalamAngka = date("m"); 
            $tahunDalamAngka = date("Y"); 
            
            $jumlahKomplainTerkirim = $this->KomplainAModel->getTotalKomplainTerkirimByUser($data['login']->NOMOR_INDUK);  
            $jumlahKomplainDiterimaByUser= $this->KomplainAModel->getTotalKomplainDiterimaByUser($data['login']->NOMOR_INDUK);  
            $jumlahKomplainDikerjakanByUser= $this->KomplainAModel->getTotalKomplainSedangDitanganiByUser($data['login']->NOMOR_INDUK);   

            $listKomplainDikirimBulanIniByUser =  $this->KomplainAModel->fetchKomplainBulanIniByUser($data['login']->NOMOR_INDUK,$bulanDalamAngka,$tahunDalamAngka);   

            $listKomplainOnGoingByUser =  $this->KomplainAModel->fetchKomplainPenugasanByUser($data['login']->NOMOR_INDUK);   
        
            // die_dump($listKomplainDikirimBulanIniByUser);
        
            $data['bulanDalamAngka'] = $bulanDalamAngka;
            $data['tahunDalamAngka'] = $tahunDalamAngka;
            $data['jumlahKomplainTerkirim'] = $jumlahKomplainTerkirim;
            $data['jumlahKomplainDiterimaByUser'] = $jumlahKomplainDiterimaByUser;
            $data['jumlahKomplainDikerjakanByUser'] = $jumlahKomplainDikerjakanByUser;
            $data['listKomplainDikirimBulanIniByUser'] = $listKomplainDikirimBulanIniByUser;
            $data['listKomplainOnGoingByUser'] = $listKomplainOnGoingByUser; 
            loadView_User("user/dashboard", $data); 
 
        }
    }
