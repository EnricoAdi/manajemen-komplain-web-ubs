<?php 
    class User extends CI_Controller{

        public function __construct()
        {
            parent::__construct();
            $this->data['page_title'] = "Halaman Master User Admin";
            $this->data['navigation'] = "Master"; 
    
            $this->load->library("form_validation");
    
            middleware_auth(4); //hak akses admin
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