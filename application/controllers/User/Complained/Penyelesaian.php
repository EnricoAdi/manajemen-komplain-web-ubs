<?php
    //penyelesaian komplain yang ditugaskan kepada user 
    class Penyelesaian extends CI_Controller {
        public function __construct(){
            parent::__construct();
            $this->data['page_title'] = "Halaman Penyelesaian";
            $this->data['navigation'] = "Feedback";  

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
        $data['page_title'] = "Daftar Komplain Ditugaskan";
        $data['login'] = $this->UsersModel->getLogin();

        //fetch complain user tersebut yang statusnya PEND dan belum ada PENUGASAN
        $complains = $this->KomplainAModel->fetchByUserDitugaskan($data['login']->NOMOR_INDUK); 
        $data['complains'] = $complains;
         
        $this->load->view("templates/user/header", $data);
        $this->load->view("user/complained/penyelesaian/list", $data);
        $this->load->view("templates/user/footer", $data);
    }

    public function detail($nomor_komplain){ 
        $data = $this->data;
        $data['page_title'] = "Detail Komplain Ditugaskan";
        $data['login'] = $this->UsersModel->getLogin();
        
        $komplain = $this->KomplainAModel->get($nomor_komplain); 

        if($komplain==null){
            $this->session->set_flashdata('header', 'Pesan');
            $this->session->set_flashdata('message', 'Komplain tidak ditemukan');
            redirect('User/Complained/Penyelesaian');
        }
        $data['komplain'] = $komplain;  
        
        $this->load->view("templates/user/header", $data);
        $this->load->view("user/complained/penyelesaian/detail", $data);
        $this->load->view("templates/user/footer", $data);
    }
    public function addPage($nomor_komplain){ 
        $data = $this->data;
        $data['page_title'] = "Input Penyelesaian Komplain";
        $data['login'] = $this->UsersModel->getLogin();
        
        $komplain = $this->KomplainAModel->get($nomor_komplain); 

        if($komplain==null){
            $this->session->set_flashdata('header', 'Pesan');
            $this->session->set_flashdata('message', 'Komplain tidak ditemukan');
            redirect('User/Complained/Penyelesaian');
        }
        $data['komplain'] = $komplain;  
        
        $this->load->view("templates/user/header", $data);
        $this->load->view("user/complained/penyelesaian/tambah-detail", $data);
        $this->load->view("templates/user/footer", $data);

    }
    public function lampiranPage($nomor_komplain){ 
        $data = $this->data;
        $data['page_title'] = "Input Penyelesaian Komplain";
        $data['login'] = $this->UsersModel->getLogin();
        
        $komplain = $this->KomplainAModel->get($nomor_komplain); 

        if($komplain==null){
            $this->session->set_flashdata('header', 'Pesan');
            $this->session->set_flashdata('message', 'Komplain tidak ditemukan');
            redirect('User/Complained/Penyelesaian');
        }
        $data['komplain'] = $komplain;  
        
        $data['akar'] = $this->session->userdata('akar');
        $data['preventif'] = $this->session->userdata('preventif');
        $data['korektif']= $this->session->userdata('korektif');
        $data['tanggalDeadline'] = $this->session->userdata('tanggalDeadline');

        $this->load->view("templates/user/header", $data);
        $this->load->view("user/complained/penyelesaian/tambah-detail", $data);
        $this->load->view("templates/user/footer", $data);

    }
    public function addPenyelesaianPage1Process($nomor_komplain){ 
        $komplain = $this->KomplainAModel->get($nomor_komplain); 

        if($komplain==null){
            $this->session->set_flashdata('header', 'Pesan');
            $this->session->set_flashdata('message', 'Komplain tidak ditemukan');
            redirect('User/Complained/Penyelesaian');
        }
        $akar = $this->input->post('akar-masalah');
        $preventif = $this->input->post('preventif');
        $korektif= $this->input->post('korektif');
        $tanggalDeadline = $this->input->post('tanggal');
        
        $tanggalHariIni = date('Y-m-d');

        $this->session->set_userdata('akar', $akar);
        $this->session->set_userdata('preventif', $preventif);
        $this->session->set_userdata('korektif', $korektif); 

        if($tanggalDeadline < $tanggalHariIni){
            $this->session->set_flashdata('header', 'Pesan');
            $this->session->set_flashdata('message', 'Tanggal deadline tidak boleh kurang dari hari ini');
            redirect('User/Complained/Penyelesaian/addPage/'.$nomor_komplain);
        }

    }
}