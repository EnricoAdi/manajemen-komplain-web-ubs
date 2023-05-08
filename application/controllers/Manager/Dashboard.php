<?php
//Manager dashboard
class Dashboard extends CI_Controller
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
        $komplainUrgent = $this->KomplainAModel->loadManagerKomplainUrgent($divisi); 
        $komplainTerkirim = $this->KomplainAModel->loadManagerKomplainTerkirim($divisi);
        $komplainDiterima = $this->KomplainAModel->loadManagerKomplainDiterima($divisi);

        if($komplainUrgent==null){
            $komplainUrgent = "Belum ada";
        }else if($komplainTerkirim==null)
        {
            $komplainTerkirim = "Belum ada";
        }else if($komplainDiterima==null)
        {
            $komplainDiterima = "Belum ada";
        }
        
        $data['divisi'] = $divisi;
        $data['komplainUrgent'] = $komplainUrgent;
        $data['komplainTerkirim'] = $komplainTerkirim;
        $data['komplainDiterima'] = $komplainDiterima;

        loadView_Manager("manager/dashboard", $data);
    }
}
