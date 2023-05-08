<?php
    //transfer komplain yang ditujukan kepada user 
    class Transfer extends CI_Controller {
        public function __construct(){
            parent::__construct();
            $this->data['page_title'] = "User Page";
            $this->data['navigation'] = "ComplainedList";  

            middleware_auth(1); //hak akses user 
            $this->data['login'] = $this->UsersModel->getLogin(); 

            $this->load->library("form_validation");  
            $this->load->library('session');   
        }

        public function index($nomor_komplain){
            $data = $this->data;
            $data['page_title'] = "Transfer Komplain";
            
            middleware_komplainA($nomor_komplain,'User/Complained/ListComplained',false,true,false);

            $komplain = $this->KomplainAModel->get($nomor_komplain); 
     
            $subtopics = $this->SubTopik2Model->fetch(); 
            $data['komplain'] = $komplain;  

            $subtopik2 = $komplain->SUB_TOPIK2;

            $data['subtopics'] = $subtopics; 
            $data['subtopik2'] = $subtopik2; 

            
            loadView_User("user/complained/transfer", $data); 
        }
        public function processTransfer($nomor_komplain){ 
            $komplain = $this->KomplainAModel->get($nomor_komplain); 

            middleware_komplainA($nomor_komplain,'User/Complained/ListComplained',false,true,false);
             
            //process transfer komplain
            $topik = $this->input->post('inputTopik');
            $subTopik1 = $this->input->post('inputSubtopik1');
            $subTopik2 = $this->input->post('inputSubtopik2'); 
            $komplain->TOPIK = $topik;
            $komplain->SUB_TOPIK1 = $subTopik1;
            $komplain->SUB_TOPIK2 = $subTopik2;
            $komplain->updateTransferKomplain(); 
            
            $header = "Sukses melakukan transfer komplain";
            $message = "Sistem telah mencatat anda melakukan transfer atas komplain $nomor_komplain, terima kasih.";
            $template = templateEmail($header, $this->UsersModel->getLogin()->NAMA,
            $message);
            
            $resultmail = send_mail($this->UsersModel->getLogin()->EMAIL, 
            $header, $template); 
            if($resultmail==false){
                $this->session->set_flashdata('header', 'Pesan');
                $this->session->set_flashdata('message', 'Berhasil transfer komplain, namun gagal mengirim email');
                redirect('User/Complained/ListComplained');
            }else{ 
                $this->session->set_flashdata('header', 'Pesan');
                $this->session->set_flashdata('message', 'Berhasil transfer komplain, silahkan cek email');
                redirect('User/Complained/ListComplained');
            }
        }
     
}