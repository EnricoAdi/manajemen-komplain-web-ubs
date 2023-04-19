<?php
    //list komplain yang ditujukan kepada user 
    class ListComplained extends CI_Controller {
        public function __construct(){
            parent::__construct();
            $this->data['page_title'] = "User Page";
            $this->data['navigation'] = "ComplainedList";  

            middleware_auth(1); //hak akses user 
            $this->data['login'] = $this->UsersModel->getLogin();

            $this->load->model('UsersModel');
            $this->load->library("form_validation");  
            $this->load->library('session'); 


        }
        public function index(){
            
            $data = $this->data;
            $data['page_title'] = "Daftar Komplain Diterima";
            

            //fetch complain user tersebut

            $complains = $this->KomplainAModel->fetchForDivisi($data['login']->KODEDIV,'OPEN'); 
            $data['complains'] = $complains; 
            
            $this->load->view("templates/user/header", $data);
            $this->load->view("user/complained/index", $data);
            $this->load->view("templates/user/footer", $data);
 
        }
        public function VerifikasiComplain($nomor_komplain){ 
            $komplain = $this->KomplainAModel->get($nomor_komplain);  
            $user_penerbit = $this->UsersModel->get($komplain->USER_PENERBIT);
            $divisi = $user_penerbit->NAMA_DIVISI;
            middleware_komplainA($nomor_komplain,'User/Complained/ListComplained');
         
            $komplain->USER_VERIFIKASI = $this->UsersModel->getLogin()->NOMOR_INDUK;
            $komplain->TGL_VERIFIKASI = date('Y-m-d');
            $komplain->updateVerifikasi();

            
            $template = $this->templateEmailSuccessVerify($this->UsersModel->getLogin()->NAMA,
            $divisi,  $komplain->DESKRIPSI_MASALAH);
   
            $resultmail = send_mail($this->UsersModel->getLogin()->EMAIL, 
            'Notifikasi Berhasil Verifikasi Komplain', $template); 

            if($resultmail){
                $this->session->set_flashdata('header', 'Pesan');
                $this->session->set_flashdata('message', 'Berhasil Verifikasi komplain, silakan cek email anda');
                redirect('User/Complained/ListComplained');
            }else{ 
                $this->session->set_flashdata('header', 'Pesan');
                $this->session->set_flashdata('message', 'Berhasil Verifikasi komplain, namun gagal mengirim email');
                redirect('User/Complained/ListComplained');
            }
        }

        public function templateEmailSuccessVerify($nama, $divisiPengirim, $deskripsi){
            return "<!DOCTYPE html>
            <html>
              <head>
                <meta charset='utf-8'>
                <title>Sukses Menambah Komplain</title>
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
                    background-color: #E6F7B7;
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
                  <h1>Notifikasi Berhasil Verifikasi Komplain </h1>
                </header>
                <div class='content'>
                  <p>Halo, $nama!</p>
                  <br>
                  <p>Sistem mencatat anda telah memverifikasi komplain dari divisi $divisiPengirim terkait $deskripsi. Silahkan melengkapi penugasan untuk penyelesaian komplain ini</p> 
                </div>
                <footer>
                  <p>&copy; PT UBS - SIB ISTTS</p>
                </footer>
              </body>
            </html>"; 
       }
    }