<?php
//Manager dashboard
class Komplain extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->data['page_title'] = "Manager Page";
        $this->data['navigation'] = "Komplain";

        $this->load->library("form_validation"); 

        middleware_auth(2); //hak akses manager
        $this->data['login'] = $this->UsersModel->getLogin();
    }

    public function index(){ 
        $data = $this->data;
        $data['page_title'] = "Dashboard Manager";

        $data['login'] = $this->UsersModel->getLogin(); 
        $divisi = "";

        $userLogin = $this->UsersModel->getLogin();
        $divisi = $userLogin->KODEDIV;
        $listKomplain = $this->KomplainAModel->loadManagerKomplain($divisi); 
        if($listKomplain==null){
            $listKomplain = "Belum ada";
        }
        
        $data['divisi'] = $divisi;
        $data['listKomplain'] = $listKomplain;
        loadView_Manager("manager/komplain", $data);
    }
}
