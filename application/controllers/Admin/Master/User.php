<?php 
    class User extends CI_Controller{

        public function __construct()
        {
            parent::__construct();
            $this->data['page_title'] = "Halaman Master User Admin";
            $this->data['navigation'] = "Master"; 
    
            middleware_auth(4); //hak akses admin
            $this->data['login'] = $this->UsersModel->getLogin();

            $this->load->library("form_validation");
    
        }
    
        public function index(){
             //halaman ini digunakan untuk menampilkan daftar user yang ada
             $data = $this->data;
             $data['page_title'] = "Master User";
     
             $users = $this->UsersModel->fetch();
             $data['users'] = $users;  
             
             loadView_Admin("admin/master/user/index", $data);
        }
 
        public function add(){
            //controller ini digunakan untuk menampilkan halaman input user
            $data = $this->data;
            $data['page_title'] = "Input User";
            $data['list_divisi'] = $this->DivisiModel->fetch();
            $data['list_role'] = $this->RoleModel->fetch();
            loadView_Admin("admin/master/user/add", $data); 
        }
    }   
?>