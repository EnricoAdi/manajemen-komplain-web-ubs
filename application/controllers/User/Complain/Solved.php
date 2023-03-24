<?php
    //untuk validasi komplain yang diajukan oleh departemen user tersebut 
    class Solved extends CI_Controller {
        public function __construct(){
            parent::__construct();
            $this->data['page_title'] = "Halaman Penyelesaian Komplain Diterima";
            $this->data['navigation'] = "Solved";  

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
        $data['page_title'] = "Halaman Daftar Penyelesaian Komplain Diterima";
        $data['login'] = $this->UsersModel->getLogin();

        //fetch complain user tersebut yang statusnya PEND dan belum ada PENUGASAN
        $complains = $this->KomplainAModel->fetchKomplainDone($data['login']->NOMOR_INDUK); 
        $data['complains'] = $complains;
         
        $this->load->view("templates/user/header", $data);
        $this->load->view("user/complain/solved/list", $data);
        $this->load->view("templates/user/footer", $data);
    }
    public function detail($nomor_komplain){
        
        $data = $this->data;
        $data['page_title'] = "Halaman Detail Penyelesaian Komplain Diterima";
        $data['login'] = $this->UsersModel->getLogin();

        $this->load->view("templates/user/header", $data);
        $this->load->view("user/complain/solved/detail", $data);
        $this->load->view("templates/user/footer", $data);
    }
}