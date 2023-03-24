<?php
    //done penyelesaian komplain yang ditujukan kepada departemen user 
    class Done extends CI_Controller {
        public function __construct(){
            parent::__construct();
            $this->data['page_title'] = "Halaman Done Penyelesaian Komplain";
            $this->data['navigation'] = "Complained";  
 
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
        $data['page_title'] = "Halaman Done Penyelesaian Komplain";
        $data['login'] = $this->UsersModel->getLogin();

        //fetch complain user tersebut yang statusnya PEND dan sudah ada PENUGASAN, sudah ada tindakan korektif dkk, dan belum ada TGL_DONE dan USER_DONE
        $complains = $this->KomplainAModel->fetchComplainSudahDiisi($data['login']->KODE_DIVISI);  
        $data['complains'] = $complains;
         
        $this->load->view("templates/user/header", $data);
        $this->load->view("user/complained/done/list", $data);
        $this->load->view("templates/user/footer", $data);
    }
    public function detail($nomor_komplain){
        
        $data = $this->data;
        $data['page_title'] = "Detail Penyelesaian Komplain";
        $data['login'] = $this->UsersModel->getLogin();
        
        $komplain = $this->KomplainAModel->get($nomor_komplain); 

        if($komplain==null){
            $this->session->set_flashdata('header', 'Pesan');
            $this->session->set_flashdata('message', 'Komplain tidak ditemukan');
            redirect('User/Complained/Done');
        }
        $data['komplain'] = $komplain;  
        
        $this->load->view("templates/user/header", $data);
        $this->load->view("user/complained/done/detail", $data);
        $this->load->view("templates/user/footer", $data);
    }
    public function successProcess($nomor_komplain){

        $komplain = $this->KomplainAModel->get($nomor_komplain); 

        if($komplain==null){
            $this->session->set_flashdata('header', 'Pesan');
            $this->session->set_flashdata('message', 'Komplain tidak ditemukan');
            redirect('User/Complained/Done');
        }
        $komplain->USER_DONE = $this->UsersModel->getLogin()->NOMOR_INDUK;
        $komplain->TGL_DONE =  date('Y-m-d'); 
        $komplain->donePenyelesaianKomplain();
 
        $subtopik2 = $komplain->SUB_TOPIK2;
        $header = "Berhasil done penyelesaian komplain";
        $template = $this->templateEmailSuccessDone($header, $this->UsersModel->getLogin()->NAMA,
        $this->SubTopik2Model->get($subtopik2)->DESKRIPSI);

        $resultmail = send_mail($this->UsersModel->getLogin()->EMAIL, 
        $header, $template); 
        // $resultmail = true;

        if($resultmail){ 
          $this->session->set_flashdata('header', 'Pesan');
          $this->session->set_flashdata('message', 'Berhasil done penyelesaian komplain, silahkan cek email anda');
          redirect('User/Complained/Done'); 
      }else{ 
          $this->session->set_flashdata('message', 'Berhasil done penyelesaian komplain, namun gagal mengirim email');
          redirect('User/Complained/Penyelesaian');
      } 

    }
    public function deleteProcess($nomor_komplain){

        $komplain = $this->KomplainAModel->get($nomor_komplain); 

        if($komplain==null){
            $this->session->set_flashdata('header', 'Pesan');
            $this->session->set_flashdata('message', 'Komplain tidak ditemukan');
            redirect('User/Complained/Done');
        }
        $komplain->deleteDeadlinePenyelesaianKomplain();
        $komplainB = new KomplainBModel();
        $komplainB->NO_KOMPLAIN = $nomor_komplain;
        $komplainB->deletePenyelesaianKomplain();

        //delete lampiran 
        $lampiran = new LampiranModel();
        $lampiran->NO_KOMPLAIN = $nomor_komplain;
        $lampiran->deleteByKomplainForFeedback(); 

        //todo email
         
        $subtopik2 = $komplain->SUB_TOPIK2;
        $header = "Berhasil delete penyelesaian komplain";
        $template = $this->templateEmailDeleteDone($header, $this->UsersModel->getLogin()->NAMA,
        $this->SubTopik2Model->get($subtopik2)->DESKRIPSI);

        $resultmail = send_mail($this->UsersModel->getLogin()->EMAIL, 
        $header, $template); 
        // $resultmail = true;

        if($resultmail){ 
          $this->session->set_flashdata('header', 'Pesan');
          $this->session->set_flashdata('message', 'Berhasil delete penyelesaian komplain, silahkan cek email anda');
          redirect('User/Complained/Done');
      }else{ 
          $this->session->set_flashdata('message', 'Berhasil delete penyelesaian komplain, namun gagal mengirim email');
          redirect('User/Complained/Penyelesaian');
      }
    }
    public function templateEmailSuccessDone($header,$nama, $subtopik2){
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
              <p>Sistem mencatat anda menyelesaikan pemberian feedback terhadap komplain untuk subtopik $subtopik2. Terima kasih atas kerja sama anda.</p> 
            </div>
            <footer>
              <p>&copy; PT UBS - SIB ISTTS</p>
            </footer>
          </body>
        </html>"; 
   }

   public function templateEmailDeleteDone($header,$nama, $subtopik2){
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
          <p>Sistem mencatat anda menghapus pemberian feedback terhadap komplain untuk subtopik $subtopik2.</p> 
        </div>
        <footer>
          <p>&copy; PT UBS - SIB ISTTS</p>
        </footer>
      </body>
    </html>"; 
}
}