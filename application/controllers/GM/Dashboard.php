<?php
//GM dashboard
class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->data['page_title'] = "GM Page";
        $this->data['navigation'] = "Dashboard";

        $this->load->library("form_validation");


        middleware_auth(3); //hak akses GM
        $this->data['login'] = $this->UsersModel->getLogin();
    }

    public function index()
    {
        $data = $this->data;
        $data['page_title'] = "Dashboard GM";

        $data['login'] = $this->UsersModel->getLogin(); 
        $divisi = "";

        $userLogin = $this->UsersModel->getLogin();
        $divisi = $userLogin->KODEDIV;
        $komplainUrgent = $this->KomplainAModel->loadGManagerKomplainUrgent(); 
        $komplainTerkirim = $this->KomplainAModel->loadGManagerKomplainTerkirim();
        $komplainDiterima = $this->KomplainAModel->loadGManagerKomplainDiterima();

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

        loadView_GM("GM/dashboard", $data);
    }
}
