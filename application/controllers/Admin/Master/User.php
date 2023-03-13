<?php 
    class User extends CI_Controller{

        public function __construct()
        {
            parent::__construct();
            $this->data['page_title'] = "Halaman Master User Admin";
            $this->data['navigation'] = "Master"; 
    
            $this->load->library("form_validation");
    
            //code ini digunakan untuk menjadi sebuah midlleware jika user mencoba akses halaman ini tanpa login
            if ($this->UsersModel->getLogin() == null) {
                $this->session->set_flashdata('header', 'Pesan');
                $this->session->set_flashdata('message', 'Silahkan Login Terlebih Dahulu');
                redirect('Auth');
            }
    
            //jika tidak ada akses, maka redirect ke halaman dashboard berdasarkan hak aksesnya
            $hak_akses = $this->UsersModel->getLogin()['KODE_HAK_AKSES'];
            if ($hak_akses != 4) {
                if ($hak_akses == '1') {
                    redirect('User/Dashboard'); //end user
                }
                if ($hak_akses == '2') {
                    redirect('Manager'); //manager
                } else {
                    redirect('GM'); //general manager
                }
            }
        }
    
        public function index(){
             //halaman ini digunakan untuk menampilkan daftar user yang ada
             $data = $this->data;
             $data['page_title'] = "Master User";
             $data['login'] = $this->UsersModel->getLogin();
     
             $users = $this->UsersModel->fetch();
             $data['users'] = $users;  
             $this->load->view("templates/admin/header", $data);
             $this->load->view("admin/master/user/index", $data);
             $this->load->view("templates/admin/footer", $data);
        }

        //todo ester
        public function add(){

        }
    }   
?>