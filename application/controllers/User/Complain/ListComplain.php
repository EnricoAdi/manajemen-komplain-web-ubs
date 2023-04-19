<?php
    //list komplain diajukan user 
    class ListComplain extends CI_Controller {
        public function __construct(){
            parent::__construct();
            $this->data['page_title'] = "User Page";
            $this->data['navigation'] = "Complain";  
            middleware_auth(1); //hak akses user 

            $this->data['login'] = $this->UsersModel->getLogin();
            
            $this->load->model('UsersModel');
            $this->load->library("form_validation");  
            $this->load->library('session'); 

           

        }
        
        public function index(){
            $data = $this->data;
            $data['page_title'] = "Daftar Komplain Diajukan";
            

            //todo fetch complain user tersebut
            $complains = $this->KomplainAModel->fetchFromUser($data['login']->NOMOR_INDUK,'all'); 
            $data['complains'] = $complains;
            
            $this->load->view("templates/user/header", $data);
            $this->load->view("user/complain/index", $data);
            $this->load->view("templates/user/footer", $data);
 
        }
        public function DeleteComplain($no_komplain){
            
            $complainA = new KomplainAModel();
            $complainA->NO_KOMPLAIN = $no_komplain;

            $komplain = $this->KomplainAModel->get($no_komplain);
            $topik = $komplain->TOPIK; 
            $subtopik1 = $komplain->SUB_TOPIK1;
            $subtopik2 = $komplain->SUB_TOPIK2;   

            $template = $this->templateEmailSuccessDelete($this->UsersModel->getLogin()->NAMA,
                $this->SubTopik2Model->get($topik,$subtopik1,$subtopik2)->DESKRIPSI  );
       
            $resultmail = send_mail($this->UsersModel->getLogin()->EMAIL, 
            'Notifikasi Penghapusan Komplain', $template); 

            if($resultmail){ 
                $lampiran = new LampiranModel();
                $lampiran->NO_KOMPLAIN = $no_komplain;
                $lampiran->deleteByKomplain($no_komplain);
                
                $complainB = new KomplainBModel();
                $complainB->NO_KOMPLAIN = $no_komplain;
                $complainB->delete();

                $complainA->delete();

                $this->session->set_flashdata('header', 'Pesan');
                $this->session->set_flashdata('message', 'Komplain berhasil dihapus, silahkan cek email anda');
                redirect('User/Complain/ListComplain');
            }else{ 
                $this->session->set_flashdata('header', 'Pesan');
                $this->session->set_flashdata('message', 'Komplain gagal dihapus (email tidak terkirim)');
                redirect('User/Complain/ListComplain');
            }
        }


        public function templateEmailSuccessDelete($nama, $subtopik2){
            return "<!DOCTYPE html>
            <html>
              <head>
                <meta charset='utf-8'>
                <title>Sukses Menghapus Komplain</title>
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
                    background-color: #FFD7D7;
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
                  <h1>Notifikasi Berhasil Hapus Komplain</h1>
                </header>
                <div class='content'>
                  <p>Halo, $nama</p>
                  <br>
                  <p>Sistem mencatat anda telah menghapus sebuah komplain terkait $subtopik2.</p> 
                </div>
                <footer>
                  <p>&copy; PT UBS - SIB ISTTS</p>
                </footer>
              </body>
            </html>";
           // $this->load->view("email/success-add-complain");
       }
    }
?>

