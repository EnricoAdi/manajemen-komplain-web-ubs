<?php
    //penugasan komplain yang ditujukan kepada user 
    class Penugasan extends CI_Controller {
        public function __construct(){
            parent::__construct();
            $this->data['page_title'] = "Halaman Penugasan";
            $this->data['navigation'] = "Complained";  

            middleware_auth(1); //hak akses user 
            $this->data['login'] = $this->UsersModel->getLogin();
            $this->load->model('UsersModel');
            $this->load->library("form_validation");  
            $this->load->library('session');  
    }

    public function index(){ 
        $data = $this->data;
        $data['page_title'] = "Penugasan"; 

        //fetch complain user tersebut yang statusnya PEND dan belum ada PENUGASAN
        $complains = $this->KomplainAModel->fetchForDivisi($data['login']->KODEDIV,'PEND'); 
        $data['complains'] = $complains;
         
        $this->load->view("templates/user/header", $data);
        $this->load->view("user/complained/list-penugasan", $data);
        $this->load->view("templates/user/footer", $data);
    }

    public function addPage($nomor_komplain){
        
        $data = $this->data;
        $data['page_title'] = "Input Penugasan";
        

        //fetch complain user tersebut yang statusnya PEND dan belum ada PENUGASAN
        $komplain = $this->KomplainAModel->get($nomor_komplain); 
        middleware_komplainA($nomor_komplain,'User/Complained/Penugasan');
         
        $data['komplain'] = $komplain;  
        
        //fetch list user sedivisi 
        $users = $this->UsersModel->fetchUsersByDivisi($data['login']->KODEDIV,'1');
        $data['users'] = $users;   

        $this->load->view("templates/user/header", $data);
        $this->load->view("user/complained/isi-penugasan", $data);
        $this->load->view("templates/user/footer", $data);
    }

    public function addPenugasan($nomor_komplain){
        $komplain = $this->KomplainAModel->get($nomor_komplain); 
        middleware_komplainA($nomor_komplain,'User/Complained/Penugasan');
         
        if($komplain->PENUGASAN != null){ 
            $this->session->set_flashdata('header', 'Pesan');
            $this->session->set_flashdata('message', 'Penugasan sudah ada');
            redirect("User/Complained/Penugasan/addPage/$nomor_komplain");
        }
        $user =  $this->input->post("user");

        $komplain->PENUGASAN = $user;
        $komplain->updatePenugasanKomplain();
        
        $this->session->set_flashdata('header', 'Pesan');
        $this->session->set_flashdata('message', 'Berhasil Menyimpan Penugasan');
        redirect("User/Complained/Penugasan/addPage/$nomor_komplain");
    }
    public function hapusPenugasan($nomor_komplain){
        $komplain = $this->KomplainAModel->get($nomor_komplain);
        middleware_komplainA($nomor_komplain,'User/Complained/Penugasan');
         
        if($komplain->PENUGASAN == null){ 
            $this->session->set_flashdata('header', 'Pesan');
            $this->session->set_flashdata('message', 'Belum ada data penugasan');
            redirect("User/Complained/Penugasan/addPage/$nomor_komplain");
        }
        $komplain->updateHapusPenugasanKomplain();
        
        $this->session->set_flashdata('header', 'Pesan');
        $this->session->set_flashdata('message', 'Berhasil Menghapus Penugasan');
        redirect("User/Complained/Penugasan/addPage/$nomor_komplain");
    }
}