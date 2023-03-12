<?php 
class Email extends CI_Controller{
    
    public function __construct()
    {
        parent::__construct();
        $this->data['page_title'] = "Halaman Master Email Admin";
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
         //halaman ini digunakan untuk menampilkan daftar email yang ada
         $data = $this->data;
         $data['page_title'] = "Master Email";
         $data['login'] = $this->UsersModel->getLogin();
 
         $users = $this->UsersModel->fetch();
         $data['users'] = $users;  
         $this->load->view("templates/admin/header", $data);
         $this->load->view("admin/master/email/index", $data);
         $this->load->view("templates/admin/footer", $data);
    }
    public function Add(){ 
         //halaman ini digunakan untuk menampilkan form tambah email
         $data = $this->data;
         $data['page_title'] = "Master Email";
         $data['login'] = $this->UsersModel->getLogin();
 
         $users = $this->UsersModel->fetch();
         $managers = $this->UsersModel->fetchAtasan();
         $users_no_email = $this->UsersModel->fetchWithoutEmail();
         $data['users'] = $users;  
         $data['users_no_email'] =  $users_no_email;
         $data['managers'] =  $managers;
        

         $this->load->view("templates/admin/header", $data);
         $this->load->view("admin/master/email/add", $data);
         $this->load->view("templates/admin/footer", $data);
    }
    public function AddProcess(){ 
        $noInduk_atasan = $this->input->post("inputAtasan"); 
        $noIndukuser =  $this->input->post("user"); 
        $emailUser =  $this->input->post("email_user"); 

        $user = new UsersModel();
        $user->EMAIL = $emailUser;
        $user->NOMOR_INDUK = $noIndukuser;
        $user->KODE_ATASAN = $noInduk_atasan;
        $user->addEmail();
        

        $this->session->set_flashdata('header', 'Pesan');
        $this->session->set_flashdata('message', 'Berhasil Menambah Email User! ');
        redirect('Admin/Master/Email');

    }
    public function Detail($nomor_induk){
        
    }

}