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
        
        $data['akar'] = $this->session->userdata('akar');
        $data['preventif'] = $this->session->userdata('preventif');
        $data['korektif']= $this->session->userdata('korektif');
        $data['tanggalDeadline'] = $this->session->userdata('tanggalDeadline');
      

        $this->load->view("templates/user/header", $data);
        $this->load->view("user/complained/penyelesaian/tambah-detail", $data);
        $this->load->view("templates/user/footer", $data);
    }
    public function editPage($nomor_komplain){ 
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
        $this->load->view("user/complained/penyelesaian/edit", $data);
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
        $this->load->view("user/complained/penyelesaian/tambah-lampiran", $data);
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
        }else{
            $this->session->set_userdata('tanggalDeadline', $tanggalDeadline);
            redirect('User/Complained/Penyelesaian/lampiranPage/'.$nomor_komplain);
        }


    }
    public function addProcess($nomor_komplain){
        $komplain = $this->KomplainAModel->get($nomor_komplain); 

        if($komplain==null){
            $this->session->set_flashdata('header', 'Pesan');
            $this->session->set_flashdata('message', 'Komplain tidak ditemukan');
            redirect('User/Complained/Penyelesaian');
        } 
        $akar = $this->session->userdata('akar');
        $preventif  = $this->session->userdata('preventif');
        $korektif = $this->session->userdata('korektif');
        $tanggalDeadline = $this->session->userdata('tanggalDeadline');

        
        $today = date('Y-m-d'); 
        
        if($akar==null || $preventif==null || $korektif==null || $tanggalDeadline==null){
            
            $this->session->set_flashdata('header', 'Pesan');
            $this->session->set_flashdata('message', 'Input tidak lengkap');
            redirect('User/Complained/Penyelesaian/addPage/'.$nomor_komplain);
        }else{
            //update deadline
            $komplain->TGL_DEADLINE = $tanggalDeadline;
            $komplain->updateDeadlinePenyelesaianKomplain();

            //update komplainB
            $komplainB = new KomplainBModel();
            $komplainB->NO_KOMPLAIN = $nomor_komplain;
            $komplainB->AKAR_MASALAH = $akar;
            $komplainB->T_PREVENTIF = $preventif;
            $komplainB->T_KOREKTIF = $korektif;
            $komplainB->updatePenyelesaianKomplain();

            //insert lampiran
            
            $lampirans = $_FILES["lampiran"];
            $isError = false;

            if($lampirans['name'][0]!=""){ 
                if (!file_exists('./uploads/')) {
                    mkdir('./uploads/', 0777, true);
                } 
                for($i=0;$i < count($lampirans['name']);$i++){
                    $getNewFileName = 'F_'. generateUID(25);
                    
                    if($i < count($lampirans)){ 
                        $_FILES['lampiran']['name'] = $lampirans['name'][$i];
                        $_FILES['lampiran']['type'] = $lampirans['type'][$i];
                        $_FILES['lampiran']['tmp_name'] = $lampirans['tmp_name'][$i];
                        $_FILES['lampiran']['error'] = $lampirans['error'][$i];
                        $_FILES['lampiran']['size'] = $lampirans['size'][$i];

                        $ext = pathinfo($lampirans['name'][$i], PATHINFO_EXTENSION);

                        $config['upload_path'] = './uploads/';
                        $config['allowed_types'] = 'gif|jpg|png|pdf|jpeg|txt';
                        $config['max_size'] = 5000; // in Kilobytes
                        $config['file_name'] = $getNewFileName;

                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);

                        if (!$this->upload->do_upload('lampiran')) {
                            // Handle upload error
                            $error = $this->upload->display_errors();
                            // echo $error;
                            // echo FCPATH.'uploads/';
                            $isError = true;
                        } else {
                            // Upload success
                            $upload_data = $this->upload->data();
                            $file_name = $upload_data['file_name']; 
                            $newLampiran = new LampiranModel();
                            $newLampiran->KODE_LAMPIRAN = $getNewFileName.".".$ext;
                            $newLampiran->NO_KOMPLAIN = $nomor_komplain;
                            $newLampiran->TANGGAL = $today;
                            $newLampiran->TIPE = 1; //komplain
                            $newLampiran->insert();
                        }
                    }
                } 
            } 
            if($isError){ 
                $this->session->set_flashdata('message', 'Terdapat error dalam upload lampiran');
                redirect('User/Complained/Penyelesaian/lampiranPage/'.$nomor_komplain);
            }else{
                $subtopik2 = $komplain->SUB_TOPIK2;
                $header = "Sukses menambahkan penyelesaian komplain";
                $template = $this->templateEmailSuccessFeedback($header, $this->UsersModel->getLogin()->NAMA,
                $this->SubTopik2Model->get($subtopik2)->DESKRIPSI);
       
                $resultmail = send_mail($this->UsersModel->getLogin()->EMAIL, 
                $header, $template); 
                // $resultmail = true;
                
                $this->session->unset_userdata('akar');
                $this->session->unset_userdata('preventif');
                $this->session->unset_userdata('korektif');
                $this->session->unset_userdata('tanggalDeadline');


                if($resultmail){ 
                    $this->session->set_flashdata('message', 'Berhasil menyelesaikan komplain, silahkan cek email anda');
                    redirect('User/Complained/Penyelesaian');
                }else{ 
                    $this->session->set_flashdata('message', 'Berhasil menyelesaikan komplain, namun gagal mengirim email');
                    redirect('User/Complained/Penyelesaian');
                }
                
            }
        } 
    }
    public function templateEmailSuccessFeedback($header,$nama, $subtopik2){
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
              <p>Sistem mencatat anda berhasil menambahkan penyelesaian komplain untuk subtopik $subtopik2. Terima kasih atas kerja sama anda.</p> 
            </div>
            <footer>
              <p>&copy; PT UBS - SIB ISTTS</p>
            </footer>
          </body>
        </html>"; 
   }

   public function editPenyelesaianProcess($nomor_komplain){
        $tanggal = $this->input->post('tanggal');
        echo "<pre>";
        var_dump($tanggal);
        echo "</pre>";
        //TODO
   }
}