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

            $template = $this->templateEmail($header, $this->UsersModel->getLogin()->NAMA,
            $message);
   
            $resultmail = send_mail($this->UsersModel->getLogin()->EMAIL, 
            $header, $template); 

        }else if($keputusan=='cancel'){
            //update komplainA
            $komplain->TGL_CANCEL = $today;
            $komplain->USER_CANCEL = $this->UsersModel->getLogin()->NOMOR_INDUK;
            $komplain->updateCancelKomplain();

            
            $header = "Sukses membatalkan penyelesaian komplain";
            $message = "Sistem telah mencatat anda melakukan pembatalan (cancel) atas komplain $nomor_komplain, terima kasih.";
            $template = $this->templateEmail($header, $this->UsersModel->getLogin()->NAMA,
            $message);

        }else{
            //validasi
            //update komplainA
            $komplain->TGL_VALIDASI = $today;
            $komplain->USER_VALIDASI = $this->UsersModel->getLogin()->NOMOR_INDUK;
            $komplain->updateValidasiKomplain(); 
           
            $header = "Sukses memvalidasi penyelesaian komplain";
            $message = "Sistem telah mencatat anda telah melakukan validasi atas komplain $nomor_komplain, terima kasih atas kerja sama anda.";
            $template = $this->templateEmail($header, $this->UsersModel->getLogin()->NAMA,
            $message);
   
            $resultmail = send_mail($this->UsersModel->getLogin()->EMAIL, 
            $header, $template); 
        }
        if($resultmail==true){ 
            $this->session->set_flashdata('header', 'Pesan');
            $this->session->set_flashdata('message', 'Berhasil memberikan keputusan pada penyelesaian komplain, silahkan cek email anda');
            redirect('User/Complain/Solved');
        }else{
            $this->session->set_flashdata('header', 'Peringatan');
            $this->session->set_flashdata('message', 'Berhasil memberikan keputusan pada penyelesaian komplain, namun gagal mengirim email');
            redirect('User/Complain/Solved');
        }
    }

    public function templateEmail($header,$nama, $message){
        return "<!DOCTYPE html>
        <html>
          <head>
            <meta charset='utf-8'>
            <title>$header</title>
            <style> 
              * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
              }
               
              body {
                font-family: Arial, sans-serif;
                color: #333;
              } 
              header {
                background-color: #f5f5f5;
                padding: 20px;
                text-align: center;
              }
              
              header h1 {
                font-size: 32px;
                margin-bottom: 20px;
              }
               
              .content {
                padding: 20px;
              }
               
              .cta-button {
                display: inline-block;
                background-color: #337ab7;
                color: #fff;
                border-radius: 4px;
                padding: 10px 20px;
                text-decoration: none;
                margin-top: 20px;
              }
              
              .cta-button:hover {
                background-color: #23527c;
              }
               
              footer {
                background-color: #f5f5f5;
                padding: 20px;
                text-align: center;
                font-size: 14px;
              }
            </style>
          </head>
          <body>
            <header>
              <h1>$header</h1>
            </header>
            <div class='content'>
              <p>Halo, $nama!</p>
              <br>
              <p>$message</p> 
            </div>
            <footer>
              <p>&copy; PT UBS - SIB ISTTS</p>
            </footer>
          </body>
        </html>"; 
   }
}