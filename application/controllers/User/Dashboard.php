<?php
    //dashboard user 
    class Dashboard extends CI_Controller {
        public function __construct(){
            parent::__construct();
            $this->data['page_title'] = "User Page";


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
            $data['page_title'] = "Dashboard End User";
            $data['login'] = $this->UsersModel->getLogin();

            $this->load->view("templates/user/header", $data);
            $this->load->view("user/dashboard", $data);
            $this->load->view("templates/user/footer", $data);
 
        }
    }
?>

