<?php
    //penugasan komplain yang ditujukan kepada user 
    class Penugasan extends CI_Controller {
        public function __construct(){
            parent::__construct();
            $this->data['page_title'] = "Halaman Penugasan";
            $this->data['navigation'] = "Complained";  

            middleware_auth(1); //hak akses user 
            $this->data['login'] = $this->UsersModel->getLogin(); 
            $this->load->library("form_validation");  
            $this->load->library('session');  
    }

    public function index(){ 
        $data = $this->data;
        $data['page_title'] = "Penugasan"; 

        //fetch complain user tersebut yang statusnya PEND dan belum ada PENUGASAN
        $complains = $this->KomplainAModel->fetchForDivisi($data['login']->KODEDIV,'PEND'); 
        $data['complains'] = $complains;
         
        loadView_User("user/complained/list-penugasan", $data);
        
    }

    public function addPage($nomor_komplain){
        $data = $this->data;
        $data['page_title'] = "Input Penugasan"; 

        //fetch complain user tersebut yang statusnya PEND dan belum ada PENUGASAN
        $komplain = $this->KomplainAModel->get($nomor_komplain); 
        middleware_komplainA($nomor_komplain,'User/Complained/Penugasan',false,true,false);
         
        $data['komplain'] = $komplain;  
        
        //fetch list user sedivisi 
        $users = $this->UsersModel->fetchUsersByDivisi($data['login']->KODEDIV,'1');
        $data['users'] = $users;   

        loadView_User("user/complained/isi-penugasan", $data);
       
    }

    /**
     * Isi penugasan komplain adalah fitur yang digunakan untuk menugaskan user dalam sebuah divisi untuk menangani penyelesaian komplain yang sudah diverifikasi. Function ini dapat dijalankan di controller Penugasan pada direktori Complained.
     */
    public function addPenugasan($nomor_komplain){
        $komplain = $this->KomplainAModel->get($nomor_komplain); 

        middleware_komplainA($nomor_komplain,'User/Complained/Penugasan',false,true,false);
         
        if($komplain->PENUGASAN != null){
            redirectWith("User/Complained/Penugasan/addPage/$nomor_komplain",'Penugasan sudah ada');  
        }
        $user =  $this->input->post("user");

        $komplain->PENUGASAN = $user;
        $komplain->updatePenugasanKomplain();
        
        redirectWith("User/Complained/Penugasan/addPage/$nomor_komplain",'Berhasil Menyimpan Penugasan');
    
    }
    /**
     * Hapus penugasan pada sebuah komplain adalah fitur yang digunakan untuk menghapus data user dalam sebuah divisi yang bertugas menangani penyelesaian komplain yang sudah diverifikasi. Function ini dapat dijalankan di controller Penugasan pada direktori Complained.
     */
    public function hapusPenugasan($nomor_komplain){
        $komplain = $this->KomplainAModel->get($nomor_komplain);

        middleware_komplainA($nomor_komplain,'User/Complained/Penugasan',false,true,false);
         
        if($komplain->PENUGASAN == null){ 
            redirectWith("User/Complained/Penugasan/addPage/$nomor_komplain",'Belum ada data penugasan'); 
        }
        $komplain->updateHapusPenugasanKomplain();
        
        redirectWith("User/Complained/Penugasan/addPage/$nomor_komplain",'Berhasil Menghapus Penugasan');
         
    }
}