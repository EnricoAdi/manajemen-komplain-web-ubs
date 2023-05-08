<?php
    //list komplain diajukan user 
    class ListComplain extends CI_Controller {
        public function __construct(){
            parent::__construct();
            $this->data['page_title'] = "User Page";
            $this->data['navigation'] = "Complain";  
            middleware_auth(1); //hak akses user 

            $this->data['login'] = $this->UsersModel->getLogin();
             
            $this->load->library("form_validation");  
            $this->load->library('session');  
        } 
        
        public function index(){
            $data = $this->data;
            $data['page_title'] = "Daftar Komplain Diajukan"; 

            //todo fetch complain user tersebut
            $complains = $this->KomplainAModel->fetchFromUser($data['login']->NOMOR_INDUK,'all'); 
            $data['complains'] = $complains;
            
            loadView_User("user/complain/index",$data); 
 
        }
        public function DeleteComplain($no_komplain){
            
            $complainA = new KomplainAModel();
            $complainA->NO_KOMPLAIN = $no_komplain;

            $komplain = $this->KomplainAModel->get($no_komplain);
            $topik = $komplain->TOPIK; 
            $subtopik1 = $komplain->SUB_TOPIK1;
            $subtopik2 = $komplain->SUB_TOPIK2;    

            $s1 = $this->SubTopik1Model->get($topik,$subtopik1)->DESKRIPSI;
            $s2 = $this->SubTopik2Model->get($topik,$subtopik1,$subtopik2)->DESKRIPSI;
            $message = "Sistem mencatat anda telah menghapus sebuah komplain terkait $s1 - $s2";
            $template = templateEmail("Notifikasi Berhasil Hapus Komplain",$this->UsersModel->getLogin()->NAMA,$message);
            $resultmail = send_mail($this->UsersModel->getLogin()->EMAIL, 
            'Notifikasi Penghapusan Komplain', $template); 

            if($resultmail){ 
                $lampiran = new LampiranModel();
                $lampiran->NO_KOMPLAIN = $no_komplain;
                $lampiran->deleteByKomplain($no_komplain);
                
                $complainB = new KomplainBModel();
                $complainB->NO_KOMPLAIN = $no_komplain;
                $complainB->delete();

                $complainA->delete();

                redirectWith('User/Complain/ListComplain','Komplain berhasil dihapus, silahkan cek email anda'); 
            }else{  
                redirectWith('User/Complain/ListComplain','Komplain gagal dihapus (email tidak terkirim)');
            }
        } 
    }
?>

