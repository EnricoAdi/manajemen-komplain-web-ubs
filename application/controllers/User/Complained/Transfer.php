<?php
    //transfer komplain yang ditujukan kepada user 
    class Transfer extends CI_Controller {
        public function __construct(){
            parent::__construct();
            $this->data['page_title'] = "User Page";
            $this->data['navigation'] = "ComplainedList";  

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

        public function index($nomor_komplain){
            $data = $this->data;
            $data['page_title'] = "Transfer Komplain";
            $data['login'] = $this->UsersModel->getLogin();
            
            $komplain = $this->KomplainAModel->get($nomor_komplain); 
    
            if($komplain==null){
                $this->session->set_flashdata('header', 'Pesan');
                $this->session->set_flashdata('message', 'Komplain tidak ditemukan');
                redirect('User/Complained/ListComplained');
            }   
            $subtopics = $this->SubTopik2Model->fetch(); 
            $data['komplain'] = $komplain;  

            $subtopik2 = $komplain->SUB_TOPIK2;

            $data['subtopics'] = $subtopics; 
            $data['subtopik2'] = $subtopik2; 

            $this->load->view("templates/user/header", $data);
            $this->load->view("user/complained/transfer", $data);
            $this->load->view("templates/user/footer", $data);
        }
        public function processTransfer($nomor_komplain){ 
            $komplain = $this->KomplainAModel->get($nomor_komplain); 
    
            if($komplain==null){
                $this->session->set_flashdata('header', 'Pesan');
                $this->session->set_flashdata('message', 'Komplain tidak ditemukan');
                redirect('User/Complained/ListComplained');
            }   
            //process transfer komplain
            $topik = $this->input->post('inputTopik');
            $subTopik1 = $this->input->post('inputSubtopik1');
            $subTopik2 = $this->input->post('inputSubtopik2'); 
            $komplain->TOPIK = $topik;
            $komplain->SUB_TOPIK1 = $subTopik1;
            $komplain->SUB_TOPIK2 = $subTopik2;
            $komplain->updateTransferKomplain(); 
            
            $header = "Sukses melakukan transfer komplain";
            $message = "Sistem telah mencatat anda melakukan transfer atas komplain $nomor_komplain, terima kasih.";
            $template = $this->templateEmail($header, $this->UsersModel->getLogin()->NAMA,
            $message);
            
            $resultmail = send_mail($this->UsersModel->getLogin()->EMAIL, 
            $header, $template); 
            if($resultmail==false){
                $this->session->set_flashdata('header', 'Pesan');
                $this->session->set_flashdata('message', 'Berhasil transfer komplain, namun gagal mengirim email');
                redirect('User/Complained/ListComplained');
            }else{ 
                $this->session->set_flashdata('header', 'Pesan');
                $this->session->set_flashdata('message', 'Berhasil transfer komplain, silahkan cek email');
                redirect('User/Complained/ListComplained');
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