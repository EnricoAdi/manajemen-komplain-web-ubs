<?php
//Manager dashboard
class komplain extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->data['page_title'] = "Manager Page";
        $this->data['navigation'] = "Dashboard";

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
        $listKomplain = $this->KomplainAModel->loadGManagerKomplain(); 
        if($listKomplain==null){
            $listKomplain = "Belum ada";
        }
        
        $data['divisi'] = $divisi;
        $data['listKomplain'] = $listKomplain;
        loadView_GM("GM/komplain", $data);
    }
}
