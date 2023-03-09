<?php
    //Master Topik Admin 
    class Topik extends CI_Controller {
        public function __construct(){
            parent::__construct();
            $this->data['page_title'] = "Halaman Master Topik Admin"; 

            $this->load->library("form_validation");   
 
            //middleware
            if($this->UsersModel->getLogin() == null){ 
                $this->session->set_flashdata('header', 'Pesan');
                $this->session->set_flashdata('message', 'Silahkan Login Terlebih Dahulu');
                redirect('Auth');
            }

            //jika tidak ada akses, maka redirect ke halaman dashboard berdasarkan hak aksesnya
            $hak_akses = $this->UsersModel->getLogin()['KODE_HAK_AKSES'];
            if($hak_akses!=4){
                if ($hak_akses == '1') {  
                    redirect('User/Dashboard'); //end user
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
            //halaman ini digunakan untuk menampilkan daftar topik yang ada
            $data = $this->data;
            $data['page_title'] = "Master";
            $data['login'] = $this->UsersModel->getLogin();

            $topics = $this->TopikModel->fetch(); 
            $data['topics'] = $topics;

            $this->load->view("templates/admin/header", $data);
            $this->load->view("admin/master/topik/index", $data);
            $this->load->view("templates/admin/footer", $data); 
        }
        public function Menu(){
            //controller ini digunakan untuk menampilkan menu master topik, nantinya 
            //dari menu ini akan diarahkan ke halaman lain sesuai dengan menu yang dipilih
            $data = $this->data;
            $data['page_title'] = "Master";
            $data['login'] = $this->UsersModel->getLogin();

            $this->load->view("templates/admin/header", $data);
            $this->load->view("admin/master/topik/menu", $data);
            $this->load->view("templates/admin/footer", $data); 
        }
        public function Add(){
            $data = $this->data;
            $data['page_title'] = "Master";
            $data['list_divisi'] = $this->DivisiModel->fetch();
            $data['login'] = $this->UsersModel->getLogin();  
            $this->load->view("templates/admin/header", $data);
            $this->load->view("admin/master/topik/add", $data);
            $this->load->view("templates/admin/footer", $data); 
        }
        public function AddProcess(){
             
            $topik = strtoupper($this->input->post("topik")); 
            $divisi = $this->input->post("divisi");
            $nama = $this->input->post("nama");
            $deskripsi = $this->input->post("deskripsi");
             
            $kode = $this->TopikModel->getNewKode($topik); 
            $newTopik = new TopikModel();
            $newTopik->KODE_TOPIK = $kode;
            $newTopik->AU = 'T';
            $newTopik->NAMA = $nama;
            $newTopik->DIV_TUJUAN = $divisi;
            $newTopik->DESKRIPSI = $deskripsi;
            $newTopik->TOPIK = $topik;

            $newTopik->insert();
            $this->session->set_flashdata('header', 'Pesan');
            $this->session->set_flashdata('message', 'Berhasil Menambahkan Topik ');
            redirect('Admin/Master/Topik'); 
 
        }
        public function Detail($kode){ 
            $data = $this->data;
            $data['page_title'] = "Master";
            $data['list_divisi'] = $this->DivisiModel->fetch();
            $data['login'] = $this->UsersModel->getLogin();  
            $data['topic'] = $this->TopikModel->get($kode); 

            $this->load->view("templates/admin/header", $data);
            $this->load->view("admin/master/topik/edit", $data);
            $this->load->view("templates/admin/footer", $data); 
        }

        public function EditProcess($kode){
            $topik =  $this->input->post("topik"); 
            $divisi = $this->input->post("divisi");
            $nama = $this->input->post("nama");
            $deskripsi = $this->input->post("deskripsi");

            $updateTopik = new TopikModel();
            $updateTopik->KODE_TOPIK = $kode;
            $updateTopik->AU = 'T';
            $updateTopik->NAMA = $nama;
            $updateTopik->DIV_TUJUAN = $divisi;
            $updateTopik->DESKRIPSI = $deskripsi;
            $updateTopik->TOPIK = $topik;
            $updateTopik->update();

            $this->session->set_flashdata('header', 'Pesan');
            $this->session->set_flashdata('message', 'Berhasil Mengubah Topik ');
            redirect('Admin/Master/Topik'); 
        }
    
        public function DeleteProcess($kode){ 
            $topikDelete = new TopikModel();
            $topikDelete->KODE_TOPIK=$kode;
            $topikDelete->delete();
            
            $this->session->set_flashdata('header', 'Pesan');
            $this->session->set_flashdata('message', 'Berhasil Menghapus Topik ');
            redirect('Admin/Master/Topik'); 
        }
    }
