<?php 
    class DetailFeedback extends CI_Controller{
        
        public function __construct(){
            parent::__construct();
            $this->data['page_title'] = "Admin Page"; 
            $this->data['navigation'] = "Laporan"; 
            
            $this->load->library("form_validation");   

            middleware_auth(4); //hak akses admin
 

        }
        public function index(){
            
            $data = $this->data;
            $data['page_title'] = "Laporan Detail Feedback";
            $data['login'] = $this->UsersModel->getLogin();
            $dateNow = date("Y-m-d");
            $data['dateNow'] = $dateNow; 
            
            $data['dateStart'] = $dateNow;
            $data['dateEnd'] = $dateNow;
            
            $data['formattedDateEnd'] = formatDateIndo($data['dateEnd']);
            $data['formattedDateStart'] =  formatDateIndo($data['dateStart']);

            $topics = $this->TopikModel->fetch();
            $data['topics'] = $topics;   
            $data['selectedTopic'] = $topics[0];
                
            loadView_Admin("admin/laporan/detail-feedback", $data); 
        }
    }
