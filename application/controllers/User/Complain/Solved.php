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

            middleware_auth(1); //hak akses user 
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
        $komplain = $this->KomplainAModel->get($nomor_komplain);

        if($komplain==null){
            $this->session->set_flashdata('header', 'Pesan');
            $this->session->set_flashdata('message', 'Komplain tidak ditemukan');
            redirect('User/Complain/Solved');
        }
        $data['komplain'] = $komplain;

        $this->load->view("templates/user/header", $data);
        $this->load->view("user/complain/solved/detail", $data);
        $this->load->view("templates/user/footer", $data);
    }
    public function solveProcess($nomor_komplain){
        $komplain = $this->KomplainAModel->get($nomor_komplain);

        if($komplain==null){
            $this->session->set_flashdata('header', 'Pesan');
            $this->session->set_flashdata('message', 'Komplain tidak ditemukan');
            redirect('User/Complain/Solved');
        }
        $keputusan = $this->input->post('keputusan');
        $permintaanBanding = $this->input->post('permintaanBanding');
         
        $today = date('Y-m-d'); 
        
        $resultmail = false;
        $resultmailRecepient = false;
 
        //isi apabila banding
        if($keputusan=='banding'){
            if($permintaanBanding==''){
                $this->session->set_flashdata('header', 'Pesan');
                $this->session->set_flashdata('message', 'Permintaan banding harus diisi');
                redirect('User/Complain/Solved/detail'.$nomor_komplain);
            }
            $komplainB = new KomplainBModel();
            $komplainB->KEBERATAN = $permintaanBanding;
            $komplainB->updateBandingKomplain();

            //update komplainA
            $komplain->TGL_BANDING = $today;
            $komplain->USER_BANDING = $this->UsersModel->getLogin()->NOMOR_INDUK;
            $komplain->updateBandingKomplain();
 
            $header = "Sukses melakukan banding penyelesaian komplain";
            $message = "Sistem telah mencatat anda melakukan banding atas komplain $nomor_komplain, dengan keluhan $permintaanBanding. Mohon ditunggu untuk tindakan lanjutan dari divisi bersangkutan. Terima kasih.";

            $template = templateEmail($header, $this->UsersModel->getLogin()->NAMA,
            $message);
   
            $resultmail = send_mail($this->UsersModel->getLogin()->EMAIL, 
            $header, $template);  
            
            $headerRecipient = "Sukses melakukan banding penyelesaian komplain";
            $messageRecipient = "Sistem telah mencatat anda mendapatkan banding atas komplain $nomor_komplain, dengan keluhan $permintaanBanding. Mohon menindaklanjuti permintaan divisi bersangkutan. Terima kasih.";

            $templateRecipient =  templateEmail($headerRecipient, $komplain->PENERBIT->NAMA,
            $messageRecipient);

            $resultmailRecepient = send_mail($komplain->PENERBIT->EMAIL, 
            $headerRecipient, $templateRecipient); 

        }else if($keputusan=='cancel'){
            //update komplainA
            $komplain->TGL_CANCEL = $today;
            $komplain->USER_CANCEL = $this->UsersModel->getLogin()->NOMOR_INDUK;
            $komplain->updateCancelKomplain();

            
            $header = "Sukses membatalkan penyelesaian komplain";
            $message = "Sistem telah mencatat anda melakukan pembatalan (cancel) atas komplain $nomor_komplain, terima kasih.";
            $template = templateEmail($header, $this->UsersModel->getLogin()->NAMA,
            $message);
            
            $resultmail = send_mail($this->UsersModel->getLogin()->EMAIL, 
            $header, $template); 

            
            $headerRecipient = "Pembatalan penyelesaian komplain";
            $messageRecipient = "Sistem telah mencatat terdapat pembatalan penyelesaian komplain atas komplain dengan nomor $nomor_komplain.";

            $templateRecipient =  templateEmail($headerRecipient, $komplain->PENERBIT->NAMA,
            $messageRecipient);

            $resultmailRecepient = send_mail($komplain->PENERBIT->EMAIL, 
            $headerRecipient, $templateRecipient); 

        }else{
            //validasi
            //update komplainA
            $komplain->TGL_VALIDASI = $today;
            $komplain->USER_VALIDASI = $this->UsersModel->getLogin()->NOMOR_INDUK;
            $komplain->updateValidasiKomplain(); 
           
            $header = "Sukses memvalidasi penyelesaian komplain";
            $message = "Sistem telah mencatat anda telah melakukan validasi atas komplain $nomor_komplain, terima kasih atas kerja sama anda.";
            $template = templateEmail($header, $this->UsersModel->getLogin()->NAMA,
            $message);
   
            $resultmail = send_mail($this->UsersModel->getLogin()->EMAIL, 
            $header, $template); 

            
            $headerRecipient = "Validasi penyelesaian komplain";
            $messageRecipient = "Sistem telah mencatat terdapat validasi penyelesaian komplain atas komplain dengan nomor $nomor_komplain.";

            $templateRecipient =  templateEmail($headerRecipient, $komplain->PENERBIT->NAMA,
            $messageRecipient);

            $resultmailRecepient = send_mail($komplain->PENERBIT->EMAIL, 
            $headerRecipient, $templateRecipient); 
        }
        if($resultmail==true && $resultmailRecepient==true){ 
            $this->session->set_flashdata('header', 'Pesan');
            $this->session->set_flashdata('message', 'Berhasil memberikan keputusan pada penyelesaian komplain, silahkan cek email anda');
            redirect('User/Complain/Solved');
        }else{
            $this->session->set_flashdata('header', 'Peringatan');
            $this->session->set_flashdata('message', 'Berhasil memberikan keputusan pada penyelesaian komplain, namun gagal mengirim email');
            redirect('User/Complain/Solved');
        }
    }

     
}