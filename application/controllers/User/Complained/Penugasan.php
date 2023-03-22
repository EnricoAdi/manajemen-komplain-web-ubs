<?php
    //penugasan komplain yang ditujukan kepada user 
    class Penugasan extends CI_Controller {
        public function __construct(){
            parent::__construct();
            $this->data['page_title'] = "Halaman Penugasan";
            $this->data['navigation'] = "Complained";  

            $this->load->model('UsersModel');
            $this->load->library("form_validation");  
            $this->load->library('session'); 

            //middleware
            if($this->UsersModel->getLogin() == null){ 
                $this->session->set_flashdata('header', 'Pesan');
                $this->session->set_flashdata('message', 'Silahkan Login Terlebih Dahulu');
                redirect('Auth');
            }

            //jika tidak ada akses, maka redirect ke halaman dashboard berdasarkan hak aksesnya
            $hak_akses = $this->UsersModel->getLogin()->KODE_HAK_AKSES;
            if($hak_akses!=1){
                if ($hak_akses == '4') {  
                    redirect('Admin/Dashboard'); //admin
                }
                if ($hak_akses == '2') { 
                    redirect('Manager'); //manager
                }
                else { 
                    redirect('GM'); //general manager
            }
        }

    }

    public function index(){ 
        $data = $this->data;
        $data['page_title'] = "Penugasan";
        $data['login'] = $this->UsersModel->getLogin();

        //fetch complain user tersebut yang statusnya PEND dan belum ada PENUGASAN
        $complains = $this->KomplainAModel->fetchForDivisi($data['login']->KODE_DIVISI,'PEND'); 
        $data['complains'] = $complains;
         
        $this->load->view("templates/user/header", $data);
        $this->load->view("user/complained/list-penugasan", $data);
        $this->load->view("templates/user/footer", $data);
    }

    public function addPage($nomor_komplain){
        
        $data = $this->data;
        $data['page_title'] = "Input Penugasan";
        $data['login'] = $this->UsersModel->getLogin();

        //fetch complain user tersebut yang statusnya PEND dan belum ada PENUGASAN
        $komplain = $this->KomplainAModel->get($nomor_komplain); 
        $data['komplain'] = $komplain;  
        
        //fetch list user sedivisi 
        $users = $this->UsersModel->fetchUsersByDivisi($data['login']->KODE_DIVISI,'1');
        $data['users'] = $users;  

        $this->load->view("templates/user/header", $data);
        $this->load->view("user/complained/isi-penugasan", $data);
        $this->load->view("templates/user/footer", $data);
    }
}