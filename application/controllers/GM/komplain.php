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

        middleware_auth(3); //hak akses GM
        $this->data['login'] = $this->UsersModel->getLogin();
    }

    public function index(){ 
        $data = $this->data;
        $data['page_title'] = "Daftar Komplain Manager";

        $data['login'] = $this->UsersModel->getLogin(); 
        $divisi = "";

        $userLogin = $this->UsersModel->getLogin();
        $divisi = $userLogin->KODEDIV;
        $listKomplain = $this->KomplainAModel->loadGManagerKomplain(); 
        if($listKomplain==null){
            $listKomplain = "Belum ada";
        }
        
        $data['divisi'] = $divisi;
        $data['listKomplain'] = $listKomplain;
        loadView_GM("GM/komplain", $data);
    }
}
