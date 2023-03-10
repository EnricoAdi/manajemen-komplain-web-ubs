<?php
    //admin dashboard
    class Dashboard extends CI_Controller {
        public function __construct(){
            parent::__construct();
            $this->data['page_title'] = "Admin Page"; 
            $this->data['navigation'] = "Dashboard"; 
            
            $this->load->library("form_validation");   


            //middleware
            if($this->UsersModel->getLogin() == null){ 
                $this->session->set_flashdata('header', 'Pesan');
                $this->session->set_flashdata('message', 'Silahkan Login Terlebih Dahulu');
                redirect('Auth');
            }

            //jika tidak ada akses, maka redirect ke halaman dashboard berdasarkan hak aksesnya
            $hak_akses = $this->UsersModel->getLogin()->KODE_HAK_AKSES;
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
            $data = $this->data;
            $data['page_title'] = "Dashboard Admin";
            $data['login'] = $this->UsersModel->getLogin(); 
 
            $this->load->view("templates/admin/header", $data);
            $this->load->view("admin/dashboard", $data);
            $this->load->view("templates/admin/footer", $data);
 
        }
    }
?>

