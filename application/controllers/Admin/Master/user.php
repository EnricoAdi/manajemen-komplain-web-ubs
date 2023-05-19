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
            $data['listDivisi'] = $this->DivisiModel->fetch(); 
            loadView_Admin("admin/master/user/add", $data); 
        }

        public function detail($nomor_induk){
            $data = $this->data;
            $data['page_title'] = "Input User";
            $user = $this->UsersModel->get($nomor_induk);
            if($user == null){
                redirectWith("Admin/Master/User","User tidak ditemukan");
            } 
            $data['user'] = $user;
            $data['listDivisi'] = $this->DivisiModel->fetch(); 
            loadView_Admin("admin/master/user/edit", $data); 
        }
        public function AddProcess(){
            $nomor_induk = $this->input->post("nomor_induk");

            //cek collision nomor induk
            $user = $this->UsersModel->get($nomor_induk);
            if($user != null){
                redirectWith("Admin/Master/User","Nomor induk sudah digunakan");
            }

            $nama = $this->input->post("nama");
            $divisi = $this->input->post("divisi");
            $hak_akses = $this->input->post("hak_akses");

            $password = $this->input->post("nomor_induk");
            
            $user = new UsersModel();
            $user->NOMOR_INDUK = $nomor_induk;
            $user->NAMA = $nama;
            $user->KODEDIV = $divisi;
            $user->KODE_HAK_AKSES = $hak_akses;
            $user->PASSWORD = $password;
            $user->KODE_ATASAN = null;
            $user->insert();

            redirectWith("Admin/Master/User","Berhasil menambahkan user baru");

        }

        public function EditProcess($nomor_induk){
            $user = $this->UsersModel->get($nomor_induk);
            if($user == null){
                redirectWith("Admin/Master/User","User tidak ditemukan");
            } 
            $nama = $this->input->post("nama");
            $divisi = $this->input->post("divisi");
            $hak_akses = $this->input->post("hak_akses");


            try{
                $user = new UsersModel();
                $user->NOMOR_INDUK = $nomor_induk;
                $user->NAMA = $nama;
                $user->KODEDIV = $divisi;
                $user->KODE_HAK_AKSES = $hak_akses; 
                $user->updateMasterUser();
                redirectWith("Admin/Master/User","Berhasil mengubah user");
            }catch(Exception $e){
                redirectWith("Admin/Master/User/detail/$nomor_induk","Gagal mengubah user");
            }
        }
        public function DeleteProcess($nomor_induk){
            $user = $this->UsersModel->get($nomor_induk);
            if($user == null){
                redirectWith("Admin/Master/User","User tidak ditemukan");
            } 
            try{
                $user = new UsersModel();
                $user->NOMOR_INDUK = $nomor_induk;
                $user->delete();
                redirectWith("Admin/Master/User","Berhasil menghapus user");
            }catch(Exception $e){
                redirectWith("Admin/Master/User/detail/$nomor_induk","Gagal menghapus user");
            }
        }
    }   
?>