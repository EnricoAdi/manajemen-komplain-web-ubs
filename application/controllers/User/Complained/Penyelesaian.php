<?php
//penyelesaian komplain yang ditugaskan kepada user 
class Penyelesaian extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->data['page_title'] = "Halaman Penyelesaian";
        $this->data['navigation'] = "Feedback";

        middleware_auth(1); //hak akses user 
        $this->data['login'] = $this->UsersModel->getLogin(); 
        $this->load->library("form_validation");
        $this->load->library('session'); 
       
    }
    public function index()
    {
        $data = $this->data;
        $data['page_title'] = "Daftar Komplain Ditugaskan";
        

        //fetch complain user tersebut yang statusnya PEND dan belum ada PENUGASAN
        $complains = $this->KomplainAModel->fetchByUserDitugaskan($data['login']->NOMOR_INDUK);
        $data['complains'] = $complains;
        
        
        loadView_User("user/complained/penyelesaian/list", $data);
        
    }

    public function detail($nomor_komplain)
    {
        $data = $this->data;
        $data['page_title'] = "Detail Komplain Ditugaskan";
        

        $komplain = $this->KomplainAModel->get($nomor_komplain);

        middleware_komplainA($nomor_komplain,'User/Complained/Penyelesaian',false,true,true);
        
        $data['komplain'] = $komplain;

        $penerbit = null;
        $penerbit = $this->UsersModel->get($komplain->USER_PENERBIT);
        
        $data['penerbit'] = $penerbit;
        
        loadView_User("user/complained/penyelesaian/detail", $data);
        
    }
    public function addPage($nomor_komplain)
    {
        $data = $this->data;
        $data['page_title'] = "Input Penyelesaian Komplain";
        

        $komplain = $this->KomplainAModel->get($nomor_komplain);

        middleware_komplainA($nomor_komplain,'User/Complained/Penyelesaian',false,true,true);
        $data['minDate'] = date('Y-m-d');
 
        $data['komplain'] = $komplain;

        $data['akar'] = $this->session->userdata('akar');
        $data['preventif'] = $this->session->userdata('preventif');
        $data['korektif'] = $this->session->userdata('korektif');
        $data['tanggalDeadline'] = $this->session->userdata('tanggalDeadline');
     
        if($data['tanggalDeadline']==null){
            $data['tanggalDeadline'] = date('Y-m-d');
        }

        
        loadView_User("user/complained/penyelesaian/tambah-detail", $data);
        
    }
    public function editPage($nomor_komplain)
    {
        $data = $this->data;
        $data['page_title'] = "Input Penyelesaian Komplain";
        

        $data['minDate'] = date('Y-m-d');

        $komplain = $this->KomplainAModel->get($nomor_komplain);

        middleware_komplainA($nomor_komplain,'User/Complained/Penyelesaian',false,true,true);

        $data['komplain'] = $komplain;

        
        loadView_User("user/complained/penyelesaian/edit", $data);
        
    }
    public function lampiranPage($nomor_komplain)
    {
        $data = $this->data;
        $data['page_title'] = "Input Penyelesaian Komplain";
        

        $komplain = $this->KomplainAModel->get($nomor_komplain); 

        middleware_komplainA($nomor_komplain,'User/Complained/Penyelesaian',false,true,true);
         
        $data['komplain'] = $komplain;

        $data['akar'] = $this->session->userdata('akar');
        $data['preventif'] = $this->session->userdata('preventif');
        $data['korektif'] = $this->session->userdata('korektif');
        $data['tanggalDeadline'] = $this->session->userdata('tanggalDeadline');

        
        loadView_User("user/complained/penyelesaian/tambah-lampiran", $data);
        
    }
    public function addPenyelesaianPage1Process($nomor_komplain)
    {
        $komplain = $this->KomplainAModel->get($nomor_komplain);

        middleware_komplainA($nomor_komplain,'User/Complained/Penyelesaian',false,true,true);
        
        $akar = $this->input->post('akar-masalah');
        $preventif = $this->input->post('preventif');
        $korektif = $this->input->post('korektif');
        $tanggalDeadline = $this->input->post('tanggal');

        $tanggalHariIni = date('Y-m-d');

        $this->session->set_userdata('akar', $akar);
        $this->session->set_userdata('preventif', $preventif);
        $this->session->set_userdata('korektif', $korektif);

        if ($tanggalDeadline < $tanggalHariIni) {  
            redirectWith('User/Complained/Penyelesaian/addPage/' . $nomor_komplain, 'Tanggal deadline tidak boleh kurang dari hari ini');
        } else {
            $this->session->set_userdata('tanggalDeadline', $tanggalDeadline);
            redirect('User/Complained/Penyelesaian/lampiranPage/' . $nomor_komplain);
        }
    }
    public function addProcess($nomor_komplain)
    {
        $komplain = $this->KomplainAModel->get($nomor_komplain);

        middleware_komplainA($nomor_komplain,'User/Complained/Penyelesaian',false,true,true);
         
        $akar = $this->session->userdata('akar');
        $preventif  = $this->session->userdata('preventif');
        $korektif = $this->session->userdata('korektif');
        $tanggalDeadline = $this->session->userdata('tanggalDeadline');


        $today = date('Y-m-d');

        if ($akar == null || $preventif == null || $korektif == null || $tanggalDeadline == null) {

            $this->session->set_flashdata('header', 'Pesan');
            $this->session->set_flashdata('message', 'Input tidak lengkap');
            redirect('User/Complained/Penyelesaian/addPage/' . $nomor_komplain);
        } else {
            //update deadline
            $komplain->TGL_DEADLINE = $tanggalDeadline;
            $komplain->TGL_PENANGANAN = $today;
            $komplain->USER_PENANGANAN = $this->UsersModel->getLogin()->NOMOR_INDUK;
            $komplain->updateDeadlinePenyelesaianKomplain();
            $komplain->updatePenyelesaianKomplain();

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

            if ($lampirans['name'][0] != "") {
                if (!file_exists('./uploads/')) {
                    mkdir('./uploads/', 0777, true);
                }
                for ($i = 0; $i < count($lampirans['name']); $i++) {
                    $getNewFileName = 'F_' . generateUID(25);

                    if ($i < count($lampirans)) {
                        $_FILES['lampiran']['name'] = $lampirans['name'][$i];
                        $_FILES['lampiran']['type'] = $lampirans['type'][$i];
                        $_FILES['lampiran']['tmp_name'] = $lampirans['tmp_name'][$i];
                        $_FILES['lampiran']['error'] = $lampirans['error'][$i];
                        $_FILES['lampiran']['size'] = $lampirans['size'][$i];

                        $ext = pathinfo($lampirans['name'][$i], PATHINFO_EXTENSION);

                        $config['upload_path'] = './uploads/';
                        $config['allowed_types'] = 'gif|jpg|png|pdf|jpeg|txt|xlsx|docx|csv';
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
                            $newLampiran->KODE_LAMPIRAN = $getNewFileName . "." . $ext;
                            $newLampiran->NO_KOMPLAIN = $nomor_komplain;
                            $newLampiran->TANGGAL = $today;
                            $newLampiran->TIPE = 1; //komplain
                            $newLampiran->insert();
                        }
                    }
                }
            }
            if ($isError) {
                $this->session->set_flashdata('message', 'Terdapat error dalam upload lampiran');
                redirect('User/Complained/Penyelesaian/lampiranPage/' . $nomor_komplain);
            } else {
                $topik = $komplain->TOPIK;
                $subtopik1 = $komplain->SUB_TOPIK1;
                $subtopik2 = $komplain->SUB_TOPIK2;
                $header = "Sukses menambahkan penyelesaian komplain";
                $template = $this->templateEmailSuccessFeedback(
                    $header,
                    $this->UsersModel->getLogin()->NAMA,
                    $this->SubTopik2Model->get($topik, $subtopik1, $subtopik2)->DESKRIPSI
                );

                $resultmail = send_mail(
                    $this->UsersModel->getLogin()->EMAIL,
                    $header,
                    $template
                );
                // $resultmail = true;

                $this->session->unset_userdata('akar');
                $this->session->unset_userdata('preventif');
                $this->session->unset_userdata('korektif');
                $this->session->unset_userdata('tanggalDeadline');


                if ($resultmail) {
                    $this->session->set_flashdata('message', 'Berhasil menyelesaikan komplain, silahkan cek email anda');
                    redirect('User/Complained/Penyelesaian');
                } else {
                    $this->session->set_flashdata('message', 'Berhasil menyelesaikan komplain, namun gagal mengirim email');
                    redirect('User/Complained/Penyelesaian');
                }
            }
        }
    }
    public function deleteFeedback($nomor_komplain)
    {
        $komplainB = $this->KomplainBModel->get($nomor_komplain);

        middleware_komplainA($nomor_komplain,'User/Complained/Penyelesaian',false,true,true);

        middleware_komplainB($nomor_komplain,'User/Complained/Penyelesaian');
         
        $komplainB->deletePenyelesaianKomplain();
        $lampiran = new LampiranModel();
        $lampiran->NO_KOMPLAIN = $nomor_komplain;
        $lampiran->deleteByKomplainForFeedback();

        $this->session->set_flashdata('header', 'Pesan');
        $this->session->set_flashdata('message', 'Berhasil hapus penyelesaian komplain');
        redirect('User/Complained/Penyelesaian');
    }

    public function DeleteLampiran($nomor_komplain, $kode_lampiran)
    {
        $komplain = $this->KomplainAModel->get($nomor_komplain);
        
        middleware_komplainA($nomor_komplain,'User/Complained/Penyelesaian',false,true,true);
        

        $lampiran = $this->LampiranModel->get($kode_lampiran);
        if ($lampiran == null) {
            $this->session->set_flashdata('header', 'Pesan');
            $this->session->set_flashdata('message', 'Lampiran tidak ditemukan');
            redirect("User/Complained/Penyelesaian/editPage/$nomor_komplain");
        }
        if ($lampiran->TIPE == 0) {
            $this->session->set_flashdata('header', 'Pesan');
            $this->session->set_flashdata('message', 'Lampiran Kompalain tidak dapat dihapus');
            redirect("User/Complained/Penyelesaian/editPage/$nomor_komplain");
        }
        $lampiran->KODE_LAMPIRAN = $kode_lampiran;
        $lampiran->delete();

        $this->session->set_flashdata('header', 'Pesan');
        $this->session->set_flashdata('message', 'Lampiran berhasil dihapus');
        redirect('User/Complained/Penyelesaian/editPage/' . $nomor_komplain);
    }
    public function templateEmailSuccessFeedback($header, $nama, $subtopik2)
    {
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

    public function editPenyelesaianProcess($nomor_komplain)
    {
        $komplainA = $this->KomplainAModel->get($nomor_komplain);
        $komplainB = $this->KomplainBModel->get($nomor_komplain);

        middleware_komplainA($nomor_komplain,'User/Complained/Penyelesaian',false,true,true);
        middleware_komplainB($nomor_komplain,'User/Complained/Penyelesaian');
        
        $akar = $this->input->post('akar');
        $preventif  = $this->input->post('preventif');
        $korektif = $this->input->post('korektif');
        $tanggalDeadline = $this->input->post('tanggal');

        if ($akar == null || $preventif == null || $korektif == null || $tanggalDeadline == null) {
            $this->session->set_flashdata('header', 'Pesan');
            $this->session->set_flashdata('message', 'Input tidak lengkap');
            redirect('User/Complained/Penyelesaian/editPage/' . $nomor_komplain); 
        }

        $komplainA->TGL_DEADLINE = $tanggalDeadline;
        $komplainA->updateDeadlinePenyelesaianKomplain();

        $komplainB->AKAR_MASALAH = $akar;
        $komplainB->T_PREVENTIF = $preventif;
        $komplainB->T_KOREKTIF = $korektif;
        $komplainB->updatePenyelesaianKomplain();

        $today = date('Y-m-d');
        
        $lampirans = $_FILES["lampiran"];
        $isError = false;

        if ($lampirans['name'][0] != "") {
            if (!file_exists('./uploads/')) {
                mkdir('./uploads/', 0777, true);
            }
            for ($i = 0; $i < count($lampirans['name']); $i++) {
                $getNewFileName = 'F_' . generateUID(25);

                if ($i < count($lampirans)) {
                    $_FILES['lampiran']['name'] = $lampirans['name'][$i];
                    $_FILES['lampiran']['type'] = $lampirans['type'][$i];
                    $_FILES['lampiran']['tmp_name'] = $lampirans['tmp_name'][$i];
                    $_FILES['lampiran']['error'] = $lampirans['error'][$i];
                    $_FILES['lampiran']['size'] = $lampirans['size'][$i];

                    $ext = pathinfo($lampirans['name'][$i], PATHINFO_EXTENSION);

                    $config['upload_path'] = './uploads/';
                    $config['allowed_types'] = 'gif|jpg|png|pdf|jpeg|txt|xlsx|docx|csv';
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
                        $newLampiran->KODE_LAMPIRAN = $getNewFileName . "." . $ext;
                        $newLampiran->NO_KOMPLAIN = $nomor_komplain;
                        $newLampiran->TANGGAL = $today;
                        $newLampiran->TIPE = 1; //feedback
                        $newLampiran->insert();
                    }
                }
            }
        }
        
        if ($isError) {
            $this->session->set_flashdata('message', 'Terdapat error dalam upload lampiran');
            redirect('User/Complained/Penyelesaian/editPage/' . $nomor_komplain);
        } else {
            $topik = $komplainA->TOPIK;
            $subtopik1 = $komplainA->SUB_TOPIK1;
            $subtopik2 = $komplainA->SUB_TOPIK2;
            $s2des = $this->SubTopik2Model->get($topik, $subtopik1, $subtopik2)->DESKRIPSI;
            $header = "Sukses mengubah penyelesaian komplain";
            $message = "Sistem mencatat anda mengubah penyelesaian komplain untuk komplain nomor $nomor_komplain . Terima kasih atas kerja sama anda.";
            $template = templateEmail(
                $header,
                $this->UsersModel->getLogin()->NAMA,
                $message
            );

            $resultmail = send_mail(
                $this->UsersModel->getLogin()->EMAIL,
                $header,
                $template
            ); 

            if ($resultmail) {
                $this->session->set_flashdata('message', 'Berhasil mengubah penyelesaian komplain, silahkan cek email anda');
                redirect('User/Complained/Penyelesaian');
            } else {
                $this->session->set_flashdata('message', 'Berhasil mengubah penyelesaian komplain, namun gagal mengirim email');
                redirect('User/Complained/Penyelesaian');
            }
        }



        $this->session->set_flashdata('header', 'Pesan');
        $this->session->set_flashdata('message', 'Berhasil mengubah penyelesaian komplain');
        redirect('User/Complained/Penyelesaian/editPage/' . $nomor_komplain);
    }
}
