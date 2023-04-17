<?php
//input komplain baru diajukan user 

class Detail extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->data['page_title'] = "User Page";
        $this->data['navigation'] = "Complain";

        // $this->load->library("form_validation");
        // $this->load->library('session');
        $this->load->library('upload');
        $this->load->library('email');

        //middleware
        if ($this->UsersModel->getLogin() == null) {
            $this->session->set_flashdata('header', 'Pesan');
            $this->session->set_flashdata('message', 'Silahkan Login Terlebih Dahulu');
            redirect('Auth');
        }

        //jika tidak ada akses, maka redirect ke halaman dashboard berdasarkan hak aksesnya
        $hak_akses = $this->UsersModel->getLogin()->KODE_HAK_AKSES;
        if ($hak_akses != 1) {
            if ($hak_akses == '4') {
                redirect('Admin/Dashboard'); //admin
            }
            if ($hak_akses == '2') {
                redirect('Manager'); //manager
            } else {
                redirect('GM'); //general manager
            }
        }
    }
    public function index($nomor_komplain){
        
        $data = $this->data;
        $data['page_title'] = "Detail Komplain Diajukan";
        $data['login'] = $this->UsersModel->getLogin();

        $komplain = $this->KomplainAModel->get($nomor_komplain); 
        if($komplain==null){
            $this->session->set_flashdata('header', 'Pesan');
            $this->session->set_flashdata('message', 'Komplain tidak ditemukan');
            redirect('User/Complain/ListComplain');
        }

        $data['komplain'] = $komplain; 
        $this->load->view("templates/user/header", $data);
        $this->load->view("user/complain/detail/index", $data);
        $this->load->view("templates/user/footer", $data);
    }
    public function edit_page($nomor_komplain){ 
        $data = $this->data;
        $data['page_title'] = "Edit Komplain Diajukan";
        $data['login'] = $this->UsersModel->getLogin();

        $komplain = $this->KomplainAModel->get($nomor_komplain);  
        if($komplain==null){
            $this->session->set_flashdata('header', 'Pesan');
            $this->session->set_flashdata('message', 'Komplain tidak ditemukan');
            redirect('User/Complain/ListComplain');
        }

        $data['komplain'] = $komplain; 

        $data['minDate'] = date('Y-m-d', strtotime('-14 days'));   
        //ambil data subtopik 2, subtopik 1, dan complain selain divisi tersebut
        $subtopics = $this->SubTopik2Model->fetchSubtopikAll($data['login']->KODEDIV,false); 
        $data['subtopics'] = $subtopics;  

        $this->load->view("templates/user/header", $data);
        $this->load->view("user/complain/detail/edit-topic", $data);
        $this->load->view("templates/user/footer", $data);
        
    }
    public function EditKomplain($nomor_komplain){  
         
        $komplain = $this->KomplainAModel->get($nomor_komplain);  
        if($komplain==null){
            $this->session->set_flashdata('header', 'Pesan');
            $this->session->set_flashdata('message', 'Komplain tidak ditemukan');
            redirect('User/Complain/ListComplain');
        }

        // $topik =  $this->input->post("inputTopik");
        // $subtopik1 =  $this->input->post("inputSubtopik1");
        // $subtopik2 =  $this->input->post("inputSubtopik2");
        $tanggal =  $this->input->post("tanggal");

        $tanggalMin = date('Y-m-d', strtotime('-14 days'));
        if($tanggal < $tanggalMin){
            $this->session->set_flashdata('header', 'Pesan');
            $this->session->set_flashdata('message', 'Tanggal tidak boleh lebih dari 14 hari');
            redirect("User/Complain/Detail/edit_page/$nomor_komplain");
        }

        
        $deskripsi = $this->input->post("deskripsi");
        $feedback = $this->input->post("feedback"); 
        $lampirans = $_FILES["lampiran"];
        
        $today = date('Y-m-d');  
         
        // $komplain->TOPIK = $topik;
        // $komplain->SUB_TOPIK1 = $subtopik1;
        // $komplain->SUB_TOPIK2 = $subtopik2; 

        // $tglKejadianOracle = "TO_DATE('$tanggal', 'YYYY-MM-DD')"; 
        $komplain->TGL_KEJADIAN = $tanggal;
         
        $komplain->updateKomplain();  
         
        //update komplainB
        
        $komplainB = $this->KomplainBModel->get($nomor_komplain); 
        $komplainB->DESKRIPSI_MASALAH = $deskripsi;
        $komplainB->updateKomplain(); 
        
        $isError = false;
        if($lampirans['name'][0]!=""){ 
            if (!file_exists('./uploads/')) {
                mkdir('./uploads/', 0777, true);
            } 
            for($i=0;$i < count($lampirans['name']);$i++){
                $getNewFileName = 'K_'. generateUID(25);
                
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
                        $newLampiran->TIPE = 0; //komplain
                        $newLampiran->insert();
                    }
                }
            } 
        }  
        if($isError){ 
            $this->session->set_flashdata('message', 'Terdapat error dalam upload lampiran');
            redirect('User/Complain/Detail/edit_page/'.$nomor_komplain);
        }else{  
            $this->session->set_flashdata('message', 'Berhasil mengubah data komplain');
            redirect('User/Complain/ListComplain'); 
        }
    }
    public function DeleteLampiran($kode_lampiran, $nomor_komplain){ 
        $komplain = $this->KomplainAModel->get($nomor_komplain);  
        if($komplain==null){
            $this->session->set_flashdata('header', 'Pesan');
            $this->session->set_flashdata('message', 'Komplain tidak ditemukan');
            redirect('User/Complain/ListComplain');
        }

        $lampiran = new LampiranModel();
        $lampiran->KODE_LAMPIRAN = $kode_lampiran;
        $lampiran->delete();
        $this->session->set_flashdata('header', 'Pesan');
        $this->session->set_flashdata('message', 'Lampiran berhasil dihapus');
        redirect('User/Complain/Detail/edit_page/'.$nomor_komplain);

    }
}
